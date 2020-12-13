<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Marking;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Http\Controllers\Controller;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::all();
        return view('sale.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pc = 'SL'.date('YmdHis');
        return view('sale.form', compact('pc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validate = $request->validate(Sale::rules());
      // try {
      //   DB::beginTransaction();
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $sale = Sale::create(request()->except(['quantity', 'product_id']));
        
        $saleDetail = [];
        
        foreach ($quantity as $key => $value) {
          $product = DB::table('products')->where('id','=',$key)->first();
          $subTotal = $value * $product->unit_price;
          $saleDetail[] = [
            'product_id' => $key,
            'sale_id' => $sale->id,
            'quantity' => $value,
            'sub_total' => $subTotal
          ];
        }

        // DB::table('sale_details')->insert($saleDetail);
        $sale->saleDetail()->createMany($saleDetail);
        // DB::commit();
        return redirect()->route('sales.index')->with('status', 'New item successfully added');
      // } catch (\Throwable $th) {
      //   DB::rollback();
      //   return redirect()->route('sales.index')->with('error', 'Fail to add item, please try again!');
      // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        $sale = Sale::find($sale->id);
        // $payments = Payment::where('sale_id','=',$sale->id)->get();
        $saleItems = SaleDetail::where('sale_id','=', $sale->id)->get();
        $productList = [];

        $productIds = [];
        foreach($saleItems as $item){
          if(!in_array($item->product_id, $productIds)){
            $productIds[] = $item->product_id;
          };
        }

        foreach($productIds as $id){
          $product = Product::find($id);
          $product->variants = $saleItems->where('product_id','=', $id);
          $productList[] = $product;
        }

        return view('sale.show', compact('sale','productList'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $sale = Sale::find($sale->id);
        return view('sale.form', compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate(Sale::rules());
        $currentDetails = Sale::where('id','=', $sale->id)->with('saleDetail')->first()->saleDetail->toArray();
        $currentDetailIdList = [];
        $newDetailIdList = [];

        try{
          DB::beginTransaction();
          $quantity = $request->input('quantity');
          $status = $request->input('status');

          $sale->update(request()->except('quantity'));

          foreach ($quantity as $key => $value) {
            $newDetailIdList[] = $key;
            $product = DB::table('products')->where('id','=',$key)->first();
            $subTotal = $value * $product->unit_price;
            $newDetail = [
              'product_id' => $key,
              'sale_id' => $sale->id,
              'quantity' => $value,
              'sub_total' => $subTotal
            ];

            $existingDetail = SaleDetail::where([['sale_id','=', $sale->id],['product_id','=', $key]])->first();
            if($existingDetail){
              SaleDetail::where([['sale_id','=', $sale->id],['product_id','=', $key]])->update($newDetail);
            }else{
                SaleDetail::create($newDetail);
            }
          }

          foreach ($currentDetails as $currentDetail) {
            $currentDetailIdList[] = $currentDetail['product_id'];
          }

          foreach ($currentDetailIdList as $currentDetailId) {
            if(!in_array($currentDetailId, $newDetailIdList)){
             SaleDetail::where([['sale_id','=', $sale->id],['product_id','=', $currentDetailId]])->delete();
            }
          }
          DB::commit();
          return redirect()->route('sales.index')->with('status', 'Data successfully updated');
        }catch(\Throwable $th){
          dd($th);
          DB::rollback();
          return redirect()->route('sales.index')->with('error', 'Fail to update the data, please try again!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $sale = Sale::find($id);
        $sale->saleDetail()->delete();
        $sale->delete();
    }

    public function saleDataTable(Request $request){
        $data = Sale::query()->get();
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
    
    public function getSaleDetails($id){
        $saleDetails = SaleDetail::where('sale_id', '=', $id)->get();
        return response()->json($saleDetails);
    }
}
