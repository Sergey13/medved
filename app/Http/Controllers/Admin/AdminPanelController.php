<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminPanelController extends Controller
{   
    public function getIndex(Request $request) {
        
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('director')) {

            return redirect('/equipment');
        } else {

            return redirect('/stock/equipments');
        }
    }
}
