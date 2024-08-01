<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $size = $request->query('size') ? $request->query('size') : 10;
        $order = $request->query('order') ? $request->query('order') : '-1';

        $o_column = '';
        $o_order = '';

        switch ($order) {
            case '1':
                $o_column = 'created_at';
                $o_order = 'DESC'; // Date, new to old
                break;
            case '2':
                $o_column = 'created_at';
                $o_order = 'ASC'; // Date, old to new
                break;
            case '3':
                $o_column = 'sale_price';
                $o_order = 'ASC'; // Price, low to hig h
                break;
            case '4':
                $o_column = 'sale_price';
                $o_order = 'DESC'; // Price, high to low
                break;
            default:
                // Default sorting logic
                $o_column = 'id';
                $o_order = 'DESC';
                break;
        }

        $products = Product::orderBy($o_column, $o_order)->paginate($size);
        return view('shop', compact('products', 'size', 'order'));
    }



    public function product_details($product_slug)
    {
        $products = Product::where('slug', $product_slug)->first();
        $rproducts = Product::where('slug', '<>', $product_slug)->get()->take(8);
        return view('product_details', compact('products', 'rproducts'));
    }
}
