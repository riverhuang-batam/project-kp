<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
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
        $request->validate(ProductVariant::rules());
        $photo = $request->file('photo') ?? null;
        $logo = null;
        $filename = null;
        if(!empty($photo)) {
            $filename = $photo->getClientOriginalName();
            $logo = Storage::disk('public')->putFileAs('product', $photo, $filename);
        }
        $product = Product::create(array_merge(Request()->all(), ['photo' => $logo]));

        // variant add
        $variants = $request->get('variants');
        $inputVariant = [];
        foreach($variants as $variant) {
            $inputVariant[$variant['name']] = [
                "product_id" => $product->id,
                "name" => $variant['name'],
                "unit_price" => $variant['unit_price'],
            ];
        }
        $product->variants()->createMany($inputVariant);

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
        $product = Product::with('variants')->where('id', $product->id)->first();
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
        $request->validate(ProductVariant::rules());
        $photo = $request->file('photo') ?? null;
        $logo = $product->photo;
        $filename = null;
        if(!empty($photo)) {
            Storage::disk('public')->delete($product->photo);
            $filename = $photo->getClientOriginalName();
            $logo = Storage::disk('public')->putFileAs('product', $photo, $filename);
        }
        $product->update(array_merge(Request()->all(), ['photo' => $logo]));

        // variant update
        $variants = $request->get('variants');
        $inputVariant = null;
        $productVariants = ProductVariant::where('product_id', $product->id)->get();
        $inputId = array();
        foreach($variants as $variant) {
            array_push($inputId, $variant['id']);
            $inputVariant = [
                "product_id" => $product->id,
                "name" => $variant['name'],
                "unit_price" => $variant['unit_price'],
            ];
            $id = $variant['id'];
            $variant = ProductVariant::updateOrCreate(
                ['id' => $id],
                $inputVariant,
            );
        }
        foreach($productVariants as $productVariant) {
            if(!in_array($productVariant->id, $inputId)) {
                ProductVariant::destroy($productVariant->id);
            }
        }
        return redirect()->route('products.index')->with('status', 'Product successfully updated');
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
        $product->variants()->delete();
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
