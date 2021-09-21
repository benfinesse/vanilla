<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Measure;
use App\Models\OfficeProcess;
use App\Models\OfficeSlip;
use App\Models\Product;
use App\Models\Record;
use App\Models\RecordGroup;
use App\Models\RecordItem;
use App\Services\Record\ProcessService;
use App\Traits\General\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordController extends Controller
{
    use Utility;

    protected $processService;

    public function __construct(ProcessService $processService)
    {
        $this->processService = $processService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if(!$user->hasAccess('view_record')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
        $records = Record::where('active', true)->orderBy('id', 'desc')->paginate(30);

        return view('pages.records.index')->with([
            'records'=>$records
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(Request $request)
    {
        $user = $request->user();
        if(!$user->hasAccess('create_record')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }
        $measure = Measure::get();
        $processes = OfficeProcess::get();
        return view('pages.records.create')->with([
            'measures'=>$measure,
            'processes'=>$processes,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if(!$user->hasAccess('create_record')){
            return redirect()->route('dashboard')->withErrors(['You do not have access to the requested action']);
        }

        $user = $request->user();
        $process_id = $request->input('process_id');
        $process = OfficeProcess::whereUuid($process_id)->first();
        if(!empty($process)){
            $data['uuid'] = $this->makeUuid();
            $data['user_id'] = $user->uuid;
            $data['process_id'] = $process_id;
            $data['active'] = true;
            $data['completed'] = false;
            $data['title'] = $user->names. " started ". $process->name." on ". date("M d, Y");
            DB::beginTransaction();
            $record = Record::create($data);
            DB::commit();

            return redirect()->route('record.list', $record->uuid)->withMessage("Record created. Enter details of records.");
        }
        return redirect()->route('record.index')->withErrors(['Resource not found']);
    }

    //Group ID as $gid
    public function manage($uuid, $gid){
        $record = Record::whereUuid($uuid)->first();
        if(!empty($record)){
            $group = Group::whereUuid($gid)->first();
            if(!empty($group)){
                $measure = Measure::get();
                $products = Product::where('group_id', $group->uuid)->get();
                return view('pages.records.manage.record')->with([
                    'measures'=>$measure,
                    'dept'=>$group,
                    'record'=>$record,
                    'products'=>$products
                ]);
            }
        }
        return redirect()->route('record.index')->withErrors(['Resource not found']);
    }

    public function listItems(Request $request, $uuid){

        $message = $request->input('message');

        $record = Record::whereUuid($uuid)->first();
        if(!empty($record)){
            $groups = Group::get();
            $data = RecordGroup::where('record_id', $record->uuid)->get();
            return view('pages.records.manage.list')->with([
                'data'=>$data,
                'record'=>$record,
                'groups'=>$groups,
                'message'=>$message
            ]);
        }
        return redirect()->route('record.index')->withErrors(['Resource not found']);
    }

    public function load(Request $request, $record_id, $group_id){
        $record = Record::whereUuid($record_id)->first();
        if(!empty($record)){
            $group = RecordGroup::where('group_id', $group_id)->where('record_id', $record_id)->first();
            if(!empty($group)){
                $data['record'] = $record;
                $data['group'] = $group;
                $data['group_items'] = $group->RecordItems;
                return response()->json(['success'=>true, 'data'=>$data]);
            }

        }
        return response()->json(['success'=>false]);
    }

    public function editGroupRecord(Request $request, $uuid){

        $refer = $request->header('referer');


        $groupRec = RecordGroup::whereUuid($uuid)->with(['record','group'])->first();
        if(!empty($groupRec)){
            $measures = Measure::get();
            $group = $groupRec->group;
            $products = Product::where('group_id', $group->uuid)->get();
            return view('pages.records.manage.edit_record')->with(
                [
                    'groupRecord'=>$groupRec,
                    'record'=>$groupRec->record,
                    'dept'=>$group,
                    'measures'=>$measures,
                    'referer'=>$refer,
                    'products'=>$products
                ]
            );
        }

        return back()->withErrors(["Resource not found"]);
    }

    public function show(Record $record)
    {
        //
    }

    public function edit(Record $record)
    {
        //
    }


    public function update(Request $request, Record $record)
    {
        //
    }

    public function destroy(Record $record)
    {
        //
    }

    public function pop($uuid){
        $record = Record::whereUuid($uuid)->first();
        if(!empty($record)){
            if(!$record->completed){
                $record->delete();
                return back()->withMessage("One item deleted");
            }else{
                return back()->withErrors(['Cannot modify a completed record.']);
            }
        }
        return back()->withErrors(['Resource not found']);
    }

    public function resendNotice($uuid){
        $record = Record::whereUuid($uuid)->first();
        if(!empty($record)){
            $officeSlip = OfficeSlip::where('record_id', $record->uuid)->where('current', true)->first();
            if(!empty($officeSlip)){
                $office = $officeSlip->office;
                if(!empty($office)){
                    $dname = $record->process->name;
                    $title = "New request for {$dname}.";
                    $url = route('record.audit', $record->uuid);
                    $message = "One new item submitted to {$office->name} for the process : ".$office->process->name;
                    $this->processService->sendOfficeNotice($office, $url, $message, $title);

                    return back()->withMessage("Office notice resent");
                }
            }
        }
        return back()->withErrors(['Could not complete request. Resource not found']);
    }
}
