<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Transection;
use App\Models\Employee;
use App\Models\Stock;
use Toastr;

class TransectionController extends Controller
{
    public function index()
    {
        $transections = Transection::all();
        return view('backend.admin.transection.index')->with(compact('transections'));
    }

    public function create()
    {
        $stoks = Stock::where('product_status', 1)->where('is_assigned', 2)->whereNotNull('service_tag')->get();
        $employees = Employee::all();
        return view('backend.admin.transection.create')->with(compact('stoks', 'employees'));
    }

    public function store(Request $request)
    {
        $this->validate($request, array(
            'product'           => 'required|integer',
            'employee'          => 'required|integer',
            'quantity'          => 'required|integer',
            'date_of_issue'  => 'required',
            
        ));
        
        $transection = new Transection();
        $transection->stock_id     = $request->product;
        $transection->employee_id     = $request->employee;
        $transection->quantity     = $request->quantity;
        $transection->issued_date     = $request->date_of_issue;
        $transection->save();


        Stock::where('id',$request->product)->update(['is_assigned'=> 1]);




        Toastr::success(' Succesfully Saved ', 'Success');
        return redirect()->route('admin.transections.index');

        $transections = Transection::all();
        return view('backend.admin.transection.create')->with(compact('transections'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            
            'date_of_return'  => 'required',
            
        ));

       // return $request->all();

        // Transection::where('id',$id)->update(['return_date'=> ]);

        $transection = Transection::find($id);

        $transection->return_date = $request->date_of_return;
        $transection->save();

        Stock::where('id',$transection->stock_id)->update(['is_assigned'=> 2]);

        Toastr::success(' Succesfully Updated ', 'Success');
        return redirect()->back();

        
    }

    public function show($id)
    {
        $transection = Transection::find($id);
        return view('backend.admin.transection.show')->with(compact('transection'));
    }

}
