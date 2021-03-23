<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $recent = Record::orderBy('id', 'desc')->take(8)->get();
        return view('pages.dashboard.index')->with(
            [
                'records'=>$recent
            ]
        );
    }
}
