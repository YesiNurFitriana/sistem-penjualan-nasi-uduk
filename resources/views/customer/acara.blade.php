@extends('layout')

@section('title', 'Pesanan Acara')

@section('content')

{{-- Layout halaman pesanan acara --}}
<div class="row g-4">

    {{-- Form pemesanan khusus atau acara --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body p-4">
                <h1 class="h4 fw-bold">Pesanan Khusus / Acara</h1>
                <p class="text-muted">Untuk tanggal selain besok (minimal 2 hari dari sekarang). Pesanan diperiksa admin dan dikonfirmasi lewat WhatsApp.</p>

                <form method="post" action="/acara" class="row g-3">
                    @csrf

                    {{-- Input identitas pemesan --}}
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input name="name" value="{{ old('name', auth()->user()->name ?? '') }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">WhatsApp</label>
                        <input name="whatsapp" value="{{ old('whatsapp', auth()->user()->phone ?? '') }}" placeholder="08123456789" class="form-control" required>
                    </div>

                    {{-- Input tanggal, waktu, dan jenis acara --}}
                    <div class="col-md-4">
                        <label class="form-label">Tanggal acara</label>
                        <input type="date" name="event_date" min="{{ today()->addDays(2)->toDateString() }}" value="{{ old('event_date') }}" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Waktu pengambilan</label>
                        <input type="time" name="pickup_time" max="12:00" value="{{ old('pickup_time') }}" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jenis acara</label>
                        <input name="event_type" list="ev" value="{{ old('event_type') }}" class="form-control" required>

                        {{-- Pilihan jenis acara --}}
                        <datalist id="ev">
                            <option>Arisan</option>
                            <option>Pengajian</option>
                            <option>Ulang tahun</option>
                            <option>Rapat kantor</option>
                            <option>Syukuran</option>
                        </datalist>
                    </div>

                    {{-- Pilihan menu dan jumlah porsi --}}
                    <div class="col-12">
                        <label class="form-label">Menu & jumlah porsi</label>
                        <div id="rows"></div>
                        <button type="button" id="ar" class="btn btn-sm btn-outline-danger mt-1">
                            <i class="bi bi-plus"></i> Tambah menu
                        </button>
                    </div>

                    {{-- Catatan tambahan pemesan --}}
                    <div class="col-12">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
                    </div>

                    {{-- Tombol mengirim pesanan ke admin --}}
                    <div class="col-12">
                        <button class="btn btn-danger rounded-pill px-4">Kirim ke Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar riwayat pesanan acara pelanggan --}}
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h2 class="h6 fw-bold">Pesanan acara Anda</h2>

                {{-- Menampilkan pesanan yang pernah dibuat --}}
                @forelse($mine as $s)
                    <div class="border-bottom py-2">
                        <div class="d-flex justify-content-between">
                            <b>{{ $s->event_type }} · {{ $s->event_date->format('d/m/Y') }}</b>
                            <span class="badge bg-success">{{ $s->status }}</span>
                        </div>

                        {{-- Daftar menu dan jumlah porsi --}}
                        <small>
                            @foreach($s->items as $i)
                                {{ $i['name'] }} ×{{ $i['portions'] }}@if(!$loop->last), @endif
                            @endforeach
                        </small>

                        {{-- Catatan dari admin jika tersedia --}}
                        @if($s->admin_note)
                            <div class="small text-danger">
                                Catatan admin: {{ $s->admin_note }}
                            </div>
                        @endif
                    </div>

                @empty
                    {{-- Pesan jika belum ada riwayat pesanan --}}
                    <p class="text-muted small mb-0">
                        {{ auth()->check() ? 'Belum ada pesanan acara.' : 'Masuk untuk melihat status pesanan acara Anda.' }}
                    </p>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- JavaScript untuk menambahkan pilihan menu secara dinamis --}}
@push('js')
<script>
    // Mengambil daftar menu dari database
    const opts = @json($menus->map(fn($m) => ['id' => $m->id, 'n' => $m->name]));
    let n = 0;

    // Fungsi menambahkan baris pilihan menu dan jumlah porsi
    function add() {
        const i = n++;

        document.getElementById('rows').insertAdjacentHTML('beforeend', `
            <div class="row g-2 mb-2">
                <div class="col-7">
                    <select name="items[${i}][menu_id]" class="form-select" required>
                        ${opts.map(o => `<option value="${o.id}">${o.n}</option>`).join('')}
                    </select>
                </div>
                <div class="col-4">
                    <input type="number" min="1" name="items[${i}][portions]" class="form-control" placeholder="Porsi" required>
                </div>
                <div class="col-1">
                    <button type="button" class="btn text-danger" onclick="this.closest('.row').remove()">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
        `);
    }

    // Menambahkan menu ketika tombol diklik
    document.getElementById('ar').onclick = add;

    // Menampilkan satu baris menu secara otomatis saat halaman dibuka
    add();
</script>
@endpush

@endsection