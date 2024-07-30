<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\Product;
use App\Models\Shop;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all products and paginate them by 10 items per page.
        $products = Product::orderBy('created_at','Desc')->paginate(10);
        return view('shop', compact('products'));
    }


    public function product_details($product_slug)
    {
        $products = Product::where('slug', $product_slug)->first();
        return view('product_details', compact('products'));
    }


}
