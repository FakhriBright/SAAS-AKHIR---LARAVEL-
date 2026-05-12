<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pemesanan;
use App\Models\JenisPembayaran;
use App\Models\DetailPemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Show customer dashboard.
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

        $pesananTerbaru = Pemesanan::where('id_pelanggan', $pelanggan->id)
            ->with('detailPemesanans.paket')
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact(
            'pelanggan', 'totalPesanan', 'pesananAktif', 'pesananSelesai', 'pesananTerbaru'
        ));
    }

    /**
     * Show catalog page.
     */
    public function catalog()
    {
        $pakets = Paket::where('jenis', '!=', '')->orderBy('nama_paket')->get();
        $pelanggan = auth()->guard('pelanggan')->user();
        return view('customer.catalog', compact('pakets', 'pelanggan'));
    }

    /**
     * Show orders list (Riwayat Pemesanan).
     */
    public function orders()
    {
        $pelanggan = auth()->guard('pelanggan')->user();

        $orders = Pemesanan::where('id_pelanggan', $pelanggan->id)
            ->with(['detailPemesanans.paket', 'jenisPembayaran'])
            ->latest()
            ->paginate(10);

        return view('customer.orders', compact('orders', 'pelanggan'));
    }

    /**
     * Show create order form.
     */
    public function createOrder(Request $request)
    {
        $pakets = Paket::where('jenis', '!=', '')->orderBy('nama_paket')->get();
        $jenisPembayarans = JenisPembayaran::all();

        // Auto-select paket jika datang dari katalog (?paket=X)
        $selectedPaketId = $request->query('paket');
        $pelanggan = auth()->guard('pelanggan')->user();

        return view('customer.order.create', compact(
            'pakets', 'jenisPembayarans', 'selectedPaketId', 'pelanggan'
        ));
    }

    /**
     * Store new order.
     */
    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'paket_id.*' => 'required|exists:pakets,id',
            'jumlah.*'   => 'required|integer|min:1',
            'tgl_pesan'  => 'required|date|after_or_equal:today',
            'id_jenis_bayar' => 'required|exists:jenis_pembayarans,id',
            'catatan'    => 'nullable|string|max:1000',
        ], [
            'paket_id.*.required' => 'Pilih minimal satu paket',
            'jumlah.*.min' => 'Jumlah minimal 1',
            'tgl_pesan.after_or_equal' => 'Tanggal tidak boleh di masa lalu',
        ]);

        try {
            DB::beginTransaction();

            $pelanggan = auth()->guard('pelanggan')->user();
            $noResi = 'RESI-' . date('Ymd') . '-' . str_pad(Pemesanan::count() + 1, 4, '0', STR_PAD_LEFT);

            $totalBayar = 0;
            $detailData = [];

            foreach ($validated['paket_id'] as $index => $paketId) {
                $paket = Paket::findOrFail($paketId);
                $jumlah = $validated['jumlah'][$index];
                $subtotal = $paket->harga_paket * $jumlah;

                $totalBayar += $subtotal;

                $detailData[] = [
                    'paket_id' => $paketId,
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $pemesanan = Pemesanan::create([
                'id_pelanggan' => $pelanggan->id,
                'id_jenis_bayar' => $validated['id_jenis_bayar'],
                'no_resi' => $noResi,
                'tgl_pesan' => $validated['tgl_pesan'],
                'status_pesan' => 'Menunggu Konfirmasi',
                'total_bayar' => $totalBayar,
                'catatan' => $validated['catatan'] ?? null,
            ]);

            foreach ($detailData as $detail) {
                $detail['pemesanan_id'] = $pemesanan->id;
                DetailPemesanan::create($detail);
            }

            DB::commit();

            return redirect()->route('customer.orders')
                ->with('success', '✅ Pesanan berhasil dibuat! No. Resi: ' . $noResi);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Customer Order Failed:', ['error' => $e->getMessage(), 'user' => auth()->id()]);
            return back()->withInput()->with('error', '❌ Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Show order detail.
     */
    public function showOrder(Pemesanan $order)
    {
        $pelanggan = auth()->guard('pelanggan')->user();

        if ($order->id_pelanggan !== $pelanggan->id) {
            abort(403, 'Unauthorized access.');
        }

        $order->load(['detailPemesanans.paket', 'jenisPembayaran']);
        return view('customer.order.show', compact('order', 'pelanggan'));
    }

    /**
     * Cancel order (hanya bisa jika status masih Menunggu Konfirmasi).
     */
    public function cancelOrder(Pemesanan $order)
    {
        $pelanggan = auth()->guard('pelanggan')->user();

        if ($order->id_pelanggan !== $pelanggan->id) {
            abort(403);
        }

        if ($order->status_pesan !== 'Menunggu Konfirmasi') {
            return back()->with('error', '⚠️ Pesanan hanya bisa dibatalkan saat masih menunggu konfirmasi.');
        }

        $order->update(['status_pesan' => 'Dibatalkan']);
        return back()->with('success', '✅ Pesanan berhasil dibatalkan.');
    }

    /**
     * Show profile page.
     */
    public function profile()
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        return view('customer.profile', compact('pelanggan'));
    }

    /**
     * Update profile.
     */
    public function updateProfile(Request $request)
    {
        $pelanggan = auth()->guard('pelanggan')->user();

        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'telepon' => 'required|string|max:20',
            'alamat1' => 'required|string|max:255',
            'alamat2' => 'nullable|string|max:255',
            'alamat3' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:pelanggans,email,' . $pelanggan->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'telepon' => $validated['telepon'],
            'alamat1' => $validated['alamat1'],
            'alamat2' => $validated['alamat2'] ?? null,
            'alamat3' => $validated['alamat3'] ?? null,
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $pelanggan->update($data);
        return back()->with('success', '✅ Profil berhasil diperbarui!');
    }
}
