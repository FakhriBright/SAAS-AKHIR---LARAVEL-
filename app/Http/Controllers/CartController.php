<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    /**
     * Display cart items
     */
    public function index()
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        
        $carts = Cart::where('id_pelanggan', $pelanggan->id)
            ->with('paket')
            ->get();
        
        $total = $carts->sum('subtotal');
        $totalItems = $carts->sum('jumlah');
        
        // Format items untuk JSON response
        $items = $carts->map(function($cart) {
            return [
                'id' => $cart->id,
                'paket_id' => $cart->paket_id,
                'nama_paket' => $cart->paket->nama_paket,
                'harga_paket' => $cart->paket->harga_paket,
                'jumlah' => $cart->jumlah,
                'subtotal' => $cart->subtotal,
                'quantity' => $cart->jumlah,
            ];
        });
        
        // Return JSON untuk AJAX request (update ringkasan keranjang)
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'items' => $items,
                'total' => $total,
                'total_items' => $totalItems,
            ]);
        }
        
        // ✅ FIX: Return view dengan path yang benar
        return view('customer.cart.index', compact('carts', 'total', 'totalItems'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request, $paketId)
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        
        $validated = $request->validate([
            'jumlah' => 'required|integer|min:1|max:100'
        ]);
        
        // Cek apakah paket sudah ada di cart
        $cart = Cart::where('id_pelanggan', $pelanggan->id)
            ->where('paket_id', $paketId)
            ->first();
        
        if ($cart) {
            // Update quantity jika sudah ada
            $cart->jumlah += $validated['jumlah'];
            $cart->subtotal = $cart->jumlah * $cart->paket->harga_paket;
            $cart->save();
        } else {
            // Buat cart baru
            $paket = Paket::findOrFail($paketId);
            Cart::create([
                'id_pelanggan' => $pelanggan->id,
                'paket_id' => $paketId,
                'jumlah' => $validated['jumlah'],
                'subtotal' => $validated['jumlah'] * $paket->harga_paket,
            ]);
        }
        
        // Return JSON untuk AJAX
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil ditambahkan ke keranjang',
            ]);
        }
        
        return back()->with('success', 'Item berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        
        $cart = Cart::where('id', $id)
            ->where('id_pelanggan', $pelanggan->id)
            ->firstOrFail();
        
        $validated = $request->validate([
            'jumlah' => 'required|integer|min:1|max:100'
        ]);
        
        $cart->jumlah = $validated['jumlah'];
        $cart->subtotal = $validated['jumlah'] * $cart->paket->harga_paket;
        $cart->save();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Quantity berhasil diupdate',
            ]);
        }
        
        return back()->with('success', 'Quantity berhasil diupdate!');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        
        $cart = Cart::where('id', $id)
            ->where('id_pelanggan', $pelanggan->id)
            ->firstOrFail();
        
        $cart->delete();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus',
            ]);
        }
        
        return back()->with('success', 'Item berhasil dihapus dari keranjang!');
    }

    /**
     * Clear all cart items
     */
    public function clear()
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        
        Cart::where('id_pelanggan', $pelanggan->id)->delete();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Keranjang berhasil dikosongkan',
            ]);
        }
        
        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }
}