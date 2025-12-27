<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use RequestParseBodyException;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }
    public function addCategory(){
        $categories = Category::all();
        return view("admin.addcategory", compact('categories'));
    }
    public function addProductForm()
    {
        $categories = Category::all();
        return view('admin.addproduct', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
        'category_id' => $request->category_id
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function postAddCategory(Request $request){
        $category = new Category();
        $request->validate([
        'category' => 'required|string|max:255|unique:categories',
        ]);
        $category->category = $request->category;
        $category->save();
        return redirect()->route('admin.categories.create')
                 ->with('success','Category added successfully');

    }
    public function viewCategory(Category $category){
        $categories = Category::all();
        return view('admin.viewcategory',compact('categories'));

    }
    public function deleteCategory($id){
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success','Delete Item Successfully');
    }
     public function updateCategory($id){
        $category = Category::findOrFail($id);
        return view('admin.updatecategory',compact('category'));
    }
    public function postUpdateCategory(Request $request, $id){
        $category = Category::findOrFail($id);
       $category->category = $request->category;
       $category->save();
       return redirect()->route('admin.categories.index')
                 ->with('success', 'Updated Successfully!');
    }
    // End of Category Controller

    // Start of Product Controller
    public function addProduct(){
        $categories = Category::all();
        return view('admin.addproduct', compact('categories'));
    }
    public function postAddProduct(Request $request)
    {
        $request->validate([
            'product_title' => 'required|string',
            'product_description' => 'nullable|string',
            'product_quantity' => 'required|integer',
            'product_price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'product_image' => 'required|array',
            'product_image.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

     $imageNames = [];
    if ($request->hasFile('product_image')) {
        foreach ($request->file('product_image') as $file) {
            $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('products', $name, 'public');
            $imageNames[] = $name;
        }
    }

    Product::create([
        'product_title' => $request->product_title,
        'product_description' => $request->product_description,
        'product_quantity' => $request->product_quantity,
        'product_price' => $request->product_price,
        'product_image' => $imageNames, // Save the array here
        'category_id' => $request->category_id,
    ]);

    return redirect()->back()->with('success', 'Product and Gallery added!');
}

    public function viewProduct(Category $category){
        $products = Product::with('category')->paginate(4);
        return view('admin.viewproduct',compact('products'));
    }

    public function deleteProduct($id)
    {
    $product = Product::findOrFail($id);

    $files = Storage::disk('public')->files('products');

    $usedImages = Product::pluck('product_image')->toArray();

    foreach ($files as $file) {
        if (!in_array(basename($file), $usedImages)) {
            Storage::disk('public')->delete($file);
        }
    }

    if ($product->product_image && Storage::disk('public')->exists('products/'.$product->product_image)) {
        Storage::disk('public')->delete('products/'.$product->product_image);
    }

    $product->delete();

    return redirect()->back()->with('success', 'Product deleted successfully');
}

    public function updateProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.updateproduct', compact('product', 'categories'));
    }

    public function postUpdateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'product_title' => 'required|string',
            'product_price' => 'required|numeric',
            'product_quantity' => 'required|integer',
            'product_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_quantity = $request->product_quantity;
        $product->product_price = $request->product_price;
        if ($request->hasFile('product_image')) {

        if ($product->product_image && Storage::disk('public')->exists('products/'.$product->product_image)) {
            Storage::disk('public')->delete('products/'.$product->product_image);
        }

        $imageName = uniqid().'_'.$request->file('product_image')->getClientOriginalName();
        $request->file('product_image')->storeAs('products', $imageName, 'public');

        $product->product_image = $imageName;
        }

        $product->save();

        return redirect()->back()->with('success', 'Product Updated Successfully!');
    }

    
    public function viewOrders(){
        $orders = Order::all();
        return view('admin.vieworder', compact('orders'));
    }

   public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $status = $request->input('status');

        if (in_array($status, ['on_the_way', 'delivered'])) {
            $order->status = $status;
            $order->save();

            return redirect()->back()->with('success', "Order status updated to ".ucfirst(str_replace('_',' ',$status)));
        }

        return redirect()->back()->with('error', 'Invalid status');
    }

}
