<?php

namespace App\Http\Controllers;

// Fix: Ensure these are all correctly imported
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\OrderItem; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Add product to database-based cart
     */
public function addToCart(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:1'
    ]);

    $qtyToAdd = $request->input('quantity', 1);
    
    $cartItem = ProductCart::where('user_id', Auth::id())
                           ->where('product_id', $id)
                           ->first();

    if ($cartItem) {
        $cartItem->increment('quantity', $qtyToAdd);
    } else {
        ProductCart::create([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'quantity' => $qtyToAdd
        ]);
    }

    return redirect()->back()->with('success', 'Selection updated.');
}

    /**
     * View the minimalist cart
     */
    public function viewCart() 
    {
        if (Auth::check()) {
            // Use 'with' to prevent N+1 query issues
            $cart = ProductCart::where('user_id', Auth::id())->with('product')->get();
            $count = $cart->count();

            $subtotal = 0;
            foreach ($cart as $item) {
                $quantity = $item->quantity ?? 1; 
                $subtotal += $item->product->product_price * $quantity;
            }

            return view('viewcart', compact('count', 'cart', 'subtotal'));
        }
        
        return redirect()->route('login');
    }

    public function increaseQuantity($id)
{
    $cartItem = ProductCart::findOrFail($id);
    
    // Check stock before increasing
    if ($cartItem->quantity < $cartItem->product->product_quantity) {
        $cartItem->increment('quantity');
        return redirect()->back();
    }
    
    return redirect()->back()->with('error', 'Maximum stock reached.');
    }

    public function reduceQuantity($id)
    {
        $cartItem = ProductCart::findOrFail($id);

        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } else {
            $cartItem->delete();
        }
        return redirect()->back();
    }
    public function removeCartproduct($id)
    {
        $cart_product = ProductCart::findOrFail($id);
        $cart_product->delete();

        return redirect()->back()->with('success', 'Product Removed from Cart');
    }

public function confirmOrder(Request $request)
{
    $request->validate([
        'receiver_address' => 'required|string|max:255',
        'receiver_phone'   => 'required|string|max:20',
    ]);

    $userId = Auth::id();
    $cartItems = ProductCart::where('user_id', $userId)->with('product')->get();

    if ($cartItems->isEmpty()) {
        return redirect()->back()->with('error', 'Your selection is empty.');
    }

    $order = Order::firstOrCreate(
        [
            'user_id' => $userId,
            'status'  => 'pending' 
        ],
        [
            'receiver_address' => $request->receiver_address,
            'receiver_phone'   => $request->receiver_phone,
            'total_price'      => 0, 
        ]
    );
    $order->update([
        'receiver_address' => $request->receiver_address,
        'receiver_phone'   => $request->receiver_phone,
    ]);

    $runningTotal = $order->total_price;

    foreach ($cartItems as $cartItem) {
        $existingItem = OrderItem::where('order_id', $order->id)
                                 ->where('product_id', $cartItem->product_id)
                                 ->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $cartItem->quantity);
        } else {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity'   => $cartItem->quantity,
                'price'      => $cartItem->product->product_price,
            ]);
        }

        $runningTotal += ($cartItem->product->product_price * $cartItem->quantity);
        $cartItem->product->decrement('product_quantity', $cartItem->quantity);
        $cartItem->delete();
    }

    $order->update([
        'total_price' => $runningTotal,
        'status' => 'confirmed'
    ]);

    return redirect()->route('index')->with('success', 'Order updated in your active voucher.');
}
}