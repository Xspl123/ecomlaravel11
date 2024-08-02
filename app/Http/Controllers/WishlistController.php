<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
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

}
