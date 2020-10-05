<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\PaymentType;
use App\Models\Order;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();
        return view('payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Payment::rules());
        Payment::create(request()->all());
        return redirect()->route('payments.index')->with('status', 'New payment successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::find($id);
        return view('payment.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = Payment::find($id);
        return view('payment.form', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate(Payment::rules());
        $payment->update(request()->all());
        return redirect()->route('payments.index')->with('status', 'Data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $id = $request->input('id');
      Payment::find($id)->delete();
    }

    public function paymentDataTable(Request $request)
    {
        return DataTables::of(Payment::query()->get())
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $btn = '
            <a class="btn btn-warning btn-sm" id="edit" data-id='.$data->id.'>Edit</a>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <a class="btn btn-danger btn-sm text-light" id="delete" data-id='.$data->id.'>Delete</a>
          ';
          return $btn;
        })
        ->rawColumns(['action'])
        ->editColumn('type', function(Payment $payment){
            return PaymentType::getString($payment['type']);
        })
        ->editColumn('purchase_code', function(Payment $payment){
            return Order::find($payment['order_id'])->purchase_code;
        })
        ->make(true);
    }
}
