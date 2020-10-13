<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Payment;
use App\Models\Marking;
use App\Models\Item;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\OrderStatus;

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
        return view('purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pc = 'PC'.date('YmdHis');
        return view('purchase.form', compact('pc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $quantity = $request->quantity;
      foreach($quantity as $key => $val){
        dump($val);
      }
      dd();
        $request->validate(Purchase::rules());
        Purchase::create(request()->all());
        return redirect()->route('purchases.index')->with('status', 'New item successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        $purchase = Purchase::find($purchase->id);
        $payments = Payment::where('purchase_id','=',$purchase->id)->get();
        return view('purchase.show', compact('purchase','payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        $purchase = Purchase::find($purchase->id);
        return view('purchase.form', compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate(Purchase::rules());
        $purchase->update(request()->all());
        return redirect()->route('purchases.index')->with('status', 'Data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        Purchase::find($id)->delete();
    }

    public function purchaseDataTable(Request $request){
        $data = Purchase::query()->where('status', $request->status)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
              // $button = '
              //   <meta name="csrf-token" content="{{ csrf_token() }}">
              //     <a class="btn btn-success text-light btn-sm m-1" id="duplicate" data-id='.$data->id.'>Duplicate</a>
              //     <a class="btn btn-primary text-light btn-sm m-1" id="payment" data-id='.$data->id.'>Add Payment</a>
              //     <a class="btn btn-info text-light btn-sm m-1" id="show-detail" data-id='.$data->id.'>Show</a>
              //     <a class="btn btn-warning btn-sm m-1" id="edit" data-id='.$data->id.'>Edit</a>
              //     <a class="btn btn-danger btn-sm m-1 text-light" id="delete" data-id='.$data->id.'>Delete</a>
              //   </div>
              // ';
              $button = '
              <div class="dropdown">
              <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Options...
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <button class="dropdown-item" type="button" id="duplicate" data-id='.$data->id.'>Duplicate</button>
                <button class="dropdown-item" type="button" id="payment" data-id='.$data->id.'>Add Payment</button>
                <button class="dropdown-item" type="button" id="show-detail" data-id='.$data->id.'>Show</button>
                <button class="dropdown-item" type="button" id="edit" data-id='.$data->id.'>Edit</button>
                <button class="dropdown-item" type="button" id="delete" data-id='.$data->id.'>Delete</button>
              </div>
              </div>
              ';
              return $button;
            })
            ->rawColumns(['action'])
            ->editColumn('status', function(Purchase $purchase){
              return OrderStatus::getString($purchase['status']);
            })
            // ->editColumn('marking_id', function(Purchase $purchase){
            //   try{
            //     return Marking::find($purchase['marking_id'])->name;
            //   }catch(\Throwable $th){
            //     return null;
            //   }
            // })
            ->editColumn('item_id', function(Purchase $purchase){
              try {
                return Item::find($purchase['item_id'])->name;
              } catch (\Throwable $th) {
                return null;
              } 
            })
            ->make(true);
      }

      public function duplicateOrder($id){
        $currentOrder = Purchase::find($id);
        $newOrder = new Purchase;
        $newOrder->date = date('Y-m-d');
        $newOrder->purchase_code = 'PC'.date('YmdHis');
        $newOrder->status = 1;
        $newOrder->marking = $currentOrder->marking;
        $newOrder->item_id = $currentOrder->item_id;
        $newOrder->quantity = $currentOrder->quantity;
        $newOrder->ctns = $currentOrder->ctns;
        $newOrder->volume = $currentOrder->volume;
        $newOrder->pl = null;
        $newOrder->resi = null;
        $newOrder->remarks = null;
        $newOrder->save();
        return response()->json(['status'=>'success']);
      }

      public function purchaseSelect(Request $request){
        $term = trim($request->q);
        if(empty($term)){
            return response()->json([]);
        }
    
        $purchases = Purchase::select('id','purchase_code')->where('purchase_code', 'like', '%' .$term . '%')->limit(20)->get();
    
        $formattedOrders= [];
        foreach($purchases as $purchase){
            $formattedOrders[] = ['id'=>$purchase->id, 'text'=>$purchase->purchase_code];
        }
    
        return response()->json($formattedOrders);
     }
}
