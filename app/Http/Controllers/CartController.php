<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Paket;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Tampilkan keranjang
     */
    public function index()
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        $carts = Cart::where('id_pelanggan', $pelanggan->id)
            ->with('paket')
            ->latest()
            ->get();
        
        $totalBelanja = $carts->sum(function($cart) {
            return $cart->subtotal;
        });
        
        return view('customer.cart.index', compact('carts', 'totalBelanja'));
    }
    
    /**
     * Tambah ke keranjang
     */
    public function add(Request $request, $paketId)
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        
        // Cek apakah paket sudah ada di keranjang
        $cart = Cart::where('id_pelanggan', $pelanggan->id)
            ->where('paket_id', $paketId)
            ->first();
        
        if ($cart) {
            // Kalau ada, tambah jumlah
            $cart->increment('jumlah');
        } else {
            // Kalau belum ada, buat baru
            Cart::create([
                'id_pelanggan' => $pelanggan->id,
                'paket_id' => $paketId,
                'jumlah' => $request->jumlah ?? 1,
            ]);
        }
        
        return back()->with('success', '✅ Paket berhasil ditambahkan ke keranjang!');
    }
    
    /**
     * Update jumlah di keranjang
     */
    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        
        if ($request->jumlah < 1) {
            return back()->with('error', 'Jumlah minimal 1');
        }
        
        $cart->update(['jumlah' => $request->jumlah]);
        
        return back()->with('success', '✅ Keranjang berhasil diupdate!');
    }
    
    /**
     * Hapus item dari keranjang
     */
    public function remove($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        
        return back()->with('success', '🗑️ Item dihapus dari keranjang');
    }
    
    /**
     * Kosongkan keranjang
     */
    public function clear()
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        Cart::where('id_pelanggan', $pelanggan->id)->delete();
        
        return back()->with('success', '🗑️ Keranjang dikosongkan');
    }
}