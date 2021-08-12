<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Stock;
use Toastr;


class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::all();
        return view('backend.admin.purchase.index')->with(compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('backend.admin.purchase.create')->with(compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, array(
            'product'           => 'required|integer',
            'supplier'          => 'required|integer',
            'total_price'        => 'required',
            'quantity'          => 'required|integer',
            'date_of_purchase'  => 'required',
            
        ));
        //return $request->all();
        $unite = $request->total_price / $request->quantity ;

        
        $purchase = new Purchase();

        $purchase->product_id       = $request->product;
        $purchase->supplier_id      = $request->supplier;
        $purchase->unite_price      = $unite;
        $purchase->quantity         = $request->quantity;
        $purchase->total_price      = $request->total_price;
        $purchase->is_stocked       = 2;
        $purchase->purchase_date    = $request->date_of_purchase;
        $purchase->save();

        Toastr::success(' Succesfully Saved ', 'Success');
        return redirect()->route('admin.purchases.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addInventory($id)
    {
        $data = Purchase::find($id);

       // return $data->product->type;

        if($data->is_stocked == 2){

            if($data->product->type == 1){

                $max_serial = Stock::max('serial_no');

                if (empty($max_serial)){
                    $max_serial = 0;
                }

                $x = 1;

                while( $x <= $data->quantity) {

                    $stock = new Stock();
            
                    $stock->product_id = $data->product_id;
                    $stock->purchase_id = $id;
                    $stock->serial_no = $max_serial + $x;
                    $stock->product_status = 1;
                    $stock->is_assigned = 2;
                    $stock->save();
                    $x++;
        
                }

            } else {
                $x = 1;

                while( $x <= $data->quantity) {

                    $stock = new Stock();
            
                    $stock->product_id = $data->product_id;
                    $stock->purchase_id = $id;
                    $stock->product_status = 1;
                    $stock->is_assigned = 2;
                    $stock->save();
                    $x++;
        
                }
            }
            
            
            $data->is_stocked = 1;
            $data->save();

            Toastr::success(' Succesfully Added to Inventory ', 'Success');
            return redirect()->back();
            
        } else {
            Toastr::error(' Already Added in Inventory ', 'Failed');
            
            return redirect()->back();
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
