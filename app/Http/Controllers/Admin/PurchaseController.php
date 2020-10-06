<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
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
        return view('purchase.show', compact('purchase'));
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
        return DataTables::of(Purchase::query()->get())
            ->addIndexColumn()
            ->addColumn('action', function($data){
              $button = '
                <a class="btn btn-success text-light btn-sm" id="duplicate" data-id='.$data->id.'>Duplicate</a>
                <a class="btn btn-info text-light btn-sm" id="show-detail" data-id='.$data->id.'>Show</a>
                <a class="btn btn-warning btn-sm" id="edit" data-id='.$data->id.'>Edit</a>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <a class="btn btn-danger btn-sm text-light" id="delete" data-id='.$data->id.'>Delete</a>
              ';
              return $button;
            })
            ->rawColumns(['action'])
            ->editColumn('status', function(Purchase $purchase){
              return OrderStatus::getString($purchase['status']);
            })
            ->editColumn('marking', function(Purchase $purchase){
              try{
                return Marking::find($purchase['marking'])->name;
              }catch(\Throwable $th){
                return "Marking was removed from the list";
              }
            })
            ->editColumn('item', function(Purchase $purchase){
              try {
                return Item::find($purchase['item'])->name;
              } catch (\Throwable $th) {
                return "Item was removed from the list";
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
        $newOrder->item = $currentOrder->item;
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
