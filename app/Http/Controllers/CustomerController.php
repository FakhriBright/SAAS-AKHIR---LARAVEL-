<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use App\Models\JenisPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    // ... method lainnya

    public function createOrder()
    {
        $pakets = Paket::where('jenis', '!=', '') // Pastikan hanya paket aktif
            ->orderBy('nama_paket')
            ->get();
            
        $jenisPembayarans = JenisPembayaran::all();
        
        return view('customer.order.create', compact('pakets', 'jenisPembayarans'));
    }

    public function storeOrder(Request $request)
    {
        // 🔍 DEBUG: Lihat data yang masuk
        // Log::info('Order Data:', $request->all());
        
        $validated = $request->validate([
            'paket_id.*' => 'required|exists:pakets,id',
            'jumlah.*' => 'required|integer|min:1',
            'tgl_pesan' => 'required|date|after_or_equal:today',
            'id_jenis_bayar' => 'required|exists:jenis_pembayarans,id',
            'catatan' => 'nullable|string|max:1000',
        ], [
            'paket_id.*.required' => 'Pilih minimal satu paket',
            'paket_id.*.exists' => 'Paket tidak ditemukan',
            'jumlah.*.required' => 'Jumlah harus diisi',
            'jumlah.*.integer' => 'Jumlah harus angka',
            'jumlah.*.min' => 'Jumlah minimal 1',
            'tgl_pesan.required' => 'Tanggal pesan harus diisi',
            'tgl_pesan.date' => 'Format tanggal tidak valid',
            'tgl_pesan.after_or_equal' => 'Tanggal tidak boleh di masa lalu',
            'id_jenis_bayar.required' => 'Pilih metode pembayaran',
            'id_jenis_bayar.exists' => 'Metode pembayaran tidak ditemukan',
        ]);

        try {
            DB::beginTransaction();
            
            $pelanggan = Auth::guard('pelanggan')->user();
            
            // Generate No Resi Unik
            $noResi = 'RESI-' . date('Ymd') . '-' . str_pad(Pemesanan::count() + 1, 4, '0', STR_PAD_LEFT);
            
            // Hitung Total
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
                DetailPemesanan::create($detail);
            }
            
            DB::commit();
            
            return redirect()->route('customer.orders')
                ->with('success', 'Pesanan berhasil dibuat! No. Resi: ' . $noResi);
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // 🔍 DEBUG: Log error ke storage/logs/laravel.log
            Log::error('Order Creation Failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all(),
            ]);
            
            return back()->withInput()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
    
    // ... method lainnya
}