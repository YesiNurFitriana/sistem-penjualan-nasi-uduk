@extends('layout')

@section('title', 'Pesanan Acara')

@section('content')

{{-- Menampilkan daftar pesanan acara --}}
@foreach($orders as $s)

    <div class="card mb-3">
        <div class="card-body">

            {{-- Informasi utama pesanan dan status --}}
            <div class="d-flex justify-content-between flex-wrap gap-2">
                <strong>
                    #{{ $s->id }} · {{ $s->event_type }} — {{ $s->name }}
                </strong>

                <span class="badge bg-success">
                    {{ $s->status }}
                </span>
            </div>

            {{-- Tanggal, waktu pengambilan, dan kontak WhatsApp --}}
            <div>
                Tanggal {{ $s->event_date->format('d/m/Y') }}
                · ambil {{ substr($s->pickup_time, 0, 5) }}
                · WA
                <a
                    href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $s->whatsapp)) }}"
                    target="_blank"
                >
                    {{ $s->whatsapp }}
                </a>
            </div>

            {{-- Daftar menu dan jumlah porsi --}}
            <ul class="mb-1">
                @foreach($s->items as $i)
                    <li>
                        {{ $i['name'] }} × {{ $i['portions'] }} porsi
                    </li>
                @endforeach
            </ul>

            {{-- Catatan dari pelanggan --}}
            @if($s->notes)
                <div class="text-muted small">
                    Catatan: {{ $s->notes }}
                </div>
            @endif

            {{-- Tombol konfirmasi dan penolakan pesanan --}}
            @if($s->status === 'Menunggu Konfirmasi')

                <form method="post" class="d-flex flex-wrap gap-2 mt-2">
                    @csrf

                    {{-- Input catatan atau alasan penolakan --}}
                    <input
                        name="admin_note"
                        class="form-control form-control-sm w-auto"
                        placeholder="Catatan / alasan tolak"
                    >

                    {{-- Tombol konfirmasi pesanan --}}
                    <button
                        formaction="/admin/acara/{{ $s->id }}/konfirmasi"
                        class="btn btn-sm btn-success"
                    >
                        Konfirmasi
                    </button>

                    {{-- Tombol menolak pesanan --}}
                    <button
                        formaction="/admin/acara/{{ $s->id }}/tolak"
                        class="btn btn-sm btn-outline-danger"
                    >
                        Tolak
                    </button>
                </form>

            {{-- Menampilkan catatan admin jika tersedia --}}
            @elseif($s->admin_note)

                <div class="small mt-1">
                    Catatan admin: {{ $s->admin_note }}
                </div>

            @endif

        </div>
    </div>

@endforeach

{{-- Navigasi halaman pesanan --}}
{{ $orders->links() }}

@endsection