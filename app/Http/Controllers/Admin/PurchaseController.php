<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Marking;
use App\Models\Item;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\OrderStatus;
use DB;

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
      try {
        DB::beginTransaction();
        $quantity = $request->input('quantity');
        $purchase = Purchase::create(request()->except('quantity'));

        $purchaseDetail = [];
        foreach ($quantity as $key => $value) {
          $variant = DB::table('product_variants')->where('id','=',$key)->first();
          $unitPrice = $variant->unit_price;
          $productId = $variant->product_id;
          $subTotal = $value * $unitPrice;
          $purchaseDetail[] = [
            'product_id' => $productId,
            'purchase_id' => $purchase->id,
            'product_variant_id' => $key,
            'quantity' => $value,
            'sub_total' => $subTotal
          ];
        }

        DB::table('purchase_details')->insert($purchaseDetail);
        DB::commit();
        return redirect()->route('purchases.index')->with('status', 'New item successfully added');
      } catch (\Throwable $th) {
        DB::rollback();
        return redirect()->route('purchases.index')->with('error', 'Fail to add item, please try again!');
      }
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
        $purchaseItems = PurchaseDetail::where('purchase_id','=', $purchase->id)->get();
        $productList = [];

        $productIds = [];
        foreach($purchaseItems as $item){
          if(!in_array($item->product_id, $productIds)){
            $productIds[] = $item->product_id;
          };
        }

        foreach($productIds as $id){
          $product = Product::find($id);
          $product->variants = $purchaseItems->where('product_id','=', $id);
          $productList[] = $product;
        }

        return view('purchase.show', compact('purchase','payments','productList'));
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
        $currentDetails = Purchase::where('id','=', $purchase->id)->with('purchaseDetail')->first()->purchaseDetail->toArray();
        $currentDetailIdList = [];
        $newDetailIdList = [];

        try{
          DB::beginTransaction();
          $quantity = $request->input('quantity');
          $purchase->update(request()->except('quantity'));

          foreach ($quantity as $key => $value) {
            $newDetailIdList[] = $key;
            $variant = DB::table('product_variants')->where('id','=',$key)->first();
            $unitPrice = $variant->unit_price;
            $productId = $variant->product_id;
            $subTotal = $value * $unitPrice;
            $newDetail = [
              'product_id' => $productId,
              'purchase_id' => $purchase->id,
              'product_variant_id' => $key,
              'quantity' => $value,
              'sub_total' => $subTotal
            ];

            $existingDetail = PurchaseDetail::where([['purchase_id','=', $purchase->id],['product_variant_id','=', $key]])->first();
            if($existingDetail){
              PurchaseDetail::where([['purchase_id','=', $purchase->id],['product_variant_id','=', $key]])->update($newDetail);
            }else{
              PurchaseDetail::create($newDetail);
            }
          }

          foreach ($currentDetails as $currentDetail) {
            $currentDetailIdList[] = $currentDetail['product_variant_id'];
          }

          foreach ($currentDetailIdList as $currentDetailId) {
            if(!in_array($currentDetailId, $newDetailIdList)){
             PurchaseDetail::where([['purchase_id','=', $purchase->id],['product_variant_id','=', $currentDetailId]])->delete();
            }
          }
          DB::commit();
          return redirect()->route('purchases.index')->with('status', 'Data successfully updated');
        }catch(\Throwable $th){
          dd($th);
          DB::rollback();
          return redirect()->route('purchases.index')->with('error', 'Fail to update the data, please try again!');
        }
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
            ->make(true);
      }

      public function duplicateOrder($id){
       try {
          $currentOrder = Purchase::find($id);
          $purchaseDetails = $currentOrder->purchaseDetail()->get();
          $newOrder = $currentOrder->replicate();
          $newOrder->code = 'PC'.date('YmdHis');
          $newOrder->order_date = date('Y-m-d');
          $newOrder->status = 1;
          DB::beginTransaction();
          $newOrder->save();

          $newPurchaseDetails = [];
          foreach ($purchaseDetails as $pd) {
            $newPurchaseDetails[] = [
              'purchase_id' => $newOrder->id,
              'product_id' => $pd->product_id,
              'product_variant_id' => $pd->product_variant_id,
              'quantity' => $pd->quantity,
              'sub_total' => $pd->sub_total
            ];
          }
          DB::table('purchase_details')->insert($newPurchaseDetails);
          DB::commit();
        } catch (\Throwable $th) {
          DB::rollback();
        }
        return response()->json(['status', 'success']);
      }

      public function purchaseSelect(Request $request){
        $term = trim($request->q);
        if(empty($term)){
            return response()->json([]);
        }
    
        $purchases = Purchase::select('id','code')->where('code', 'like', '%' .$term . '%')->limit(20)->get();
    
        $formattedOrders= [];
        foreach($purchases as $purchase){
            $formattedOrders[] = ['id'=>$purchase->id, 'text'=>$purchase->code];
        }
    
        return response()->json($formattedOrders);
     }

     public function getPurchaseDetails($id){
       $purchaseDetails = PurchaseDetail::where('purchase_id', '=', $id)->get();
       return response()->json($purchaseDetails);
     }

     public function countBadge(){
      $purchases = Purchase::all();
      $waiting = count($purchases->where('status', 1));
      $warehouse = count($purchases->where('status', 2));
      $indonesia = count($purchases->where('status', 3));
      $arrived = count($purchases->where('status', 4));
      $completed = count($purchases->where('status', 5));
      return response()->json([
        'waiting'=> $waiting, 
        'warehouse' => $warehouse, 
        'indonesia' => $indonesia,
        'arrived' => $arrived,
        'completed' => $completed
      ]);
     }
}
