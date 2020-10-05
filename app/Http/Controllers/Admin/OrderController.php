<?php

namespace App\Http\Controllers\Admin;

use Maatwebsite\Excel\Facades\Excel as Excel;
use App\Http\Controllers\Controller;
use App\Imports\OrderImport;
use App\Models\Order;
use App\Models\Marking;
use App\Models\Item;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\OrderStatus;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = Order::all();
    return view('order.index', compact('data'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $pc = 'PC'.date('YmdHis');
    return view('order.form', compact('pc'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate(Order::rules());
    Order::create(request()->all());
    return redirect()->route('orders.index')->with('status', 'New item successfully added');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $data = Order::find($id);
    return view('order.show', compact('data'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $data = Order::find($id);
    return view('order.form', compact('data'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Order $order)
  {
    $request->validate(Order::rules());
    $order->update(request()->all());
    return redirect()->route('orders.index')->with('status', 'Data successfully updated');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $id = $request->input('id');
    Order::find($id)->delete();
  }

  public function orderDataTable(Request $request){
    return DataTables::of(Order::query()->get())
        ->addIndexColumn()
        ->addColumn('action', function($data){
          $btn = '
            <a class="btn btn-success text-light btn-sm" id="duplicate" data-id='.$data->id.'>Duplicate</a>
            <a class="btn btn-info text-light btn-sm" id="show-detail" data-id='.$data->id.'>Show</a>
            <a class="btn btn-warning btn-sm" id="edit" data-id='.$data->id.'>Edit</a>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <a class="btn btn-danger btn-sm text-light" id="delete" data-id='.$data->id.'>Delete</a>
          ';
          return $btn;
        })
        ->rawColumns(['action'])
        ->editColumn('status', function(Order $order){
          return OrderStatus::getString($order['status']);
        })
        ->editColumn('marking', function(Order $order){
          try{
            return Marking::find($order['marking'])->name;
          }catch(\Throwable $th){
            return "Marking was removed from the list";
          }
        })
        ->editColumn('items', function(Order $order){
          try {
            return Item::find($order['items'])->name;
          } catch (\Throwable $th) {
            return "Item was removed from the list";
          }
        })
        ->make(true);
  }

  public function duplicateOrder($id){
    $currentOrder = Order::find($id);
    $newOrder = new Order;
    $newOrder->date = date('Y-m-d');
    $newOrder->purchase_code = 'PC'.date('YmdHis');
    $newOrder->status = 1;
    $newOrder->marking = $currentOrder->marking;
    $newOrder->items = $currentOrder->items;
    $newOrder->qty = $currentOrder->qty;
    $newOrder->ctns = $currentOrder->ctns;
    $newOrder->volume = $currentOrder->volume;
    $newOrder->PL = null;
    $newOrder->resi = null;
    $newOrder->remarks = null;
    $newOrder->save();
    return response()->json(['status'=>'success']);
  }
}