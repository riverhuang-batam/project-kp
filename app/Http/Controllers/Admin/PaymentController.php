<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use DataTables;
use App\Helpers\PaymentType;
use App\Models\Purchase;
use Illuminate\Support\Facades\Storage;

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
        $file = $request->file('file_name');
        $validFile = null;
        if(!empty($file)){
            $allowedFile = ['jpg', 'jpeg','png', 'pdf', 'doc', 'docx'];
            $fileName = $file->getClientOriginalName();
            $fileExt = strtolower(last(explode('.', $fileName)));
            $isFileValid = in_array($fileExt, $allowedFile);
            if(!$isFileValid){
                return redirect()->route('payments.create')->with('error', 'File format not allowed, allowed file is [ jpg, jpeg, png, pdf, doc, docx ]');
            }
    
            $fileSize = $file->getSize();
            if($fileSize > 2000000){
                return redirect()->route('payments.create')->with('error', 'Please select file below 2MB');
            }

            $validFile = date('YmdHHmmss') ."_". $fileName;
            $path = Storage::disk('public')->putFileAs('attachment', $file, $validFile);
        }
        Payment::create(array_merge(request()->all(),['file_name' => $validFile]));
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
        $purchase = Purchase::find($payment->order_id);
        if($purchase == null){
            return redirect()->route('payments.index')->with('error', 'Can not edit deleted record');
        }
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
        $file = $request->file('file_name');
        $validFile = null;
        if(!empty($file)){
            $allowedFile = ['jpg', 'jpeg','png', 'pdf', 'doc', 'docx'];
            $fileName = $file->getClientOriginalName();
            $fileExt = strtolower(last(explode('.', $fileName)));
            $isFileValid = in_array($fileExt, $allowedFile);
            if(!$isFileValid){
                return redirect()->route('payments.create')->with('error', 'File format not allowed, allowed file is [ jpg, jpeg, png, pdf, doc, docx ]');
            }
    
            $fileSize = $file->getSize();
            if($fileSize > 2000000){
                return redirect()->route('payments.create')->with('error', 'Please select file below 2MB');
            }

            $validFile = date('YmdHHmmss') ."_". $fileName;
            $path = Storage::disk('public')->putFileAs('attachment', $file, $validFile);
        }
        $payment->update(array_merge(request()->all(), ['file_name' => $validFile]));
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
        ->addColumn('attachment', function($data){
            $link = "No Attachment";
            if($data->file_name != null){
                $link = '<a role="button" class="badge badge-primary text-light mr-2" id="download" data-id='.$data->id.'>Download</a>'.$data->file_name;
            }
          return $link;
        })
        ->rawColumns(['action', 'attachment'])
        ->editColumn('type', function(Payment $payment){
            return PaymentType::getString($payment['type']);
        })
        ->editColumn('purchase_code', function(Payment $payment){
            try {
                return Purchase::find($payment['order_id'])->purchase_code;
            } catch (\Throwable $th) {
                return "This record was deleted";
            }
        })
        ->make(true);
    }

    public function download($id){
        try {
            $fileName = Payment::find($id)->file_name;
            $file = "public/attachment/".$fileName;
            return Storage::download($file);
        } catch (\Throwable $th) {
            return redirect()->route('payments.index')->with('error', 'File not found');
        }
    }

    public function addPayment($id)
    {
        $purchase = Purchase::find($id);
        $purchase_code = [
            'id' => $purchase->id
        ];
        return view('payment.form', compact('purchase_code'));
    }
}
