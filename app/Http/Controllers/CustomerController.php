<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Paket;
use App\Models\Cart;
use App\Models\JenisPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Dashboard Pelanggan
     */
    public function dashboard()
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        
        // Statistik
        $totalPesanan = Pemesanan::where('id_pelanggan', $pelanggan->id)->count();
        $pesananAktif = Pemesanan::where('id_pelanggan', $pelanggan->id)
            ->whereIn('status_pesan', ['Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir'])
            ->count();
        $pesananSelesai = Pemesanan::where('id_pelanggan', $pelanggan->id)
            ->where('status_pesan', 'Selesai')
            ->count();
        
        // Total belanja
        $totalBelanja = Pemesanan::where('id_pelanggan', $pelanggan->id)
            ->where('status_pesan', 'Selesai')
            ->sum('total_bayar');
        
        // 5 Pesanan terakhir
        $recentOrders = Pemesanan::where('id_pelanggan', $pelanggan->id)
            ->with('detailPemesanans.paket')
            ->latest()
            ->take(5)
            ->get();
        
        return view('customer.dashboard', compact(
            'totalPesanan',
            'pesananAktif',
            'pesananSelesai',
            'totalBelanja',
            'recentOrders'
        ));
    }

    /**
     * Show Catalog
     */
public function catalog()
{
    // Hapus where('status', 'aktif') karena kolom 'status' nggak ada
    $pakets = Paket::paginate(9);
    return view('customer.catalog', compact('pakets'));
}

    /**
     * Show Orders History
     */
    public function orders()
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        $orders = Pemesanan::where('id_pelanggan', $pelanggan->id)
            ->with('detailPemesanans.paket')
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
            ->with(['detailPemesanans.paket', 'pengiriman'])
            ->firstOrFail();
        return view('customer.order-detail', compact('order'));
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
        
        // Hanya bisa batal jika status masih "Menunggu Konfirmasi"
        if ($order->status_pesan !== 'Menunggu Konfirmasi') {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan.');
        }
        
        $order->update(['status_pesan' => 'Dibatalkan']);
        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Show Checkout Page
     */
    public function checkout(Request $request)
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        
        // Ambil cart IDs dari query string atau session
        $cartIds = $request->query('cart_ids') 
            ? explode(',', $request->query('cart_ids'))
            : session('cart_ids', []);
        
        $carts = Cart::where('id_pelanggan', $pelanggan->id)
            ->whereIn('id', $cartIds)
            ->with('paket')
            ->get();
        
        if ($carts->isEmpty()) {
            return redirect()->route('customer.cart.index')->with('error', 'Keranjang kosong.');
        }
        
        $totalBelanja = $carts->sum('subtotal');
        $jenisPembayarans = JenisPembayaran::all();
        
        return view('customer.checkout', compact('carts', 'totalBelanja', 'jenisPembayarans'));
    }

    /**
     * Process Order
     */
    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'cart_ids' => 'required|string',
            'tgl_pesan' => 'required|date|after_or_equal:today',
            'id_jenis_bayar' => 'required|exists:jenis_pembayarans,id',
            'catatan' => 'nullable|string|max:1000',
        ]);
        
        try {
            DB::beginTransaction();
            
            $pelanggan = auth()->guard('pelanggan')->user();
            $ids = explode(',', $validated['cart_ids']);
            
            $carts = Cart::where('id_pelanggan', $pelanggan->id)
                ->whereIn('id', $ids)
                ->with('paket')
                ->get();
            
            if ($carts->isEmpty()) {
                return back()->with('error', 'Item di keranjang tidak valid.');
            }
            
            // Generate No. Resi
            $noResi = 'RESI-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));
            
            // Hitung total & siapkan detail
            $totalBayar = 0;
            $detailData = [];
            
            foreach ($carts as $cart) {
                $subtotal = $cart->paket->harga_paket * $cart->jumlah;
                $totalBayar += $subtotal;
                
                $detailData[] = [
                    'paket_id' => $cart->paket_id,
                    'jumlah' => $cart->jumlah,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            // Buat Pemesanan
            $pemesanan = Pemesanan::create([
                'id_pelanggan' => $pelanggan->id,
                'id_jenis_bayar' => $validated['id_jenis_bayar'],
                'no_resi' => $noResi,
                'tgl_pesan' => $validated['tgl_pesan'],
                'status_pesan' => 'Menunggu Konfirmasi',
                'total_bayar' => $totalBayar,
                'catatan' => $validated['catatan'] ?? null,
            ]);
            
            // Buat Detail Pemesanan
            foreach ($detailData as $detail) {
                $detail['pemesanan_id'] = $pemesanan->id;
                \App\Models\DetailPemesanan::create($detail);
            }
            
            // Hapus cart yang sudah di-checkout
            Cart::whereIn('id', $carts->pluck('id'))->delete();
            
            DB::commit();
            
            return redirect()->route('customer.orders')
                ->with('success', '✅ Pesanan berhasil dibuat! No. Resi: ' . $noResi);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', '❌ Gagal: ' . $e->getMessage());
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
} // ✅ KURUNG KURAWAL PENUTUP CLASS - JANGAN DIHAPUS!