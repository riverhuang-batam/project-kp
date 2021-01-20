<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Jurnal;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $product = count(Product::all());
        $supplier = count(Supplier::all());
        $sale = count(Sale::all());
        $purchase = count(Purchase::all());
        $jurnal = count(Jurnal::all());
        $payment = Purchase::all()->sum('grand-total');
        return view('home', compact('product', 'supplier', 'payment', 'sale', 'purchase', 'jurnal'));
    }
}
