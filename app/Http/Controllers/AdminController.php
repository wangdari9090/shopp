<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RequestParseBodyException;

class AdminController extends Controller
{
    public function addCategory(){
        return view("admin.addcategory");
    }
    public function postAddCategory(Request $request){
        $category = new Category();
        $category->category = $request->category;
        $category->save();
        return redirect()->route('admin.addcategory')
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
       return redirect()->route('admin.viewcategory')
                 ->with('success', 'Updated Successfully!');

    //    return redirect()->back()->with('success','Updated Successfully!');
    }
    // End of Category Controller

    // Start of Product Controller
    public function addProduct(){
        return view('admin.addproduct');
    }
    public function postAddProduct(Request $request){
        $product = new Product();
        $product->product_title = $request->product_title;
        $product->product_description = $request->product_description;
        $product->product_quantity = $request->product_quantity;
        $product->product_price = $request->product_price;

        if ($request->hasFile('product_image')) {
        $image = $request->file('product_image');
        $imageName = time() . '.' . $image->extension();
        $image->storeAs('products', $imageName, 'public');
        $product->product_image = $imageName;
    }
    $product->save();

        return redirect()->route('admin.addproduct')->with('success', 'Product added successfully');
    }
    public function viewProduct(Category $category){
        $products = Product::with('category')->paginate(5);
        return view('admin.viewproduct',compact('products'));
    }
    public function deleteProduct($id)
{
    $product = Product::findOrFail($id);

    if ($product->product_image) {
        Storage::disk('public')->delete('products/' . $product->product_image);
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
public function postUpdateProduct(Request $request, $id){

   $request->validate([
        'category_id' => 'exists:categories,id',
    ]);

    $product = Product::findOrFail($id);

    $product->product_title = $request->product_title;
    $product->product_description = $request->product_description;
    $product->product_quantity = $request->product_quantity;
    $product->product_price = $request->product_price;

    // update image
    if ($request->hasFile('product_image')) {
        if ($product->product_image && Storage::exists('public/products/'.$product->product_image)) {
            Storage::delete('public/products/'.$product->product_image);
        }

        // Save new image
        $image = $request->file('product_image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->storeAs('public/products', $imageName);

        $product->product_image = $imageName;
    }

    $product->save();

    return redirect()->back()->with('success', 'Product Updated Successfully!');
    // End of Product Controller
    }

public function searchProduct(Request $request){
    $products = Product::where('product_title', 'LIKE', '%' .$request->search .'%' )
    ->orWhere('product_description', 'LIKE', '%' .$request->search .'%' )
    ->paginate(3);
    return view('admin.viewproduct', compact('products'));
}
// THE END
}
