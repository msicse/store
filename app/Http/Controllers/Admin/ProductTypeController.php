<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producttype;
use Toastr;
use Str;

class ProductTypeController extends Controller
{
    public function index()
    {
         $types = Producttype::latest()->get();
         return view('backend.admin.product-type')->with(compact('types'));
    }
    public function store(Request $request)
    {
        $this->validate($request,array(
            'name' => 'required|max:255|unique:producttypes'
        ));
        //$slug  = str_slug($request->name);
        $role = new Producttype();
        $role->name = $request->name;
        $role->slug = Str::slug($request->name);
        $role->save();
        Toastr::success(' Succesfully Saved ', 'Success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $role = Producttype::find($id);
        $role->delete();
        Toastr::success('Succesfully Deleted ', 'Success');
        return redirect()->back();
    }
}
