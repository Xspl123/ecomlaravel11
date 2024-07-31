<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index(){
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }


    public function add(Request $request){
        Cart::instance('cart')->add(
            $request->id,
            $request->name,
            $request->quantity,
            $request->price,
        )->associate('App\Models\Product');

        return redirect()->back();
    }

    public function increase_cart_quantity(Request $request, $rowId)
    {
        $prouct = Cart::instance('cart')->get($rowId);
        $qty = $prouct->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity(Request $request, $rowId){
        $prouct = Cart::instance('cart')->get($rowId);
        $qty = $prouct->qty - 1;
        if($qty < 1){
            Cart::instance('cart')->remove($rowId);
        }else {
            Cart::instance('cart')->update($rowId, $qty);
        }
        return redirect()->back();
    }

}
