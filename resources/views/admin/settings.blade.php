@extends('layout')

@section('content')

{{-- Mengambil nilai pengaturan dari input lama atau database --}}
@php
    $s = fn($k, $d) => old($k, \App\Models\Setting::val($k, $d));
@endphp

{{-- Judul halaman --}}
<h1 class="h3">Pengaturan</h1>

{{-- Form pengaturan operasional toko --}}
<form method="post" action="/admin/pengaturan" class="card card-body mb-4 row g-2 flex-row">
    @csrf

    {{-- Input jam operasional dan kuota default --}}
    @foreach([
        ['open_time', 'Jam buka', 'time', '07:00'],
        ['pickup_start', 'Pengambilan mulai', 'time', '08:00'],
        ['pickup_end', 'Pengambilan sampai (maks. 12:00)', 'time', '12:00'],
        ['prep_minutes', 'Waktu persiapan (menit)', 'number', '60'],
        ['default_quota', 'Kuota default (porsi/hari)', 'number', '50']
    ] as [$k, $l, $t, $d])

        <div class="col-md-4">
            <label class="form-label">{{ $l }}</label>
            <input name="{{ $k }}" type="{{ $t }}" value="{{ $s($k, $d) }}" class="form-control" required>
        </div>

    @endforeach

    {{-- Tombol menyimpan pengaturan --}}
    <div class="col-12">
        <button class="btn btn-danger">Simpan</button>
    </div>
</form>

{{-- Pengaturan kuota berdasarkan tanggal --}}
<h2 class="h5">Kuota per Tanggal</h2>

<form method="post" action="/admin/kuota" class="row g-2 mb-3">
    @csrf

    {{-- Memilih tanggal kuota --}}
    <div class="col-6 col-md-3">
        <input type="date" name="date" min="{{ today()->toDateString() }}" class="form-control" required>
    </div>

    {{-- Mengatur jumlah kuota porsi --}}
    <div class="col-6 col-md-3">
        <input type="number" name="quota" min="0" class="form-control" placeholder="Kuota" required>
    </div>

    {{-- Tombol menyimpan kuota --}}
    <div class="col-auto">
        <button class="btn btn-outline-danger">Simpan</button>
    </div>
</form>

{{-- Tabel daftar kuota yang sudah ditentukan --}}
<table class="table table-sm bg-white w-auto">
    @foreach($quotas as $q)
        <tr>
            <td>{{ \Carbon\Carbon::parse($q->date)->format('d/m/Y') }}</td>
            <td>{{ $q->quota }} porsi</td>
        </tr>
    @endforeach
</table>

@endsection