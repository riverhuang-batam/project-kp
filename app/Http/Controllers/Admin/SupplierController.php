<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Supplier::rules());

        Supplier::create(request()->all());
        return redirect()->route('suppliers.index')->with('status', 'New supplier successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $supplier = Supplier::find($supplier->id);
        return view('supplier.form', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate(Supplier::rules());
        $supplier->update(request()->all());
        return redirect()->route('suppliers.index')->with('status', 'Data successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        Supplier::find($id)->delete();
    }

    public function supplierDataTable(Request $request)
    {
        return DataTables::of(Supplier::query()->get())
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $btn = '
            <a class="btn btn-warning btn-sm" id="edit" data-id=' . $data->id . '>Edit</a>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <a class="btn btn-danger btn-sm text-light" id="delete" data-id=' . $data->id . '>Delete</a>
          ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function supplierSelect(Request $request){
        $term = trim($request->q);
        if(empty($term)){
            return response()->json([]);
        }

        $suppliers = Supplier::select('id','name')->where('name', 'like', '%' .$term . '%')->limit(20)->get();

        $formattedSupplier = [];
        foreach($suppliers as $supplier){
            $formattedSupplier[] = ['id'=>$supplier->id, 'text'=>$supplier->name];
        }

        return response()->json($formattedSupplier);
    }
}
