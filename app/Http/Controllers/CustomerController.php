<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Paket;
use App\Models\Cart;
use App\Models\JenisPembayaran;
use App\Models\DetailPemesanan;
use App\Models\DetailJenisPembayaran; // ✅ TAMBAHKAN INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Dashboard Pelanggan
     */
    public function dashboard()
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        
        $totalPesanan = Pemesanan::where('id_pelanggan', $pelanggan->id)->count();
        $pesananAktif = Pemesanan::where('id_pelanggan', $pelanggan->id)
            ->whereIn('status_pesan', ['Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir'])
            ->count();
        $pesananSelesai = Pemesanan::where('id_pelanggan', $pelanggan->id)
            ->where('status_pesan', 'Selesai')
            ->count();
        
        $totalBelanja = Pemesanan::where('id_pelanggan', $pelanggan->id)
            ->where('status_pesan', 'Selesai')
            ->sum('total_bayar');
        
        $recentOrders = Pemesanan::where('id_pelanggan', $pelanggan->id)
            ->with('detailPemesanans.paket')
            ->latest()
            ->take(5)
            ->get();
        
        return view('customer.dashboard', compact(
            'totalPesanan', 'pesananAktif', 'pesananSelesai', 'totalBelanja', 'recentOrders'
        ));
    }

    /**
     * Show Catalog
     */
    public function catalog()
    {
        $pakets = Paket::where('status', 'aktif')->paginate(9);
        return view('customer.catalog', compact('pakets'));
    }

    /**
     * Show Orders History
     */
    public function orders()
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        $orders = Pemesanan::where('id_pelanggan', $pelanggan->id)
            ->with(['detailPemesanans.paket', 'jenisPembayaran'])
            ->latest()
            ->paginate(10);
        return view('customer.orders', compact('orders'));
    }

    /**
     * Show Order Detail
     */
    public function showOrder($id)
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        $order = Pemesanan::where('id', $id)
            ->where('id_pelanggan', $pelanggan->id)
            ->with(['detailPemesanans.paket', 'jenisPembayaran', 'pengiriman'])
            ->firstOrFail();
        
        // ✅ AMBIL DETAIL PEMBAYARAN UNTUK METODE YANG DIPILIH
        $paymentDetails = DetailJenisPembayaran::where('id_jenis_pembayaran', $order->id_jenis_bayar)->get();
        
        return view('customer.order-detail', compact('order', 'paymentDetails'));
    }

    /**
     * Cancel Order
     */
    public function cancelOrder($id)
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        $order = Pemesanan::where('id', $id)
            ->where('id_pelanggan', $pelanggan->id)
            ->firstOrFail();
        
        if ($order->status_pesan !== 'Menunggu Konfirmasi') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }
        
        $order->update(['status_pesan' => 'Dibatalkan']);
        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Show Checkout Page
     */
/**
 * Show Checkout Page
 */
public function checkout()
{
    $pelanggan = auth()->guard('pelanggan')->user();
    
    $carts = Cart::where('id_pelanggan', $pelanggan->id)
        ->with('paket')
        ->get();
    
    if ($carts->isEmpty()) {
        return redirect()->route('customer.cart.index')
            ->with('error', 'Keranjang belanja kosong.');
    }
    
    $total = $carts->sum(function($cart) {
        return $cart->subtotal ?? ($cart->jumlah * $cart->paket->harga_paket);
    });
    
    $jenisPembayarans = JenisPembayaran::all();
    
    // ✅ Ambil semua detail pembayaran & group by id_jenis_pembayaran
    $paymentDetails = DetailJenisPembayaran::all()->groupBy('id_jenis_pembayaran');
    
    // Debug: Lihat struktur data
    // \Log::info('Payment Details:', $paymentDetails->toArray());
    
    return view('customer.checkout', compact('carts', 'total', 'jenisPembayarans', 'paymentDetails'));
}

    /**
     * Process Order (Store)
     */
    public function storeOrder(Request $request)
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        
        $validated = $request->validate([
            'tgl_pesan' => 'required|date|after_or_equal:today',
            'id_jenis_bayar' => 'required|exists:jenis_pembayarans,id',
            'catatan' => 'nullable|string|max:1000',
        ]);
        
        try {
            DB::beginTransaction();
            
            $carts = Cart::where('id_pelanggan', $pelanggan->id)
                ->with('paket')
                ->get();
            
            if ($carts->isEmpty()) {
                return back()->with('error', 'Keranjang belanja kosong.');
            }
            
            $noResi = 'RESI-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));
            
            $totalBayar = $carts->sum(function($cart) {
                return $cart->subtotal ?? ($cart->jumlah * $cart->paket->harga_paket);
            });
            
            $pemesanan = Pemesanan::create([
                'id_pelanggan' => $pelanggan->id,
                'id_jenis_bayar' => $validated['id_jenis_bayar'],
                'no_resi' => $noResi,
                'tgl_pesan' => $validated['tgl_pesan'],
                'status_pesan' => 'Menunggu Konfirmasi',
                'total_bayar' => $totalBayar,
                'catatan' => $validated['catatan'] ?? null,
            ]);
            
            foreach ($carts as $cart) {
                $subtotal = $cart->subtotal ?? ($cart->jumlah * $cart->paket->harga_paket);
                
                DetailPemesanan::create([
                    'pemesanan_id' => $pemesanan->id,
                    'paket_id' => $cart->paket_id,
                    'jumlah' => $cart->jumlah,
                    'subtotal' => $subtotal,
                ]);
            }
            
            Cart::where('id_pelanggan', $pelanggan->id)->delete();
            
            DB::commit();
            
            return redirect()->route('customer.order.show', $pemesanan->id)
                ->with('success', '✅ Pesanan berhasil dibuat! No. Resi: ' . $noResi);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', '❌ Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Show Profile
     */
    public function profile()
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        return view('customer.profile', compact('pelanggan'));
    }

    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans,email,' . $pelanggan->id,
            'telepon' => 'required|string',
            'alamat1' => 'required|string',
            'password' => 'nullable|min:6|confirmed',
        ]);
        
        $pelanggan->nama_pelanggan = $validated['nama_pelanggan'];
        $pelanggan->email = $validated['email'];
        $pelanggan->telepon = $validated['telepon'];
        $pelanggan->alamat1 = $validated['alamat1'];
        $pelanggan->alamat2 = $request->alamat2 ?? $pelanggan->alamat2;
        $pelanggan->alamat3 = $request->alamat3 ?? $pelanggan->alamat3;
        
        if (!empty($validated['password'])) {
            $pelanggan->password = Hash::make($validated['password']);
        }
        
        $pelanggan->save();
        
        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}