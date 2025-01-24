<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Ebook;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if($cart != null){
            $items = $cart->items()->orderBy('updated_at', 'desc')->get();
        }else{
            $items = new Collection();
        }
        return view('frontend.cart.index',compact('items'));
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
            $cart_item->quantity = $request->quantity ?? 1;
            $cart_item->price = $cart_item->quantity * $ebook->price;
            $cart_item->save();
            $cart_count = CartItem::where('cart_id',$cart->id)->count();
            
            return response()->json(['message'=>'The product has been successfully added to your cart!','cart_count'=>$cart_count],200);
        }
        $cart_item->ebook_id = $request->id;
        if ($request->quantity != null) {
            $cart_item->quantity = $cart_item->quantity + $request->quantity;
        }elseif($request->totalQuantity != null){
            $cart_item->quantity = $request->totalQuantity;
        }
         else {
            $cart_item->quantity = $cart_item->quantity + 1;
        }
        $cart_item->price = $cart_item->quantity * $ebook->price;
        if($cart_item->quantity == 0){
            $cart_item->delete();
        }else{
            $cart_item->save();
        }
        $cart_items = CartItem::where('cart_id',$cart->id)->get();
        $cart_count = $cart_items->count();
        $grand_total = $cart_items->sum('price');
        return response()->json(['message'=>'The product has been successfully added to your cart!','cart_count'=>$cart_count,'cart_item'=>$cart_item,'grand_total'=>$grand_total],200);


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

    /**
     * get cart to header
     */
    public function get_items(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        $cart_items = CartItem::select('cart_items.id','cart_items.quantity','cart_items.price','e.thumbnail','e.title')->where('cart_id', $cart->id)->join('ebooks as e','e.id','=','cart_items.ebook_id')->orderBy('cart_items.updated_at','DESC')->limit(2)->get();
        return response()->json($cart ? $cart_items : []);
    }


}
