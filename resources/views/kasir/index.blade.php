@extends('layout')

@section('title', 'Kasir')

@section('content')

{{-- Daftar emoji untuk menu yang belum memiliki foto --}}
@php
    $emo = ['🍗', '🍛', '🍚', '🥘', '🥤'];
@endphp

{{-- Form transaksi kasir --}}
<form method="post" action="/kasir" class="row g-3">
    @csrf

    {{-- Bagian daftar menu --}}
    <div class="col-xl-8">
        <div class="row g-3">

            @foreach($menus as $m)
                <div class="col-6 col-md-4">
                    <div class="card h-100 kc {{ $m->stok < 1 ? 'opacity-50' : '' }}"
                        data-id="{{ $m->id }}"
                        data-p="{{ $m->price }}"
                        data-s="{{ $m->stok }}"
                        data-n="{{ $m->name }}">

                        {{-- Menampilkan foto menu atau emoji --}}
                        @if($m->photo)
                            <img src="{{ asset('storage/'.$m->photo) }}" class="card-img-top" style="height:110px;object-fit:cover" alt="{{ $m->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center fs-1" style="height:110px;background:linear-gradient(135deg,#bbf7d0,#fef9c3)">
                                {{ $emo[$loop->index % 5] }}
                            </div>
                        @endif

                        <div class="card-body p-2">
                            {{-- Informasi nama, harga, dan stok menu --}}
                            <div class="fw-semibold small">{{ $m->name }}</div>
                            <div class="text-danger fw-bold small">Rp {{ number_format($m->price, 0, ',', '.') }}</div>
                            <div class="small text-muted">{{ $m->stok < 1 ? 'Habis' : 'Stok: '.$m->stok }}</div>

                            {{-- Tombol mengurangi dan menambah jumlah menu --}}
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-d>−</button>
                                <b class="qn">0</b>
                                <button type="button" class="btn btn-sm btn-success" data-i @disabled($m->stok < 1)>+</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    {{-- Bagian ringkasan transaksi --}}
    <div class="col-xl-4">
        <div class="card position-sticky" style="top:76px">
            <div class="card-body">
                <h2 class="h6 fw-bold">
                    <i class="bi bi-receipt"></i> Ringkasan Pesanan
                </h2>

                {{-- Daftar menu yang dipilih --}}
                <div id="sum" class="small mb-2"></div>
                <div id="hid"></div>
                <hr>

                {{-- Total pembayaran --}}
                <div class="d-flex justify-content-between fs-5 fw-bold">
                    <span>Total</span>
                    <span id="total">Rp 0</span>
                </div>

                {{-- Input uang yang diterima --}}
                <label class="form-label mt-2 mb-1">Uang diterima (Rp)</label>
                <input type="number" min="0" name="paid" id="paid" class="form-control form-control-lg" value="{{ old('paid') }}" required>

                {{-- Tombol nominal pembayaran cepat --}}
                <div class="d-flex flex-wrap gap-1 my-2">
                    <button type="button" class="btn btn-sm btn-outline-success" id="pas">Uang pas</button>

                    @foreach([20000, 50000, 100000] as $n)
                        <button type="button" class="btn btn-sm btn-outline-success qp" data-v="{{ $n }}">
                            {{ number_format($n, 0, ',', '.') }}
                        </button>
                    @endforeach
                </div>

                {{-- Menampilkan jumlah kembalian --}}
                <div class="d-flex justify-content-between">
                    <span>Kembalian</span>
                    <b id="chg">Rp 0</b>
                </div>

                {{-- Tombol memproses transaksi dan mencetak struk --}}
                <button class="btn btn-success w-100 mt-3 py-2" id="go" disabled>
                    <i class="bi bi-printer"></i> Proses & Cetak Struk
                </button>
            </div>
        </div>
    </div>
</form>

{{-- JavaScript untuk mengatur transaksi kasir --}}
@push('js')
<script>
    // Format angka menjadi mata uang Rupiah
    const f = n => 'Rp ' + n.toLocaleString('id-ID');

    // Menyimpan jumlah menu yang dipilih
    const C = {}, o = @json(old('qty', []));

    // Mengambil kembali jumlah menu jika validasi gagal
    for (const k in o)
        if (+o[k] > 0) C[k] = +o[k];

    // Mengambil seluruh kartu menu
    const cards = [...document.querySelectorAll('.kc')];

    // Memperbarui ringkasan, total, dan kembalian
    function draw() {
        let t = 0, s = '', h = '';

        cards.forEach(c => {
            const id = c.dataset.id, q = C[id] || 0;
            c.querySelector('.qn').textContent = q;

            // Menghitung subtotal setiap menu yang dipilih
            if (q) {
                t += q * c.dataset.p;
                s += `<div class="d-flex justify-content-between"><span>${c.dataset.n} ×${q}</span><span>${f(q * c.dataset.p)}</span></div>`;
                h += `<input type="hidden" name="qty[${id}]" value="${q}">`;
            }
        });

        // Menampilkan ringkasan dan data menu untuk dikirim
        sum.innerHTML = s || '<span class="text-muted">Pilih menu di sebelah kiri.</span>';
        hid.innerHTML = h;
        total.textContent = f(t);

        // Menghitung kembalian dan mengatur tombol proses
        const p = +paid.value || 0;
        chg.textContent = f(Math.max(0, p - t));
        go.disabled = !(t > 0 && p >= t);
        window.T = t;
    }

    // Tombol tambah dan kurang jumlah menu
    cards.forEach(c => {
        c.querySelector('[data-i]').onclick = () => {
            const id = c.dataset.id;
            C[id] = Math.min(+c.dataset.s, (C[id] || 0) + 1);
            draw();
        };

        c.querySelector('[data-d]').onclick = () => {
            const id = c.dataset.id;
            C[id] = (C[id] || 0) - 1;

            if (C[id] < 1) delete C[id];
            draw();
        };
    });

    // Memperbarui perhitungan ketika uang diterima berubah
    paid.oninput = draw;

    // Mengisi uang pembayaran sesuai total transaksi
    pas.onclick = () => {
        paid.value = window.T || 0;
        draw();
    };

    // Tombol nominal pembayaran cepat
    document.querySelectorAll('.qp').forEach(b => {
        b.onclick = () => {
            paid.value = b.dataset.v;
            draw();
        };
    });

    // Menampilkan kondisi awal transaksi
    draw();
</script>
@endpush

@endsection