<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\JenisPembayaran;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CustomerController extends Controller
{
    /**
     * Customer Dashboard
     */
    public function dashboard()
    {
        // ✅ Langsung pakai $pelanggan dari Auth guard (sudah instance Pelanggan model)
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // ✅ Hitung stats pesanan
        $totalPesanan = Pemesanan::where('id_pelanggan', $pelanggan->id)->count();

        $pesananAktif = Pemesanan::where('id_pelanggan', $pelanggan->id)
                        ->whereIn('status_pesan', ['Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir'])
                        ->count();

        $totalBelanja = Pemesanan::where('id_pelanggan', $pelanggan->id)
                        ->where('status_pesan', 'Selesai')
                        ->sum('total_bayar');

        // ✅ Ambil 5 pesanan terakhir dengan relasi
        $recentOrders = Pemesanan::with(['detailPemesanans.paket', 'jenisPembayaran'])
                        ->where('id_pelanggan', $pelanggan->id)
                        ->latest()
                        ->take(5)
                        ->get();

        // ✅ Kirim variabel 'pelanggan' (sesuai nama di view)
        return view('customer.dashboard', compact(
            'totalPesanan',
            'pesananAktif',
            'totalBelanja',
            'recentOrders',
            'pelanggan'
        ));
    }

    /**
     * Public Catalog
     */
    public function catalog()
    {
        $pakets = Paket::all();
        return view('customer.catalog', compact('pakets'));
    }

    /**
     * Show Order Form
     */
    public function createOrder()
    {
        $pakets = Paket::all();
        $jenisPembayarans = JenisPembayaran::with('detailJenisPembayarans')->get();

        return view('customer.order.create', compact('pakets', 'jenisPembayarans'));
    }

    /**
     * Store Order - 🔥 FIX: Pastikan 'jumlah' terkirim!
     */
    public function storeOrder(Request $request)
    {
        // ✅ Ambil user dari guard pelanggan
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // ✅ VALIDASI: Pastikan 'jumlah' ada dan valid
        $validated = $request->validate([
            'paket_id' => 'required|array|min:1',
            'paket_id.*' => 'exists:pakets,id',
            'jumlah' => 'required|array|min:1',        // 🔥 WAJIB!
            'jumlah.*' => 'required|integer|min:1',     // 🔥 WAJIB!
            'tgl_pesan' => 'required|date|after_or_equal:today',
            'id_jenis_bayar' => 'required|exists:jenis_pembayarans,id',
            'no_rek_pembayaran' => 'nullable|string|max:50',
            'catatan' => 'nullable|string|max:500',
        ], [
            'paket_id.required' => 'Minimal pilih 1 paket.',
            'jumlah.required' => 'Jumlah harus diisi untuk setiap paket.',
            'jumlah.*.min' => 'Jumlah minimal 1.',
            'tgl_pesan.after_or_equal' => 'Tanggal pesan tidak boleh di masa lalu.',
        ]);

        DB::beginTransaction();
        try {
            $totalBayar = 0;
            $details = [];

            // 🔥 LOOP: Ambil paket DAN jumlah dengan index yang SAMA
            foreach ($validated['paket_id'] as $index => $paketId) {
                $paket = Paket::find($paketId);

                // 🔥 AMBIL JUMLAH DARI ARRAY 'jumlah' DENGAN INDEX YANG SAMA
                $jumlah = $validated['jumlah'][$index] ?? 1;

                if ($paket) {
                    $subtotal = $paket->harga * $jumlah;
                    $totalBayar += $subtotal;

                    // 🔥 PASTIKAN 'jumlah' DIMASUKKAN KE ARRAY DETAIL
                    $details[] = [
                        'paket_id' => $paketId,
                        'jumlah' => $jumlah,      // 🔥 INI YANG SERING TERLEWAT!
                        'subtotal' => $subtotal,
                    ];
                }
            }

            if ($totalBayar <= 0) {
                throw new \Exception("Total bayar tidak valid");
            }

            // Generate No. Resi
            $count = Pemesanan::count() + 1;
            $noResi = 'RESI-' . date('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            // Simpan Pemesanan
            $pemesanan = Pemesanan::create([
                'id_pelanggan' => $pelanggan->id,  // ✅ Langsung pakai $pelanggan->id
                'id_jenis_bayar' => $validated['id_jenis_bayar'],
                'no_resi' => $noResi,
                'tgl_pesan' => $validated['tgl_pesan'],
                'status_pesan' => 'Menunggu Konfirmasi',
                'total_bayar' => $totalBayar,
                'catatan' => $validated['catatan'] ?? null,
            ]);

            // 🔥 SIMPAN DETAIL: Pastikan 'jumlah' ikut tersimpan!
            foreach ($details as $detail) {
                $pemesanan->detailPemesanans()->create([
                    'paket_id' => $detail['paket_id'],
                    'jumlah' => $detail['jumlah'],    // 🔥 PASTIKAN INI ADA!
                    'subtotal' => $detail['subtotal'],
                ]);
            }

            DB::commit();

            return redirect()->route('customer.orders')
                ->with('success', 'Pesanan berhasil dibuat! No. Resi: ' . $noResi);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Customer Order Error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Order History
     */
    public function orders()
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $orders = Pemesanan::with(['detailPemesanans.paket', 'jenisPembayaran', 'pengiriman'])
                    ->where('id_pelanggan', $pelanggan->id)
                    ->latest()
                    ->paginate(10);

        return view('customer.orders', compact('orders'));
    }

    /**
     * Order Detail
     */
    public function orderDetail($id)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $order = Pemesanan::with(['detailPemesanans.paket', 'jenisPembayaran.detailJenisPembayarans', 'pengiriman.user'])
                    ->where('id', $id)
                    ->where('id_pelanggan', $pelanggan->id)
                    ->first();

        if (!$order) {
            return redirect()->route('customer.orders')
                ->with('error', 'Pesanan tidak ditemukan atau bukan milik Anda.');
        }

        return view('customer.order.detail', compact('order'));
    }

    /**
     * Cancel Order - 🔥 BARU: Fitur batalkan pesanan
     * Hanya bisa jika status masih "Menunggu Konfirmasi"
     */
    public function cancelOrder($id)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $order = Pemesanan::where('id', $id)
                    ->where('id_pelanggan', $pelanggan->id)
                    ->first();

        if (!$order) {
            return redirect()->route('customer.orders')
                ->with('error', 'Pesanan tidak ditemukan atau bukan milik Anda.');
        }

        // ✅ Hanya bisa batal jika status masih "Menunggu Konfirmasi"
        if ($order->status_pesan != 'Menunggu Konfirmasi') {
            return redirect()->back()
                ->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        // Update status menjadi "Dibatalkan"
        $order->update([
            'status_pesan' => 'Dibatalkan'
        ]);

        return redirect()->route('customer.orders')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Profile
     */
    public function profile()
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // ✅ Langsung kirim $pelanggan ke view (sudah instance Pelanggan model)
        return view('customer.profile', compact('pelanggan'));
    }

    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if (!$pelanggan) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'alamat1' => 'required|string',
            'alamat2' => 'nullable|string',
            'alamat3' => 'nullable|string',
        ]);

        // ✅ Langsung update instance yang sudah ter-authenticate
        $pelanggan->update($validated);

        return redirect()->route('customer.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
