<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use RequestParseBodyException;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
public function dashboard() {
    $totalProducts = Product::count();
    $totalMembers = User::where('user_type', 'user')->count(); 
    $totalOrders = Order::count();
    $monthlyRevenue = Order::whereIn('status', ['delivered', 'confirmed'])
                           ->whereMonth('created_at', now()->month)
                           ->sum('total_price');
   $recentOrders = Order::with('user')
                        ->latest()
                        ->paginate(5);

    return view('admin.dashboard', compact(
        'totalProducts', 
        'totalMembers', 
        'totalOrders', 
        'monthlyRevenue',
        'recentOrders'
    ));
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
    if ($product->product_image) {
        $images = is_array($product->product_image) ? $product->product_image : json_decode($product->product_image, true);

        if (!empty($images)) {
            foreach ($images as $filename) {
                $path = 'products/' . $filename;
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
        }
    }
    $product->delete();

    return redirect()->back()->with('success', 'Product and all its images removed.');
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
    
    // 1. Get current images
    $images = $product->product_image ?? [];

    // 2. Handle Deletions (Removing specific old images)
    if ($request->has('remove_images')) {
        foreach ($request->remove_images as $filename) {
            // Delete file from storage
            if (Storage::disk('public')->exists('products/' . $filename)) {
                Storage::disk('public')->delete('products/' . $filename);
            }
            // Remove from the array
            $images = array_diff($images, [$filename]);
        }
    }

    // 3. Handle New Uploads (Adding to the gallery)
    if ($request->hasFile('product_image')) {
        foreach ($request->file('product_image') as $file) {
            $imageName = uniqid() . '_' . $file->getClientOriginalName();
            $file->storeAs('products', $imageName, 'public');
            $images[] = $imageName; // Add new filename to the array
        }
    }

    // 4. Update Product Details
    $product->product_title = $request->product_title;
    $product->product_description = $request->product_description;
    $product->product_quantity = $request->product_quantity;
    $product->product_price = $request->product_price;
    
    // Save the merged/cleaned array (re-index it to ensure JSON is clean)
    $product->product_image = array_values($images);
    $product->save();

    return redirect()->back()->with('success', 'Gallery updated successfully!');
}

    
    public function viewOrders(){
        $orders = Order::with(['product', 'user'])->latest()->paginate(8);
        return view('admin.vieworder', compact('orders'));
    }

 public function updateOrderStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $request->validate([
        'status' => 'required|in:pending,on_the_way,delivered'
    ]);

    $order->status = $request->status;
    $order->save();
    
    $statusName = ucfirst(str_replace('_', ' ', $order->status));
    return redirect()->back()->with('success', "Voucher status updated to {$statusName}");
}

}
