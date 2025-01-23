<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ebook = Ebook::where('id',$request->id)->first();
        if($ebook == null){
            return response()->json(['message'=>'Ebook not found.',404]);
        }
        $cart = Cart::where('user_id',Auth::user()->id)->first();
        if($cart == null){
            $cart = new Cart();
            $cart->user_id = Auth::user()->id;
            $cart->save();
        }
        $cart_item = CartItem::where('cart_id',$cart->id)->where('ebook_id',$request->id)->first();
        if($cart_item == null){
            $cart_item = new CartItem();
            $cart_item->ebook_id = $request->id;
            $cart_item->cart_id = $cart->id;
            $cart_item->quantity = 1;
            $cart_item->price = $cart_item->quantity * $ebook->price;
            $cart_item->save();
            return response()->json(['message'=>'The product has been successfully added to your cart!'],200);
        }

        $cart_item->ebook_id = $request->id;
        $cart_item->quantity = $cart_item->quantity + 1;
        $cart_item->price = $cart_item->quantity * $ebook->price;
        $cart_item->save();
        return response()->json(['message'=>'The product has been successfully added to your cart!'],200);

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
