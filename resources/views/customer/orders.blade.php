@extends('layout')

@section('title', 'Pesanan Saya')

@section('content')

{{-- Header halaman dan tombol pesan menu --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 fw-bold mb-0">Pesanan Saya</h1>
    <a href="/" class="btn btn-danger rounded-pill">
        <i class="bi bi-plus-lg"></i> Pesan Menu Besok
    </a>
</div>

{{-- Menampilkan daftar pesanan pelanggan --}}
@forelse($orders as $o)
    <div class="card mb-3">
        <div class="card-body">

            {{-- Nomor pesanan, jadwal pengambilan, dan status --}}
            <div class="d-flex justify-content-between flex-wrap">
                <strong>
                    #{{ $o->id }} · ambil {{ $o->pickup_date->format('d/m/Y') }} {{ substr($o->pickup_time, 0, 5) }}
                </strong>
                <span class="badge bg-success">{{ $o->status }}</span>
            </div>

            {{-- Daftar menu, jumlah pesanan, dan total harga --}}
            <div class="my-2">
                @foreach($o->items as $i)
                    {{ $i->menu->name }} ×{{ $i->qty }}@if(!$loop->last), @endif
                @endforeach
                — <b>Rp {{ number_format($o->total, 0, ',', '.') }}</b>
            </div>

            {{-- Menampilkan alasan penolakan pesanan --}}
            @if($o->reject_reason)
                <div class="text-danger">
                    Alasan ditolak: {{ $o->reject_reason }}
                </div>
            @endif

            {{-- Tombol pembatalan pesanan --}}
            @if($o->customerCanCancel())
                <form method="post" action="/pesanan/{{ $o->id }}/batal" onsubmit="return confirm('Batalkan pesanan?')">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">Batalkan</button>
                </form>

            {{-- Informasi jika pesanan tidak dapat dibatalkan sendiri --}}
            @elseif(!in_array($o->status, ['Selesai', 'Ditolak', 'Dibatalkan']))
                <small class="text-muted">Tidak dapat dibatalkan sendiri; hubungi admin.</small>
            @endif

        </div>
    </div>

{{-- Tampilan jika belum ada pesanan --}}
@empty
    <div class="text-center text-muted py-5">
        Belum ada pesanan.
    </div>
@endforelse

@endsection