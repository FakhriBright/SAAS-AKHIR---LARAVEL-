<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $pemesanan->no_resi }}</title>
    <style>
        @page { margin: 15mm 10mm; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 22px; color: #0d6efd; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 5px 0 0; color: #666; font-size: 11px; }
        .info-grid { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info-box { width: 48%; }
        .info-box h3 { font-size: 13px; margin: 0 0 8px; background: #f8f9fa; padding: 5px 8px; border-left: 3px solid #0d6efd; }
        .info-box p { margin: 3px 0; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 11px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-right { text-align: right; }
        .total-row { background-color: #e9ecef; font-weight: bold; }
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
        .signature { margin-top: 50px; display: flex; justify-content: space-between; }
        .sign-box { text-align: center; width: 200px; }
        .sign-line { border-top: 1px solid #333; margin-top: 60px; padding-top: 5px; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Catering Sejahtera</h1>
        <p>Invoice / Nota Pemesanan Resmi</p>
    </div>

    <div class="info-grid">
        <div class="info-box">
            <h3>👤 Informasi Pelanggan</h3>
            <p><strong>Nama:</strong> {{ $pemesanan->pelanggan->nama_pelanggan ?? '-' }}</p>
            <p><strong>Telepon:</strong> {{ $pemesanan->pelanggan->telepon ?? '-' }}</p>
            <p><strong>Alamat:</strong> {{ $pemesanan->pelanggan->alamat1 ?? '-' }}{{ $pemesanan->pelanggan->alamat2 ? ', ' . $pemesanan->pelanggan->alamat2 : '' }}</p>
        </div>
        <div class="info-box">
            <h3>📄 Detail Transaksi</h3>
            <p><strong>No. Resi:</strong> {{ $pemesanan->no_resi }}</p>
            <p><strong>Tanggal Pesan:</strong> {{ $pemesanan->tgl_pesan->format('d F Y') }}</p>
            <p><strong>Metode Bayar:</strong> {{ $pemesanan->jenisPembayaran->metode_pembayaran ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $pemesanan->status_pesan }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Paket</th>
                <th width="18%">Harga Satuan</th>
                <th width="10%">Qty</th>
                <th width="22%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemesanan->detailPemesanans as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->paket->nama_paket ?? 'Paket Dihapus' }}</td>
                <td>Rp {{ number_format($detail->paket->harga ?? 0, 0, ',', '.') }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL BAYAR</td>
                <td class="text-right" style="font-size: 13px;">Rp {{ number_format($pemesanan->total_bayar, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <div class="sign-box">
            <p>Penerima (Pelanggan)</p>
            <div class="sign-line">( .................................... )</div>
        </div>
        <div class="sign-box">
            <p>Pengelola Catering</p>
            <div class="sign-line">( .................................... )</div>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak otomatis oleh sistem. Tidak memerlukan tanda tangan basah untuk validasi digital.</p>
        <p>© {{ date('Y') }} Catering Sejahtera | Dicetak pada {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
