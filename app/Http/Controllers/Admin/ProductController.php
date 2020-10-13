<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return view('product.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Product::rules());
        $photo = $request->file('photo') ?? null;
        $logo = null;
        $filename = null;
        if(!empty($photo)) {
            $filename = $photo->getClientOriginalName();
            $logo = Storage::disk('public')->putFileAs('product', $photo, $filename);
        }
        Product::create(array_merge(Request()->all(), ['photo' => $logo]));
        return redirect()->route('products.index')->with('status', 'New Product successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product = Product::find($product->id);
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product = Product::find($product->id);
        return view('product.form', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate(Product::rules($product->id));
        $photo = $request->file('photo') ?? null;
        $logo = null;
        $filename = null;
        if(!empty($photo)) {
            Storage::disk('public')->delete($product->photo);
            $filename = $photo->getClientOriginalName();
            $logo = Storage::disk('public')->putFileAs('product', $photo, $filename);
        }
        $product->update(array_merge(Request()->all(), ['photo' => $logo]));
        return redirect()->route('products.index')->with('status', 'Prodcut successfully updated');
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
        $product = Product::find($id);
        $photo = $product->photo ?? null;
        if($photo != null) {
            Storage::disk('public')->delete($photo);
        }
        $product->delete();
    }

    public function productDataTable(Request $request)
    {
        return DataTables::of(Product::query()->get())
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

    public function productSelect(Request $request)
    {
        $term = trim($request->q);
        if(empty($term)){
            return response()->json([]);
        }

        $products = Product::select('id','name')->where('name', 'like', '%' .$term . '%')->limit(20)->get();

        $formattedItems= [];
        foreach($products as $product){
            $formattedProducts[] = ['id'=>$product->id, 'text'=>$product->name];
        }

        return response()->json($formattedProducts);
    }
}
