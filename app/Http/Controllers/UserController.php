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
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->user_type === 'admin') {
            return redirect()->route('admin.dashboard');
        }


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

        return view('index', compact('products', 'categories', 'popularProducts', 'newArrivals'));
    }
    public function dashboard()
    {
        $categoriesCount = Category::count();
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $usersCount = User::count();

        $categories = Category::all();
        $products = Product::with('category')->get();

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
        return view('contact');
    }

    public function categoryProducts(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products()->paginate(12);

        return view('category_products', compact('category', 'products'));
    }
    public function productDetails($id)
    {
        $product = Product::findOrFail($id);

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->limit(6)
            ->get();

        $inCart = 0;
        if (auth()->check()) {
            $inCart = ProductCart::where('user_id', auth()->id())
                ->where('product_id', $id)
                ->value('quantity') ?? 0;
        }

        $availableStock = $product->product_quantity - $inCart;

        return view('product_details', compact('product', 'related', 'availableStock'));
    }

    public function showProfile()
    {
        return view('user.profile');
    }

    public function validateForm(Request $request)
    {
        $rules = [];
        if ($request->has('email'))
            $rules['email'] = 'required|email|unique:users,email';
        if ($request->has('name'))
            $rules['name'] = 'required|min:3';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        return response()->json(['success' => true]);
    }
}
