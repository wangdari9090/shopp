<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

public function index(Request $request)
{
    if (Auth::check() && Auth::user()->user_type === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    $count = Auth::check() ? ProductCart::where('user_id', Auth::id())->count() : 0;

    $products = Product::paginate(4)->fragment('best-seller-sections');

    if ($request->ajax()) {
        return view('partials.product_list', compact('products'))->render();
    }
    if ($request->section === 'latest-item') {
            return view('partials.new_arrivals_list', compact('newArrivals'))->render();
        }

    $popularProducts = DB::table('products')
        ->join('order_items', 'products.id', '=', 'order_items.product_id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->select(
            'products.id',
            'products.product_title',
            'products.product_price',
            'products.product_image',
            DB::raw('COUNT(order_items.id) as orders_count')
        )
        ->groupBy('products.id', 'products.product_title', 'products.product_price', 'products.product_image')
        ->orderByDesc('orders_count')
        ->limit(4)
        ->get();

    $newArrivals = Product::where('created_at', '>=', now()->subDays(7))->paginate(8)->fragment('new-arrivals');
    $categories = Category::all();

    return view('index', compact('products', 'count', 'categories', 'popularProducts', 'newArrivals'));
}
   public function dashboard()
{
    $categoriesCount = Category::count();
    $productsCount   = Product::count();
    $ordersCount     = Order::count();
    $usersCount      = User::count();

    $categories = Category::all();
    $products   = Product::with('category')->get();
    
    // CHANGE: Load 'items.product' instead of just 'product'
    $orders = Order::with(['user', 'items.product'])->latest()->get();

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
    //     if(Auth::check() && Auth::user()->user_type == 'user'){
    //     $count = ProductCart::where('user_id', Auth::id())->count();
    //     }
    //     else{
    //         $count ="0";
    //     }
    //     $products = Product::latest()->take(8)->get();
    //     $collections = Product::inRandomOrder()
    //     ->take(6)
    //     ->get();
    //     $categories = Category::all();
    //     return view('index',compact('products', 'collections', 'count'));
    // }

    public function categoryProducts($id)
    {
        if(Auth::check() && Auth::user()->user_type == 'user'){
            $count = ProductCart::where('user_id', Auth::id())->count();
        } else {
            $count = 0;
        }

        $category = Category::findOrFail($id);
       $products = $category->products;

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

// User Profile
public function showProfile()
{
    // Auth::user() provides the currently logged in user's data
    return view('user.profile'); 
}

}
