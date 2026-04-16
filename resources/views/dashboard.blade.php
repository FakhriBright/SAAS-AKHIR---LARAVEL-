@extends('layouts.app')

@section('content')
<h3>Dashboard</h3>

<p>Paket: {{ $paket }}</p>
<p>Pelanggan: {{ $pelanggan }}</p>
<p>Pemesanan: {{ $pemesanan }}</p>
<p>Pengiriman: {{ $pengiriman }}</p>
@endsection
