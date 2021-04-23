<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Traits\Auth\AuthTrait;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use AuthTrait;

    public function index(){
        $recent = Record::orderBy('id', 'desc')->take(4)->get();

        return view('pages.dashboard.index')->with(
            [
                'records'=>$recent
            ]
        );
    }
}
