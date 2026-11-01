@extends('layout')

@section('content')

{{-- Tampilan struk transaksi --}}
<div class="bg-white p-3 mx-auto" style="max-width:320px;font-family:monospace">

    {{-- Informasi toko dan transaksi --}}
    <div class="text-center fw-bold">UduxMu</div>
    <div class="text-center small">
        {{ $sale->created_at->format('d/m/Y H:i') }} · #{{ $sale->id }}
    </div>
    <hr>

    {{-- Daftar menu yang dibeli --}}
    @foreach($sale->items as $i)
        <div>{{ $i->menu->name }}</div>
        <div class="d-flex justify-content-between">
            <span>{{ $i->qty }} x {{ number_format($i->price, 0, ',', '.') }}</span>
            <span>{{ number_format($i->qty * $i->price, 0, ',', '.') }}</span>
        </div>
    @endforeach

    <hr>

    {{-- Rincian pembayaran --}}
    <div class="d-flex justify-content-between">
        <span>Total</span>
        <span>{{ number_format($sale->total, 0, ',', '.') }}</span>
    </div>
    <div class="d-flex justify-content-between">
        <span>Tunai</span>
        <span>{{ number_format($sale->paid, 0, ',', '.') }}</span>
    </div>
    <div class="d-flex justify-content-between">
        <span>Kembali</span>
        <span>{{ number_format($sale->change, 0, ',', '.') }}</span>
    </div>

    <hr>
    <div class="text-center">Terima kasih!</div>
</div>

{{-- Tombol cetak struk dan transaksi baru --}}
<div class="text-center mt-3 no-print">
    <button onclick="print()" class="btn btn-danger">Cetak</button>
    <a href="/kasir" class="btn btn-outline-secondary">Transaksi Baru</a>
</div>

@endsection