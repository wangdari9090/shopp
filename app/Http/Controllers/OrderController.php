<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
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
        $product = Product::findOrFail($id);
        $qtyToAdd = (int) $request->input('quantity', 1);

        $alreadyInCart = ProductCart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        $currentCartQty = $alreadyInCart ? $alreadyInCart->quantity : 0;

        if (($currentCartQty + $qtyToAdd) > $product->product_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available.'
            ], 422);
        }

        if ($alreadyInCart) {
            $alreadyInCart->increment('quantity', $qtyToAdd);
        } else {
            ProductCart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => $qtyToAdd
            ]);
        }


        $newVirtualStock = $product->product_quantity - ($currentCartQty + $qtyToAdd);

        return response()->json([
            'success' => true,
            'newCount' => ProductCart::where('user_id', Auth::id())->sum('quantity'),
            'virtualStock' => $newVirtualStock
        ]);
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->take(4)
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

    public function viewCart()
    {
        if (Auth::check()) {
            $cart = ProductCart::where('user_id', Auth::id())->with('product')->get();
            $count = $cart->sum('quantity');

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
                return response()->json([
                    'success' => false,
                    'message' => 'MAX STOCK REACHED',
                    'limit' => $cartItem->product->product_quantity
                ], 422);
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
            return redirect()->route('orders.index')
                ->with('error', "Hold on! You don't have permission to view that order.");
        }

        return view('payment.success', compact('order', 'method'));
    }

    public function confirmOrder(Request $request)
    {
        $isAjax = $request->ajax() || $request->wantsJson();

        $request->validate([
            'receiver_address' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,online_banking,card',
            'bank_name' => 'required_if:payment_method,online_banking',
            'card_type' => 'required_if:payment_method,card'
        ]);

        $userId = Auth::id();
        $cartItems = ProductCart::where('user_id', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            if ($isAjax) {
                return response()->json(['success' => false, 'message' => 'Your selection is empty.'], 422);
            }
            return redirect()->back()->with('error', 'Your selection is empty.');
        }

        foreach ($cartItems as $checkItem) {
            if ($checkItem->product->product_quantity < $checkItem->quantity) {
                $title = $checkItem->product->product_title;
                ProductCart::find($checkItem->id)?->delete();
                if ($isAjax) {
                    return response()->json(['success' => false, 'message' => "Sorry, {$title} is out of stock and has been removed from your selection."], 422);
                }
                return redirect()->back()->with('error', "Sorry, {$title} is out of stock and has been removed from your selection.");
            }
        }

        // Store checkout details in session — order is NOT created yet
        session([
            'pending_order' => [
                'receiver_address' => $request->receiver_address,
                'receiver_phone' => $request->receiver_phone,
                'payment_method' => $request->payment_method,
                'bank_name' => $request->bank_name,
                'card_type' => $request->card_type,
            ]
        ]);

        if ($isAjax) {
            return response()->json(['success' => true, 'redirect' => route('order.review')]);
        }

        return redirect()->route('order.review');
    }

    public function reviewOrder()
    {
        $pending = session('pending_order');

        if (!$pending) {
            return redirect()->route('cart.index')->with('error', 'No pending order found. Please fill in your details again.');
        }

        $userId = Auth::id();
        $cartItems = ProductCart::where('user_id', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            session()->forget('pending_order');
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(fn($item) => $item->product->product_price * $item->quantity);
        $lastOrder = Order::where('user_id', $userId)->latest('id')->first();
        $nextNumber = $lastOrder ? (int) $lastOrder->user_order_number + 1 : 1;
        $method = $pending['payment_method'];

        return view('payment.success', compact('total', 'nextNumber', 'method'));
    }

    public function finalizeOrder(Request $request)
    {
        $userId = Auth::id();
        $pending = session('pending_order');

        if (!$pending) {
            return response()->json(['success' => false, 'message' => 'Session expired. Please go back and try again.'], 422);
        }

        $cartItems = ProductCart::where('user_id', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.'], 422);
        }

        try {
            DB::transaction(function () use ($pending, $cartItems, $userId, $request) {
                $total = $cartItems->sum(fn($item) => $item->product->product_price * $item->quantity);
                $lastOrder = Order::where('user_id', $userId)->latest('id')->first();
                $nextNumber = $lastOrder ? (int) $lastOrder->user_order_number + 1 : 1;

                $order = Order::create([
                    'user_id' => $userId,
                    'user_order_number' => $nextNumber,
                    'receiver_address' => $pending['receiver_address'],
                    'receiver_phone' => $pending['receiver_phone'],
                    'total_price' => $total,
                    'payment_method' => $pending['payment_method'],
                    'status' => 'confirmed',
                ]);

                $order->payment()->create([
                    'method' => $pending['payment_method'],
                    'amount' => $total,
                    'status' => ($pending['payment_method'] === 'cod') ? 'awaiting_delivery' : 'pending',
                    'bank_name' => $pending['bank_name'] ?? $pending['card_type'] ?? null,
                    'transaction_id' => $request->input('transaction_reference'),
                ]);

                foreach ($cartItems as $cartItem) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->product->product_price,
                    ]);
                    $cartItem->product->decrement('product_quantity', $cartItem->quantity);
                    $cartItem->delete();
                }

                session()->forget('pending_order');
            });

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }
}
