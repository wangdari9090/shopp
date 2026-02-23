<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    private function renderContent($view, $data = [])
    {
        if (request()->ajax()) {
            return view($view, $data)->renderSections()['content'];
        }
        return view($view, $data);
    }

    public function dashboard(Request $request)
    {
        $totalProducts = Product::count();
        $totalMembers = User::where('user_type', 'user')->count();
        $totalOrders = Order::count();
        $monthlyRevenue = Order::whereIn('status', ['delivered', 'confirmed'])
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');
        $recentOrders = Order::with('user')->latest()->paginate(5);

        return $this->renderContent('admin.dashboard', compact(
            'totalProducts',
            'totalMembers',
            'totalOrders',
            'monthlyRevenue',
            'recentOrders'
        ));
    }

    public function addCategory(Request $request)
    {
        $categories = Category::all();
        return $this->renderContent("admin.addcategory", compact('categories'));
    }

    public function viewCategory(Request $request)
    {
        $categories = Category::all();
        return $this->renderContent('admin.viewcategory', compact('categories'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        return $this->renderContent('admin.updatecategory', compact('category'));
    }

    public function addProduct(Request $request)
    {
        $categories = Category::all();
        return $this->renderContent('admin.addproduct', compact('categories'));
    }

    public function viewProduct(Request $request)
    {
        $products = Product::with('category')->paginate(4);
        return $this->renderContent('admin.viewproduct', compact('products'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return $this->renderContent('admin.updateproduct', compact('product', 'categories'));
    }

    public function viewOrders(Request $request)
    {
        $orders = Order::with(['product', 'user'])->latest()->paginate(8);
        return $this->renderContent('admin.vieworder', compact('orders'));
    }

    public function postAddCategory(Request $request)
    {
        $request->validate(['category' => 'required|string|max:255|unique:categories']);
        Category::create(['category' => $request->category]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Category added successfully!']);
        }
        return redirect()->route('admin.categories.create')->with('success', 'Category added successfully');
    }

    public function deleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Category deleted!']);
        }
        return redirect()->back()->with('success', 'Delete Item Successfully');
    }

    public function postUpdateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update(['category' => $request->category]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Category updated successfully!']);
        }
        return redirect()->route('admin.categories.index')->with('success', 'Updated Successfully!');
    }

    public function postAddProduct(Request $request)
    {
        $request->validate([
            'product_title' => 'required|string',
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
            'product_image' => $imageNames,
            'category_id' => $request->category_id,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!'
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product added!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        if ($product->product_image) {
            $images = is_array($product->product_image) ? $product->product_image : json_decode($product->product_image, true);
            foreach ($images as $filename) {
                Storage::disk('public')->delete('products/' . $filename);
            }
        }
        $product->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Product deleted successfully!']);
        }
        return redirect()->back()->with('success', 'Product removed.');
    }

    public function postUpdateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $images = $product->product_image ?? [];

        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $filename) {
                Storage::disk('public')->delete('products/' . $filename);
                $images = array_diff($images, [$filename]);
            }
        }

        if ($request->hasFile('product_image')) {
            foreach ($request->file('product_image') as $file) {
                $imageName = uniqid() . '_' . $file->getClientOriginalName();
                $file->storeAs('products', $imageName, 'public');
                $images[] = $imageName;
            }
        }

        $product->update([
            'product_title' => $request->product_title,
            'product_description' => $request->product_description,
            'product_quantity' => $request->product_quantity,
            'product_price' => $request->product_price,
            'product_image' => array_values($images)
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Product updated successfully!']);
        }
        return redirect()->back()->with('success', 'Gallery updated successfully!');
    }
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        $orders = Order::with(['items.product', 'user', 'payment'])->latest()->paginate(8);
        if ($request->ajax()) {
            return $this->renderContent('admin.vieworder', compact('orders'));
        }

        return back()->with('success', 'Status updated!');
    }
    public function cancelOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'cancelled';
        $order->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Order has been cancelled.'
            ]);
        }

        return back()->with('success', 'Order cancelled successfully.');
    }
}
