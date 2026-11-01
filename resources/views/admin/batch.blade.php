@extends('layout')

@section('content')

{{-- Judul halaman --}}
<h1 class="h3">Batch Produksi & Stok</h1>

{{-- Form untuk mencatat batch produksi --}}
<form method="post" action="/admin/batch" class="card card-body mb-4 row g-2 flex-row">
    @csrf

    {{-- Pilihan menu --}}
    <div class="col-md-4">
        <select name="menu_id" class="form-select" required>
            @foreach($menus as $m)
                <option value="{{ $m->id }}">
                    {{ $m->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Tanggal produksi --}}
    <div class="col-md-3">
        <input
            type="date"
            name="produced_on"
            max="{{ today()->toDateString() }}"
            value="{{ today()->toDateString() }}"
            class="form-control"
            required
        >
    </div>

    {{-- Jumlah porsi yang diproduksi --}}
    <div class="col-md-3">
        <input
            type="number"
            name="qty"
            min="1"
            placeholder="Jumlah porsi"
            class="form-control"
            required
        >
    </div>

    {{-- Tombol mencatat batch --}}
    <div class="col-md-2">
        <button class="btn btn-danger w-100">Catat Batch</button>
    </div>
</form>

{{-- Tabel stok hari ini dan status menu --}}
<h2 class="h5">Stok Hari Ini & Status Menu</h2>

<div class="table-responsive">
    <table class="table align-middle bg-white">

        {{-- Header tabel --}}
        <tr>
            <th>Menu</th>
            <th>Layak jual</th>
            <th>Stok kasir</th>
            <th>Tampil di Menu Besok</th>
            <th></th>
        </tr>

        {{-- Menampilkan seluruh data menu --}}
        @foreach($menusAll as $m)

            <tr>
                {{-- Nama menu --}}
                <td>{{ $m->name }}</td>

                {{-- Jumlah stok yang layak dijual --}}
                <td>{{ $stok[$m->id]['layak'] }}</td>

                {{-- Jumlah stok yang tersedia di kasir --}}
                <td>{{ $stok[$m->id]['kasir'] }}</td>

                {{-- Mengatur status aktif dan nonaktif menu --}}
                <td>
                    <form method="post" action="/admin/menu/{{ $m->id }}/toggle">
                        @csrf

                        <div class="form-check form-switch">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                role="switch"
                                onchange="this.form.submit()"
                                @checked($m->is_active)
                            >

                            <label class="form-check-label small">
                                {{ $m->is_active ? 'Aktif' : 'Nonaktif' }}
                            </label>
                        </div>
                    </form>
                </td>

                {{-- Tombol untuk mengedit menu --}}
                <td>
                    <a
                        href="/admin/menu/{{ $m->id }}/edit"
                        class="btn btn-sm btn-outline-secondary"
                    >
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </td>
            </tr>

        @endforeach

    </table>
</div>

@endsection