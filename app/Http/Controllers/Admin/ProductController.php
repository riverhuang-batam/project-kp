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
        $product = Product::create($request->all());

        // variant add
        // $variants = $request->get('variants');
        // $inputVariant = [];
        // foreach($variants as $variant) {
        //     $inputVariant[$variant['name']] = [
        //         "product_id" => $product->id,
        //         "name" => $variant['name'],
        //         "unit_price" => $variant['unit_price'],
        //     ];
        // }
        // $product->variants()->createMany($inputVariant);

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
        $request->validate(ProductVariant::rules($product->id));
        $product->update($request->all());

        // variant update
        // $variants = $request->get('variants');
        // $inputVariant = null;
        // $productVariants = ProductVariant::where('product_id', $product->id)->get();
        // $inputId = array();
        // foreach($variants as $variant) {
        //     array_push($inputId, $variant['id']);
        //     $inputVariant = [
        //         "product_id" => $product->id,
        //         "name" => $variant['name'],
        //         "unit_price" => $variant['unit_price'],
        //     ];
        //     $variant = ProductVariant::updateOrCreate(
        //         ['id' => $variant['id']],
        //         $inputVariant,
        //     );
        // }
        // foreach($productVariants as $productVariant) {
        //     if(!in_array($productVariant->id, $inputId)) {
        //         ProductVariant::destroy($productVariant->id);
        //     }
        // }
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
        $product = Product::find($request->input('id'));
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
            <a class="btn btn-warning btn-sm btn-rounded text-dark" id="edit" data-id=' . $data->id . '>Edit</a>
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <a class="btn btn-danger btn-sm btn-rounded text-light" id="delete" data-id=' . $data->id . '>Delete</a>
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

        $products = Product::where('name', 'like', '%' .$term . '%')->limit(20)->get();

        $formattedItems= [];
        foreach($products as $product){
            $formattedItems[] = ['id'=>$product->id, 'text'=>$product->name, 'product' => $product];
        }

        return response()->json($formattedItems);
    }

    public function productSelected($id)
    {
        $products = Product::find($id);
        return response()->json($products);
    }

    public function productDetail($id)
    {
        $product = Product::where('id', '=', $id)->first();
        return response()->json($product);
    }
}
