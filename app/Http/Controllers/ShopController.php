<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;


class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Enable query logging for debugging
        DB::enableQueryLog();

        // Retrieve query parameters with default values
        $size = $request->query('size', 10);
        $order = $request->query('order', '-1');
        $fbrands = $request->query('brands', '');
        $fcategories = $request->query('categories', '');
        $minPrice = $request->query('min_price', 1);
        $maxPrice = $request->query('max_price', 10000);


        // Determine the column and order for sorting
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
                $o_order = 'ASC'; // Price, low to high
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

        // Fetch brands and categories for filtering options
        $brands = Brand::orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();

        // Build the query for products with filters
        $products = Product::where(function($query) use ($fbrands, $fcategories, $minPrice, $maxPrice) {
            if (!empty($fbrands)) {
                $query->whereIn('brand_id', explode(',', $fbrands));
            }
            if (!empty($fcategories)) {
                $query->whereIn('category_id', explode(',', $fcategories));
            }
            if (!is_null($minPrice)) {
                $query->where('sale_price', '>=', $minPrice);
            }
            if (!is_null($maxPrice)) {
                $query->where('sale_price', '<=', $maxPrice);
            }
        })
        ->orderBy($o_column, $o_order)
        ->paginate($size);

        // Return the view with the required data
        return view('shop', compact('products', 'size', 'order', 'brands', 'fbrands', 'categories', 'fcategories', 'minPrice', 'maxPrice'));
    }

    public function product_details($product_slug)
    {
        $products = Product::where('slug', $product_slug)->first();
        $rproducts = Product::where('slug', '<>', $product_slug)->get()->take(8);
        return view('product_details', compact('products', 'rproducts'));
    }
}
