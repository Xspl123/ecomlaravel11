<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Cart::instance('wishlist')->content();
        return view('wishlist', compact('items'));
    }

    public function add_wishlist(Request $request)
    {
        Cart::instance('wishlist')->add(
            $request->id,
            $request->name,
            $request->quantity,
            $request->price
        )->associate('App\Models\Product');

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }

    public function remove_wishlist_item(Request $request, $rowId)
    {
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back();
    }


    public function wishlist_clear()
    {
        Cart::instance('wishlist')->destroy();
        return redirect()->back();
    }


    public function wishlist_move_item(Request $request, $rowId){
        $item = Cart::instance('wishlist')->get($rowId);
        Cart::instance('cart')->add($item->id, $item->name, $item->qty, $item->price)->associate('App\Models\Product');
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back();
    }

}
