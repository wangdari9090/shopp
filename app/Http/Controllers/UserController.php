<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        if(Auth::check() && Auth::user()->user_type == 'user'){
            return view('index');
        }
        else if(Auth::check() && Auth::user()->user_type == 'admin'){

            return view('admin.dashboard');
        }
    }
    public function dashboard()
    {
        $categoriesCount = Category::count();
        $productsCount   = Product::count();
        $ordersCount     = Order::count();
        $usersCount      = User::count();

        $categories = Category::all();
        $products   = Product::with('category')->get();
        $orders     = Order::with(['user','product'])->get();
        return view('admin.dashboard', compact(
            'categoriesCount',
            'productsCount',
            'ordersCount',
            'usersCount',
            'categories',
            'products',
            'orders'
        ));
    }
    public function contact()
    {
        if(Auth::check() && Auth::user()->user_type == 'user'){
        $count = ProductCart::where('user_id', Auth::id())->count();
        }
        else{
            $count = 0;
        }
        return view('contact', compact('count'));
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
        $categories = Category::all();
        return view('index',compact('products', 'collections', 'count'));
    }

    public function categoryProducts($id)
    {
        if(Auth::check() && Auth::user()->user_type == 'user'){
            $count = ProductCart::where('user_id', Auth::id())->count();
        } else {
            $count = 0;
        }

        $category = Category::findOrFail($id);

        $products = Product::where('category_id', $id)->get();

        return view('category_products', compact('category', 'products', 'count'));
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

        $related = Product::where('category_id', $product->category_id)
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
    public function viewCart(){
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
            $cart_item = ProductCart::findOrFail($cart->id);
            $cart_item->delete();
        }

        return redirect()->back()->with('success', 'Order Confirmed');
    }



}
