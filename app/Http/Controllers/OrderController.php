<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductCart;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
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

        $newCount = ProductCart::where('user_id', Auth::id())->sum('quantity');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'newCount' => $newCount
            ]);
        }

        return redirect()->back()->with('success', 'Selection updated.');
    }

    public function viewCart()
    {
        if (Auth::check()) {
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

    public function updateQuantity(Request $request, $id)
    {
        $cartItem = ProductCart::with('product')->findOrFail($id);
        $action = $request->input('action');
        $removed = false;

        if ($action === 'increase') {
            if ($cartItem->quantity < $cartItem->product->product_quantity) {
                $cartItem->increment('quantity');
            } else {
                return response()->json(['success' => false, 'message' => 'Maximum stock reached'], 400);
            }
        } elseif ($action === 'reduce') {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            } else {
                $cartItem->delete();
                $removed = true;
            }
        }

        $userId = Auth::id();
        $cart = ProductCart::where('user_id', $userId)->with('product')->get();
        $newSubtotal = $cart->sum(fn($item) => $item->product->product_price * $item->quantity);
        $newCount = $cart->sum('quantity');

        return response()->json([
            'success' => true,
            'removed' => $removed,
            'newQty' => $removed ? 0 : $cartItem->quantity,
            'newItemTotal' => $removed ? 0 : number_format($cartItem->product->product_price * $cartItem->quantity, 2),
            'newSubtotal' => number_format($newSubtotal, 2),
            'newCount' => $newCount
        ]);
    }

    public function removeCartproduct($id)
    {
        $cartItem = ProductCart::findOrFail($id);
        $cartItem->delete();

        $userId = Auth::id();
        $cart = ProductCart::where('user_id', $userId)->with('product')->get();
        $newSubtotal = $cart->sum(fn($item) => $item->product->product_price * $item->quantity);
        $newCount = $cart->sum('quantity');

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'newSubtotal' => number_format($newSubtotal, 2),
                'newCount' => $newCount
            ]);
        }

        return redirect()->back()->with('success', 'Product Removed');
    }

    public function paymentProcess($orderId, $method)
    {
        $order = Order::with(['payment', 'items.product'])->findOrFail($orderId);

        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('payment.success', compact('order', 'method'));
    }

    public function confirmOrder(Request $request)
    {
        $request->validate([
            'receiver_address' => 'required|string|max:255',
            'receiver_phone'   => 'required|string|max:20',
            'payment_method'   => 'required|in:cod,online_banking,card',
            'bank_name'        => 'required_if:payment_method,online_banking',
            'card_type'        => 'required_if:payment_method,card'
        ]);

        $userId = Auth::id();
        $cartItems = ProductCart::where('user_id', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your selection is empty.');
        }

        foreach ($cartItems as $checkItem) {
            if ($checkItem->product->product_quantity < $checkItem->quantity) {
                $title = $checkItem->product->product_title;
                $checkItem->delete();
                return redirect()->back()->with('error', "Sorry, {$title} is out of stock and has been removed from your selection.");
            }
        }

        try {
            return DB::transaction(function () use ($request, $cartItems, $userId) {
                $total = $cartItems->sum(fn($item) => $item->product->product_price * $item->quantity);
                $lastOrder = Order::where('user_id', $userId)->latest('id')->first();
                $nextNumber = $lastOrder ? (int)$lastOrder->user_order_number + 1 : 1;

                $order = Order::create([
                    'user_id'           => $userId,
                    'user_order_number' => $nextNumber,
                    'receiver_address'  => $request->receiver_address,
                    'receiver_phone'    => $request->receiver_phone,
                    'total_price'       => $total,
                    'payment_method'    => $request->payment_method,
                    'status'            => 'confirmed'
                ]);

                // --- ဒီနေရာမှာ bank_name logic ကို ထည့်လိုက်ပါ ---
                $order->payment()->create([
                    'method'    => $request->payment_method,
                    'amount'    => $total,
                    'status'    => ($request->payment_method === 'cod') ? 'awaiting_delivery' : 'pending',
                    'bank_name' => $request->bank_name ?? $request->card_type ?? null, // ဒီစာကြောင်းလေးပါ
                ]);
                // ------------------------------------------

                foreach ($cartItems as $cartItem) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $cartItem->product_id,
                        'quantity'   => $cartItem->quantity,
                        'price'      => $cartItem->product->product_price,
                    ]);
                    $cartItem->product->decrement('product_quantity', $cartItem->quantity);
                    $cartItem->delete();
                }

                return redirect()->route('payment.success', ['order' => $order->id, 'method' => $request->payment_method])
                    ->with('success', 'Order Placed!');
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
