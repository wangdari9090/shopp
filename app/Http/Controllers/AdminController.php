<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

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

        return redirect()->route('admin.addproduct')->with('success', 'Product added successfully');
    }
    public function viewProduct(Category $category){
        $products = Product::with('category')->get();
        return view('admin.viewproduct',compact('products'));
    }
    // End of Product Controller

}
