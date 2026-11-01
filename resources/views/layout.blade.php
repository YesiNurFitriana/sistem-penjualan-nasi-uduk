@php
    // Memeriksa pengguna dan hak akses staf
    $u = auth()->user();
    $staff = $u && in_array($u->role, ['admin', 'kasir']);

    // Mengatur menu navigasi berdasarkan role pengguna
    $nav = !$staff ? [] : (
        $u->role === 'admin'
            ? [
                ['/admin/dashboard', 'bi-speedometer2', 'Dashboard', 'admin/dashboard*'],
                ['/kasir', 'bi-cash-coin', 'Kasir', 'kasir*'],
                ['/admin/menu', 'bi-egg-fried', 'Kelola Menu', 'admin/menu*'],
                ['/admin/batch', 'bi-boxes', 'Batch & Stok', 'admin/batch*'],
                ['/admin/pesanan', 'bi-bag-check', 'Pesanan Online', 'admin/pesanan*'],
                ['/admin/acara', 'bi-calendar-event', 'Pesanan Acara', 'admin/acara*'],
                ['/admin/pengaturan', 'bi-gear', 'Pengaturan', 'admin/pengaturan*']
            ]
            : [
                ['/kasir', 'bi-cash-coin', 'Kasir', 'kasir*']
            ]
    );
@endphp

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'UduxMu')</title>

    {{-- Bootstrap, Bootstrap Icons, dan font logo --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@600;700&display=swap" rel="stylesheet">

    <style>
        /* Logo UduxMu */
        .logo {
            position: relative;
            display: inline-block;
            font-family: "Fredoka", system-ui, sans-serif;
            font-weight: 700;
            color: #4d8f1f;
            line-height: 1;
            padding-bottom: .4em;
            letter-spacing: -.5px;
        }

        .logo svg {
            position: absolute;
            left: 14%;
            bottom: 0;
            width: 36%;
        }

        /* Warna utama tema hijau */
        :root {
            --g: #16a34a;
            --gd: #14532d;
            --gl: #dcfce7;
        }

        .btn-danger,
        .btn-success {
            --bs-btn-bg: var(--g);
            --bs-btn-border-color: var(--g);
            --bs-btn-hover-bg: #15803d;
            --bs-btn-hover-border-color: #15803d;
            --bs-btn-active-bg: #166534;
        }

        .btn-outline-danger {
            --bs-btn-color: #15803d;
            --bs-btn-border-color: #15803d;
            --bs-btn-hover-bg: #15803d;
            --bs-btn-hover-border-color: #15803d;
            --bs-btn-active-bg: #15803d;
        }

        .text-danger { color: #15803d !important; }

        /* Tampilan kartu dan input */
        .card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--g);
            box-shadow: 0 0 0 .2rem rgba(22, 163, 74, .2);
        }

        @if($staff)
            /* Tampilan dashboard admin dan kasir */
            body { background: #f3f4f6; }

            .shell {
                display: flex;
                min-height: 100vh;
            }

            /* Sidebar */
            #sb {
                width: 250px;
                background: var(--gd);
                color: #d1fae5;
                position: sticky;
                top: 12px;
                height: calc(100vh - 24px);
                margin: 12px 0 12px 12px;
                border-radius: 20px;
                box-shadow: 0 10px 30px rgba(20, 83, 45, .35);
                display: flex;
                flex-direction: column;
                transition: width .2s;
                flex-shrink: 0;
                z-index: 1040;
            }

            #sb .brand {
                display: flex;
                align-items: center;
                gap: .75rem;
                padding: 1rem 1.1rem;
                color: #fff;
                font-weight: 700;
                font-size: 1.15rem;
                white-space: nowrap;
            }

            /* Link navigasi sidebar */
            #sb a.item {
                display: flex;
                align-items: center;
                gap: .85rem;
                padding: .7rem 1.35rem;
                color: #d1fae5;
                text-decoration: none;
                white-space: nowrap;
                border-radius: 10px;
                margin: 2px .6rem;
            }

            #sb a.item i {
                font-size: 1.2rem;
                min-width: 1.3rem;
            }

            #sb a.item:hover { background: rgba(255, 255, 255, .1); }
            #sb a.item.on { background: var(--g); color: #fff; }

            /* Sidebar ketika diperkecil */
            body.collapsed #sb { width: 76px; }
            body.collapsed #sb .lbl { display: none; }

            body.collapsed #sb .brand {
                flex-direction: column;
                gap: .4rem;
                padding: 1rem 0;
                align-items: center;
            }

            body.collapsed #sb a.item {
                justify-content: center;
                padding: .7rem 0;
            }

            /* Area konten dan navbar atas */
            main.content {
                flex: 1;
                min-width: 0;
            }

            .topbar {
                background: #fff;
                border-bottom: 1px solid #e5e7eb;
                padding: .6rem 1.25rem;
                display: flex;
                align-items: center;
                gap: 1rem;
                position: sticky;
                top: 0;
                z-index: 1030;
            }

            /* Tampilan sidebar pada perangkat mobile */
            @media(max-width: 767px) {
                #sb {
                    position: fixed;
                    left: 0;
                    top: 0;
                    height: 100vh;
                    margin: 0;
                    border-radius: 0 20px 20px 0;
                    transform: translateX(-100%);
                    width: 250px !important;
                }

                body.mopen #sb { transform: none; }
                body.collapsed #sb .lbl { display: inline; }

                body.collapsed #sb a.item {
                    justify-content: flex-start;
                    padding: .7rem 1.35rem;
                }

                body.mopen::after {
                    content: "";
                    position: fixed;
                    inset: 0;
                    background: rgba(0, 0, 0, .4);
                    z-index: 1035;
                }

                #sb { z-index: 1040; }
            }

        @else
            /* Tampilan halaman pelanggan */
            body { background: #f6f7f4; }

            .cnav {
                background: #fff;
                box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
            }

            .nav-l {
                color: #374151;
                text-decoration: none;
                padding: .35rem 0;
                border-bottom: 2px solid transparent;
                white-space: nowrap;
            }

            .nav-l.on,
            .nav-l:hover {
                color: #3f7d1c;
                border-color: #facc15;
            }

            /* Banner halaman pelanggan */
            .hero {
                background: linear-gradient(135deg, #dcfce7, #f7fee7);
                border-radius: 20px;
            }

            /* Kartu menu */
            .fcard {
                border: 1px solid #e5e7eb;
                border-radius: 14px;
                overflow: hidden;
                box-shadow: none;
                transition: transform .15s, box-shadow .15s;
            }

            .fcard:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 24px rgba(77, 143, 31, .18);
            }

            .fimg {
                height: 150px;
                object-fit: cover;
                width: 100%;
            }

            /* Tampilan pengganti jika menu tidak memiliki foto */
            .fph {
                height: 150px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 3.2rem;
                background: linear-gradient(135deg, #bbf7d0, #fef9c3);
            }

            /* Splash screen halaman pelanggan */
            #splash {
                position: fixed;
                inset: 0;
                z-index: 3000;
                background: #3f7d1c center/cover;
                transition: opacity .6s;
            }
        @endif

        /* Menyembunyikan elemen tertentu saat dicetak */
        @media print {
            .no-print,
            #sb,
            .topbar,
            .cnav {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    @unless($staff)
        {{-- Splash screen untuk pelanggan --}}
        <div id="splash" style="background-image:url('{{ asset('img/splash.jpg') }}')"></div>

        <script>
            (function () {
                var s = document.getElementById('splash');

                if (sessionStorage.sp) {
                    s.remove();
                    return;
                }

                setTimeout(function () {
                    s.style.opacity = 0;
                    setTimeout(function () {
                        s.remove();
                    }, 600);

                    sessionStorage.sp = 1;
                }, 1800);
            })();
        </script>
    @endunless

    @if($staff)
        {{-- Layout khusus admin dan kasir --}}
        <div class="shell">
            <aside id="sb">

                {{-- Logo dan tombol sidebar --}}
                <div class="brand">
                    <i class="bi bi-shop fs-4"></i>
                    <span class="lbl">UduxMu</span>
                    <button id="tg2" type="button"
                        class="btn btn-sm text-white ms-auto p-0 border-0 d-none d-md-inline"
                        title="Lebarkan / ciutkan">
                        <i class="bi bi-chevron-bar-contract fs-5"></i>
                    </button>
                </div>

                {{-- Navigasi berdasarkan role --}}
                <nav class="flex-grow-1 pt-2">
                    @foreach($nav as [$url, $ic, $lb, $pat])
                        <a href="{{ $url }}" title="{{ $lb }}"
                            class="item {{ request()->is($pat) ? 'on' : '' }}">
                            <i class="bi {{ $ic }}"></i>
                            <span class="lbl">{{ $lb }}</span>
                        </a>
                    @endforeach
                </nav>

                {{-- Tombol logout --}}
                <form method="post" action="/logout" class="p-2">
                    @csrf
                    <button class="item w-100 border-0 bg-transparent text-start d-flex align-items-center gap-3 px-4 py-2"
                        style="color:#d1fae5" title="Keluar">
                        <i class="bi bi-box-arrow-left fs-5"></i>
                        <span class="lbl">Keluar</span>
                    </button>
                </form>
            </aside>

            {{-- Konten utama dashboard --}}
            <main class="content">
                <div class="topbar no-print">
                    <button id="tg" class="btn btn-light border" aria-label="Menu">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <span class="fw-semibold">@yield('title', 'UduxMu')</span>
                    <span class="ms-auto text-muted small">
                        <i class="bi bi-person-circle"></i>
                        {{ $u->name }} · {{ ucfirst($u->role) }}
                    </span>
                </div>

                <div class="p-3 p-md-4">
    @else
        {{-- Navbar halaman pelanggan --}}
        <nav class="cnav sticky-top no-print mb-4">
            @php
                // Daftar menu navigasi pelanggan
                $lk = [
                    ['/', 'Menu Besok Pagi', '/'],
                    ['/acara', 'Pesanan Acara', 'acara']
                ];

                if ($u) {
                    $lk[] = ['/pesanan', 'Pesanan Saya', 'pesanan'];
                }
            @endphp

            <div class="container d-flex align-items-center gap-3 py-2">
                <a href="/" class="text-decoration-none">
                    @include('partials.logo', ['cls' => 'fs-3'])
                </a>

                <div class="d-none d-md-flex gap-4 ms-3 small fw-semibold">
                    @foreach($lk as [$h, $l, $pt])
                        <a class="nav-l {{ request()->is($pt) ? 'on' : '' }}" href="{{ $h }}">
                            {{ $l }}
                        </a>
                    @endforeach
                </div>

                {{-- Informasi akun pelanggan --}}
                <div class="ms-auto d-flex align-items-center gap-2">
                    @if($u)
                        <span class="small d-none d-sm-inline">{{ $u->name }}</span>
                        <form method="post" action="/logout">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a class="btn btn-danger btn-sm rounded-pill px-3" href="/login">
                            Masuk / Daftar
                        </a>
                    @endif
                </div>
            </div>

            {{-- Navigasi versi mobile --}}
            <div class="d-md-none border-top">
                <div class="container d-flex gap-4 py-2 small fw-semibold overflow-auto">
                    @foreach($lk as [$h, $l, $pt])
                        <a class="nav-l {{ request()->is($pt) ? 'on' : '' }}" href="{{ $h }}">
                            {{ $l }}
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>

        <div class="container pb-5">
    @endif

    {{-- Notifikasi berhasil --}}
    @if(session('ok'))
        <div class="alert alert-success">{{ session('ok') }}</div>
    @endif

    {{-- Notifikasi validasi --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Konten halaman --}}
    @yield('content')

    @if($staff)
        </div>
        </main>
        </div>
    @else
        </div>

        {{-- Footer halaman pelanggan --}}
        <footer class="bg-white border-top mt-5 no-print">
            <div class="container py-5">
                <div class="row g-4">

                    {{-- Informasi toko --}}
                    <div class="col-md-5">
                        @include('partials.logo', ['cls' => 'fs-1'])
                        <p class="small text-muted mt-3 mb-2">
                            Pesan hari ini, ambil besok pagi.<br>
                            [Isi alamat toko UduxMu di sini]
                        </p>

                        <div class="small">
                            <i class="bi bi-whatsapp text-success"></i> [No. WhatsApp]<br>
                            <i class="bi bi-envelope text-success"></i> [email toko]
                        </div>

                        {{-- Media sosial --}}
                        <div class="mt-3 fs-4 d-flex gap-3">
                            <a class="text-success" href="#"><i class="bi bi-instagram"></i></a>
                            <a class="text-success" href="#"><i class="bi bi-facebook"></i></a>
                            <a class="text-success" href="#"><i class="bi bi-tiktok"></i></a>
                        </div>
                    </div>

                    {{-- Tautan pemesanan --}}
                    <div class="col-6 col-md-3">
                        <div class="fw-bold mb-2">Pesan</div>
                        <div class="d-grid gap-1 small">
                            <a class="text-muted text-decoration-none" href="/">Menu Besok Pagi</a>
                            <a class="text-muted text-decoration-none" href="/acara">Pesanan Acara</a>
                            <a class="text-muted text-decoration-none" href="/pesanan">Pesanan Saya</a>
                        </div>
                    </div>

                    {{-- Tautan lainnya --}}
                    <div class="col-6 col-md-4">
                        <div class="fw-bold mb-2">Lainnya</div>
                        <div class="d-grid gap-1 small">
                            <a class="text-muted text-decoration-none" href="/daftar">Daftar Pelanggan</a>
                            <a class="text-muted text-decoration-none" href="/admin/login">Login Staf</a>
                        </div>
                    </div>
                </div>

                {{-- Hak cipta --}}
                <div class="text-center small text-muted pt-4 mt-4 border-top">
                    © 2026 UduxMu. Hak cipta dilindungi.
                </div>
            </div>
        </footer>
    @endif

    {{-- Bootstrap JavaScript --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if($staff)
        <script>
            // Mengatur kondisi sidebar
            const b = document.body;

            if (localStorage.sb === '1') {
                b.classList.add('collapsed');
            }

            // Tombol sidebar dan menu mobile
            document.getElementById('tg').onclick = () => {
                if (innerWidth < 768) {
                    b.classList.toggle('mopen');
                } else {
                    b.classList.toggle('collapsed');
                    localStorage.sb = b.classList.contains('collapsed') ? '1' : '0';
                }
            };

            // Tombol pada bagian brand menggunakan fungsi yang sama
            document.getElementById('tg2').onclick = () => {
                document.getElementById('tg').click();
            };

            // Menutup sidebar mobile ketika area luar diklik
            document.addEventListener('click', e => {
                if (b.classList.contains('mopen') && !e.target.closest('#sb,#tg')) {
                    b.classList.remove('mopen');
                }
            });
        </script>
    @endif

    {{-- Menampilkan JavaScript dari halaman --}}
    @stack('js')

</body>
</html>