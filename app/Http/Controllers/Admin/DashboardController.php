<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Stock;

class DashboardController extends Controller
{
    public function index()
    {
        
        $employees = Employee::all();
        $alaptops = Stock::where('product_status', 1)->get();
        $dlaptops = Stock::where('product_status', 3)->get();
        $plaptops = Stock::where('product_status', 2)->get();
        return view('backend.admin.dashboard')->with(compact('employees', 'alaptops', 'plaptops', 'dlaptops' ));
    }
}
