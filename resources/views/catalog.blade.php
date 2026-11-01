@extends('layout')

@section('title', 'Menu Besok Pagi')

@section('content')

@php
    // Memeriksa akses admin dan kasir
    $sv = auth()->check() && in_array(auth()->user()->role, ['admin', 'kasir']);
    $emo = ['🍗', '🍛', '🍚', '🥘', '🥤'];
@endphp

<style>
    #cart { position: relative; }

    @media (min-width: 992px) {
        #cart {
            position: sticky;
            top: 16px;
        }
    }

    .stp { display: none; }
    .stp.on { display: flex; }
    .pulse { animation: pl .5s; }

    @keyframes pl {
        50% {
            box-shadow: 0 0 0 6px rgba(22, 163, 74, .35);
        }
    }
</style>

<div class="row g-4">
    <div class="{{ $sv ? 'col-12' : 'col-lg-8' }}">

        {{-- Informasi menu dan jadwal pengambilan --}}
        <div class="hero mb-4 p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <span class="badge bg-success mb-2">Pesan hari ini, ambil besok</span>
                    <h1 class="display-6 fw-bold mb-1" style="color:#14532d">Menu Besok Pagi</h1>
                    <div class="text-muted">
                        <i class="bi bi-calendar3"></i>
                        {{ $tomorrow->translatedFormat('l, d F Y') }} ·
                        <i class="bi bi-clock"></i>
                        {{ $start }}–{{ $end }} · bayar tunai saat ambil
                    </div>
                </div>

                <span class="badge rounded-pill {{ $sisa > 0 ? 'bg-success' : 'bg-secondary' }} fs-6 px-3 py-2">
                    {{ $sisa > 0 ? "Sisa kuota $sisa porsi" : 'Kuota penuh' }}
                </span>
            </div>

            <a href="/acara" class="small d-inline-block mt-2">
                Butuh pesanan untuk acara / tanggal lain? →
            </a>
        </div>

        {{-- Pencarian menu --}}
        <div class="position-relative mb-3">
            <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-muted"></i>
            <input id="q" class="form-control form-control-lg rounded-pill ps-5 shadow-sm"
                placeholder="Cari nama menu...">
        </div>

        {{-- Daftar menu --}}
        <div class="row g-3">
            @forelse($menus as $m)
                <div class="col-6 col-md-4 mi" data-n="{{ strtolower($m->name) }}">
                    <div class="card fcard h-100" data-card="{{ $m->id }}">

                        {{-- Foto menu atau emoji pengganti --}}
                        @if($m->photo)
                            <img class="fimg" src="{{ asset('storage/'.$m->photo) }}" alt="{{ $m->name }}">
                        @else
                            <div class="fph">{{ $emo[$loop->index % 5] }}</div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="small fw-semibold" style="color:#4d8f1f">Menu Besok</div>
                            <h2 class="h6 fw-bold mb-1">{{ $m->name }}</h2>
                            <p class="small text-muted mb-2">
                                {{ $m->description ?: ($m->show_note ? $m->note : '') }}
                            </p>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="fw-bold text-danger fs-6">
                                        Rp {{ number_format($m->price, 0, ',', '.') }}
                                    </span>
                                    <span class="badge {{ $sisa > 0 ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                        {{ $sisa > 0 ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </div>

                                @unless($sv)
                                    {{-- Tombol menambahkan menu --}}
                                    <button class="btn btn-danger w-100 rounded-pill add"
                                        data-add="{{ $m->id }}" @disabled($sisa < 1)>
                                        <i class="bi bi-plus-lg"></i> Tambah
                                    </button>

                                    {{-- Pengaturan jumlah menu --}}
                                    <div class="stp align-items-center justify-content-between">
                                        <button type="button" class="btn btn-outline-danger rounded-circle"
                                            data-d="{{ $m->id }}">−</button>
                                        <b class="qn fs-5">0</b>
                                        <button type="button" class="btn btn-danger rounded-circle"
                                            data-i="{{ $m->id }}">+</button>
                                    </div>
                                @endunless
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada menu aktif.</p>
            @endforelse
        </div>
    </div>

    @unless($sv)
        {{-- Keranjang pesanan pelanggan --}}
        <div class="col-lg-4">
            <aside class="offcanvas-lg offcanvas-end" id="cart" tabindex="-1">
                <div class="card border border-success border-2 shadow">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center"
                        style="border-radius:12px 12px 0 0">
                        <span class="fw-bold">
                            <i class="bi bi-basket3"></i> Keranjang Pesanan
                        </span>
                        <button class="btn-close btn-close-white d-lg-none"
                            data-bs-dismiss="offcanvas" data-bs-target="#cart"></button>
                    </div>

                    <form method="post" action="/pesanan" id="cf" class="card-body">
                        @csrf
                        <input type="hidden" name="pickup_date" value="{{ $tomorrow->toDateString() }}">

                        {{-- Daftar menu dalam keranjang --}}
                        <div id="items" style="max-height:45vh;overflow:auto"></div>

                        {{-- Jadwal pengambilan --}}
                        <div class="my-2">
                            <label class="form-label small mb-1">
                                Jam ambil besok ({{ $start }}–{{ $end }})
                            </label>
                            <input type="time" name="pickup_time" min="{{ $start }}" max="{{ $end }}"
                                value="{{ old('pickup_time', $start) }}" class="form-control" required>
                        </div>

                        {{-- Total pembayaran --}}
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span id="tt">Rp 0</span>
                        </div>
                        <small class="text-muted d-block mb-2">
                            Harga final dihitung server. Menunggu konfirmasi admin.
                        </small>

                        {{-- Tombol konfirmasi pesanan --}}
                        @auth
                            <button class="btn btn-danger w-100 rounded-pill py-2" id="ck">
                                Konfirmasi Pesanan
                            </button>
                        @else
                            <a href="/login" class="btn btn-danger w-100 rounded-pill py-2">
                                Masuk untuk memesan
                            </a>
                        @endauth
                    </form>
                </div>
            </aside>
        </div>

        {{-- Keranjang versi mobile --}}
        <div id="bar" class="d-lg-none position-fixed bottom-0 start-0 end-0 p-3"
            style="display:none;z-index:1030">
            <button class="btn btn-success w-100 rounded-pill py-3 d-flex justify-content-between px-4 shadow-lg"
                data-bs-toggle="offcanvas" data-bs-target="#cart">
                <span><i class="bi bi-basket3"></i> <b id="bc">0</b> item</span>
                <span id="bt">Rp 0</span>
                <span>Lihat Keranjang ›</span>
            </button>
        </div>

        @push('js')
            <script>
                // Data menu dan kuota yang tersedia
                const M = @json($menus->map(fn($m) => ['n' => $m->name, 'p' => $m->price])->all());
                const IDS = @json($menus->pluck('id'));
                const SISA = {{ $sisa }};

                const MM = {};
                IDS.forEach((id, i) => MM[id] = M[i]);

                // Mengambil data keranjang dari localStorage
                let C = JSON.parse(localStorage.uc || '{}');

                const f = n => 'Rp ' + n.toLocaleString('id-ID');
                const oc = () => bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('cart'));

                // Memperbarui tampilan keranjang
                function draw() {
                    let t = 0, c = 0, h = '';

                    for (const id in C) {
                        if (!MM[id]) {
                            delete C[id];
                            continue;
                        }

                        const q = C[id];
                        t += q * MM[id].p;
                        c += q;

                        h += `
                            <div class="d-flex align-items-center justify-content-between border-bottom py-2">
                                <div>
                                    <div class="fw-semibold">${MM[id].n}</div>
                                    <small class="text-muted">${f(MM[id].p)} × ${q}</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-d="${id}">−</button>
                                    <b>${q}</b>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-i="${id}">+</button>
                                    <button type="button" class="btn btn-sm text-danger" data-x="${id}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="qty[${id}]" value="${q}">
                            </div>`;
                    }

                    // Menampilkan isi keranjang atau pesan kosong
                    items.innerHTML = h || `
                        <p class="text-muted text-center my-4">
                            Keranjang masih kosong.<br>
                            Tekan <b>Tambah</b> pada menu.
                        </p>`;

                    // Memperbarui total dan jumlah item
                    tt.textContent = f(t);
                    bc.textContent = c;
                    bt.textContent = f(t);
                    bar.style.display = c ? 'block' : 'none';

                    const k = document.getElementById('ck');
                    if (k) k.disabled = !c;

                    // Memperbarui tombol pada setiap kartu menu
                    document.querySelectorAll('[data-card]').forEach(cd => {
                        const q = C[cd.dataset.card] || 0;
                        cd.querySelector('.add').style.display = q ? 'none' : '';
                        cd.querySelector('.stp').classList.toggle('on', q > 0);
                        cd.querySelector('.qn').textContent = q;
                    });

                    // Menyimpan keranjang ke localStorage
                    localStorage.uc = JSON.stringify(C);
                    window.N = c;
                }

                // Mengatur penambahan dan pengurangan menu
                document.addEventListener('click', e => {
                    const b = e.target.closest('[data-add],[data-i],[data-d],[data-x]');
                    if (!b) return;

                    const id = b.dataset.add || b.dataset.i || b.dataset.d || b.dataset.x;
                    const was = window.N || 0;

                    if (b.dataset.add || b.dataset.i) {
                        if (was >= SISA) {
                            alert('Kuota besok hanya tersisa ' + SISA + ' porsi.');
                            return;
                        }

                        C[id] = Math.min(100, (C[id] || 0) + 1);
                    } else if (b.dataset.d) {
                        C[id] = (C[id] || 1) - 1;
                        if (C[id] < 1) delete C[id];
                    } else {
                        delete C[id];
                    }

                    draw();

                    // Memberikan efek ketika menu ditambahkan
                    if (b.dataset.add || b.dataset.i) {
                        const cd = document.querySelector('#cart .card');
                        cd.classList.remove('pulse');
                        void cd.offsetWidth;
                        cd.classList.add('pulse');

                        if (was === 0 && innerWidth < 992) oc().show();
                    }
                });

                // Menghapus data keranjang setelah pesanan dikirim
                cf.addEventListener('submit', () => localStorage.removeItem('uc'));

                draw();
            </script>
        @endpush
    @endunless
</div>

{{-- Fitur pencarian menu --}}
@push('js')
    <script>
        document.getElementById('q').oninput = e => {
            const v = e.target.value.toLowerCase();

            document.querySelectorAll('.mi').forEach(c => {
                c.style.display = c.dataset.n.includes(v) ? '' : 'none';
            });
        };
    </script>
@endpush

@endsection