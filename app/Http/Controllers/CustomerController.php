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

class CustomerController extends Controller
{
    /**
     * Customer Dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        $pelanggan = Pelanggan::where('email', $user->email)->first();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $totalPesanan = Pemesanan::where('id_pelanggan', $pelanggan->id)->count();
        $pesananAktif = Pemesanan::where('id_pelanggan', $pelanggan->id)
                        ->whereIn('status_pesan', ['Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir'])
                        ->count();
        $totalBelanja = Pemesanan::where('id_pelanggan', $pelanggan->id)
                        ->where('status_pesan', 'Selesai')
                        ->sum('total_bayar');

        $recentOrders = Pemesanan::with(['detailPemesanans.paket', 'jenisPembayaran'])
                        ->where('id_pelanggan', $pelanggan->id)
                        ->latest()
                        ->take(5)
                        ->get();

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
     * Store Order
     */
    public function storeOrder(Request $request)
    {
        $user = Auth::user();
        $pelanggan = Pelanggan::where('email', $user->email)->first();

        if (!$pelanggan) {
            return redirect()->back()->withInput()->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $validated = $request->validate([
            'paket_id' => 'required|array|min:1',
            'paket_id.*' => 'exists:pakets,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'tgl_pesan' => 'required|date|after_or_equal:today',
            'id_jenis_bayar' => 'required|exists:jenis_pembayarans,id',
            'no_rek_pembayaran' => 'nullable|string|max:50',
            'catatan' => 'nullable|string|max:500',
        ], [
            'paket_id.required' => 'Minimal pilih 1 paket.',
            'tgl_pesan.after_or_equal' => 'Tanggal pesan harus hari ini atau setelahnya.',
        ]);

        DB::beginTransaction();
        try {
            $totalBayar = 0;
            $details = [];

            foreach ($validated['paket_id'] as $index => $paketId) {
                $paket = Paket::find($paketId);
                $jumlah = $validated['jumlah'][$index] ?? 1;

                if ($paket) {
                    $subtotal = $paket->harga * $jumlah;
                    $totalBayar += $subtotal;

                    $details[] = [
                        'paket_id' => $paketId,
                        'subtotal' => $subtotal,
                    ];
                }
            }

            if ($totalBayar <= 0) {
                throw new \Exception("Total bayar tidak valid");
            }

            $count = Pemesanan::count() + 1;
            $noResi = 'RESI-' . date('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            $pemesanan = Pemesanan::create([
                'id_pelanggan' => $pelanggan->id,
                'id_jenis_bayar' => $validated['id_jenis_bayar'],
                'no_resi' => $noResi,
                'tgl_pesan' => $validated['tgl_pesan'],
                'status_pesan' => 'Menunggu Konfirmasi',
                'total_bayar' => $totalBayar,
                'catatan' => $validated['catatan'] ?? null,
            ]);

            foreach ($details as $detail) {
                $pemesanan->detailPemesanans()->create($detail);
            }

            DB::commit();

            return redirect()->route('customer.orders')
                ->with('success', 'Pesanan berhasil dibuat! No. Resi: ' . $noResi);

        } catch (\Exception $e) {
            DB::rollBack();
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
        $user = Auth::user();
        $pelanggan = Pelanggan::where('email', $user->email)->first();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data pelanggan tidak ditemukan.');
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
        $user = Auth::user();
        $pelanggan = Pelanggan::where('email', $user->email)->first();

        if (!$pelanggan) {
            return redirect()->route('customer.orders')->with('error', 'Data pelanggan tidak ditemukan.');
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
}
