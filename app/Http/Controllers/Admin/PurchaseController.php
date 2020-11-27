<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Marking;
use App\Models\Supplier;
use App\Models\Item;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\OrderStatus;
use DB;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

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
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $purchase = Purchase::create(request()->except(['quantity', 'product_id']));
        
        $purchaseDetail = [];
        // for($i = 0; $i < count($product_id); $i++) {
        //   $subTotal = $product_id[$i] * $quantity[$i];
        //   $purchaseDetail[] = [
        //     'product_id' => $product_id[$i],
        //     'purchase_id' => $purchase->id,
        //     'quantity' => $quantity[$i],
        //     'sub_total' => $subTotal,
        //   ];
        // }
        
        foreach ($quantity as $key => $value) {
          $product = DB::table('products')->where('id','=',$key)->first();
          $subTotal = $value * $product->unit_price;
          $purchaseDetail[] = [
            'product_id' => $key,
            'purchase_id' => $purchase->id,
            'quantity' => $value,
            'sub_total' => $subTotal
          ];
        }
        // dd($purchaseDetail);

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
        if($purchase->status == 5){
          return redirect()->route('purchases.index')->with('error', 'Completed order not available for edit!'); 
        }
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
          $status = $request->input('status');

          $purchase->update(request()->except('quantity'));

          foreach ($quantity as $key => $value) {
            $newDetailIdList[] = $key;
            $product = DB::table('products')->where('id','=',$key)->first();
            $subTotal = $value * $product->unit_price;
            $newDetail = [
              'product_id' => $key,
              'purchase_id' => $purchase->id,
              'quantity' => $value,
              'sub_total' => $subTotal
            ];

            $existingDetail = PurchaseDetail::where([['purchase_id','=', $purchase->id],['product_id','=', $key]])->first();
            if($existingDetail){
              PurchaseDetail::where([['purchase_id','=', $purchase->id],['product_id','=', $key]])->update($newDetail);
            }else{
              PurchaseDetail::create($newDetail);
            }
          }

          foreach ($currentDetails as $currentDetail) {
            $currentDetailIdList[] = $currentDetail['product_id'];
          }

          foreach ($currentDetailIdList as $currentDetailId) {
            if(!in_array($currentDetailId, $newDetailIdList)){
             PurchaseDetail::where([['purchase_id','=', $purchase->id],['product_id','=', $currentDetailId]])->delete();
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
        $purchase = Purchase::find($id);
        $purchase->purchaseDetail()->delete();
        $purchase->delete();
    }

    public function purchaseDataTable(Request $request){
        $data = Purchase::query()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
              $buttonAll = '
              <div class="d-flex flex-row justify-content-center">
                <div class="dropdown mr-2">
                  <button class="btn btn-primary btn-rounded btn-sm dropdown-toggle" type="button" id="optionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Options
                  </button>
                  <div class="dropdown-menu" aria-labelledby="optionMenu">
                    <button class="dropdown-item" type="button" id="payment" data-id='.$data->id.'>Add Payment</button>
                    <button class="dropdown-item" type="button" id="invoice" data-id='.$data->id.'>Print Invoice</button>
                    <button class="dropdown-item" type="button" id="show-detail" data-id='.$data->id.'>Show</button>
                    <button class="dropdown-item" type="button" id="edit" data-id='.$data->id.'>Edit</button>
                    <button class="dropdown-item" type="button" id="delete" data-id='.$data->id.'>Delete</button>
                  </div>
                </div>';
              return $buttonAll;
            })
            ->rawColumns(['action'])
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

    //  public function countBadge(){
    //   $purchases = Purchase::all();
    //   $waiting = count($purchases->where('status', 1));
    //   $warehouse = count($purchases->where('status', 2));
    //   $indonesia = count($purchases->where('status', 3));
    //   $arrived = count($purchases->where('status', 4));
    //   $completed = count($purchases->where('status', 5));
    //   return response()->json([
    //     'waiting'=> $waiting, 
    //     'warehouse' => $warehouse, 
    //     'indonesia' => $indonesia,
    //     'arrived' => $arrived,
    //     'completed' => $completed
    //   ]);
    //  }

     public function totalPayment($id){
       $total = Purchase::find($id)->grand_total;
       return response()->json(['total' => $total]);
     }

     public function invoice($id){
      $purchase = Purchase::find($id);
      $supplierDetail = Supplier::find($purchase->supplier_id);
      $supplier = new Party([
        'name' => $supplierDetail->name,
        'phone' => $supplierDetail->phone,
        'address' => $supplierDetail->address,
      ]);
      $buyer = new Party([
        'name' => 'Admin'
      ]);
      $purchaseDetail = $purchase->purchaseDetail;
      
      $items = [];
      foreach($purchase->purchaseDetail as $detail => $value) {
        $productName = Product::find($value->product_id)->name;
        $items[] = (new InvoiceItem())->title($productName)->pricePerUnit(floatval($value->sub_total))->quantity($value->quantity);
      }

      $invoice = Invoice::make()
        ->name('Purchase')
        ->seller($supplier)
        ->buyer($supplier)
        ->currencySymbol('Rp.')
        ->currencyCode('IDR')
        ->currencyFormat('{SYMBOL}{VALUE}')
        ->addItems($items)
        ->template('purchase');

      return $invoice->stream();
     }

    //  public function updateStatus(Request $request){
    //   $id = $request->input('id');
    //   $status = $request->input('status');

    //   $purchase = Purchase::find($id);
    //   if($purchase->status == 5){
    //     return response()->json(['error' => 'Can not update completed order']);
    //   }
    //   $purchase->status = $status;
    //   $purchase->save();

    //   return response()->json();
    // }
}
