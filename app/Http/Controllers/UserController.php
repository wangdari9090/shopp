<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->user_type == 'user'){
            return view('dashboard');
        }
        else if(Auth::check() && Auth::user()->user_type == 'admin'){

            return view('admin.dashboard');
        }
    }
    public function home(){
        if(Auth::check() && Auth::user()->user_type == 'user'){
        $count = ProductCart::where('user_id', Auth::id())->count();
        }
        else{
            $count ="0";
        }
        $products = Product::latest()->take(8)->get();
        $collections = Product::inRandomOrder()
        ->take(6)
        ->get();
        return view('index',compact('products', 'collections', 'count'));

    }
   public function productDetails($id)
    {
        if(Auth::check() && Auth::user()->user_type == 'user'){
        $count = ProductCart::where('user_id', Auth::id())->count();
        }
        else{
            $count = 0;
        }

        $product = Product::with('category')->findOrFail($id);

        $related = Product::where('product_category', $product->product_category)
                        ->where('id', '!=', $id)
                        ->take(6)
                        ->get();

        return view('product_details', compact('product', 'related', 'count'));

    }
    public function addToCart($id){

    $product = Product::findOrFail($id);

    $product_cart = new ProductCart();
    $product_cart->user_id = Auth::id();
    $product_cart->product_id = $product->id;

    $product_cart->save();
    return redirect()->back()->with('success','Added to Cart');

    }
    public function viewCart($id){
         if(Auth::check() && Auth::user()->user_type == 'user'){
            $count = ProductCart::where('user_id', Auth::id())->count();
            $cart = ProductCart::where('user_id', Auth::id())->get();
        }
        else{
            $count = 0;
        }
        return view('viewcart', compact('count', 'cart'));
    }

    public function removeCartproduct($id){
        $cart_product = ProductCart::findOrFail($id);
        $cart_product->delete();
        return redirect()->back()->with('success','Product Removed from Cart');
    }
    public function confirmOrder(Request $request)
    {
        $cart_products = ProductCart::where('user_id', Auth::id())->get();

        $address = $request->receiver_address;
        $phone   = $request->receiver_phone;

        foreach ($cart_products as $cart_product) {

            $order = new Order();
            $order->receiver_address = $address;
            $order->receiver_phone   = $phone;
            $order->user_id          = Auth::id();
            $order->product_id       = $cart_product->product_id;
            $order->save();
        }
        $carts = ProductCart::where('user_id', Auth::id())->get();

        foreach ($carts as $cart) {
            $cart_item = ProductCart::find($cart->id);
            $cart_item->delete();
        }

        return redirect()->back()->with('confirm_order', 'Order Confirmed');
    }



}
