
<!DOCTYPE html>
<html lang="id">
<head>
    @vite(['resources/css/login.css', 'resources/js/login.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <title>Masuk — UduxPOS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;700;800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="{{ asset('js/login.js') }}"></script>
</head>
<body>

<main class="login-layout">

    <section class="login-form">

        <a href="/" class="brand" aria-label="UduxPOS beranda">
            <span class="brand-icon">
                <svg viewBox="0 0 40 40" aria-hidden="true">
                    <circle cx="20" cy="20" r="20" fill="#176b3a"/>
                    <path d="M8 24h24c0 5-5 9-12 9S8 29 8 24z" fill="#fff2cf"/>
                    <path d="M11 24c0-6 4-10 9-10s9 4 9 10z" fill="#fff"/>
                    <circle cx="26" cy="21" r="2.4" fill="#f2b632"/>
                    <circle cx="14" cy="22" r="1.6" fill="#d9432b"/>
                </svg>
            </span>
            <span>Udux<span class="brand-pos">POS</span></span>
        </a>

        <div class="heading">
            <span class="eyebrow">SELAMAT DATANG</span>
            <h1>Senang bertemu<br>kembali!</h1>
            <p>Masuk untuk memesan menu favorit atau mengelola warung hari ini.</p>
        </div>

        <div class="account-tabs" role="tablist" aria-label="Jenis akun">
            <button type="button" role="tab"
                    aria-selected="true" data-role="customer">
                Pelanggan
            </button>
            <button type="button" role="tab"
                    aria-selected="false" data-role="admin">
                Admin
            </button>
        </div>

        <form id="loginForm" novalidate>
            <div class="form-group" id="emailGroup">
                <label for="email">Alamat email</label>

                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="5" width="18" height="14" rx="3"/>
                        <path d="m4 8 8 6 8-6"/>
                    </svg>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="nama@email.com"
                        autocomplete="email"
                        required
                    >
                </div>
                <small class="error-message">Masukkan alamat email yang valid.</small>
            </div>

            <div class="form-group" id="passwordGroup">
                <div class="label-row">
                    <label for="password">Kata sandi</label>
                    <a href="#" id="forgotPassword">Lupa kata sandi?</a>
                </div>

                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="4" y="10" width="16" height="10" rx="3"/>
                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                    </svg>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Masukkan kata sandi"
                        autocomplete="current-password"
                        required
                    >

                    <button type="button" class="toggle-password"
                            id="togglePassword"
                            aria-label="Tampilkan kata sandi">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                <small class="error-message">Kata sandi wajib diisi.</small>
            </div>

            <label class="remember">
                <input type="checkbox" id="remember">
                <span>Ingat saya di perangkat ini</span>
            </label>

            <button type="submit" class="login-button" id="loginButton">
                <span>Masuk sekarang</span>
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M5 12h14m-6-6 6 6-6 6"/>
                </svg>
            </button>

            <p class="form-message" id="formMessage" role="status"></p>
        </form>

        <p class="register-text" id="registerText">
            Belum punya akun?
            <a href="#" id="registerLink">Daftar sebagai pelanggan</a>
        </p>

        <p class="copyright">© {{ date('Y') }} UduxPOS. Dibuat dengan sepenuh hati.</p>

    </section>

    <aside class="visual-panel" aria-label="Ilustrasi menu nasi uduk">
        <div class="visual-decoration decoration-one"></div>
        <div class="visual-decoration decoration-two"></div>

        <div class="visual-top">
            <span class="status-dot"></span>
            <span>HANGAT • SEGAR • LEZAT</span>
        </div>

        <div class="food-illustration">
            <svg viewBox="0 0 500 420" role="img"
                 aria-label="Ilustrasi sepiring nasi uduk dengan lauk">
                <defs>
                    <linearGradient id="plate" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#ffffff"/>
                        <stop offset="100%" stop-color="#e9eddf"/>
                    </linearGradient>
                    <linearGradient id="rice" x1="0" y1="0" x2="0.8" y2="1">
                        <stop offset="0%" stop-color="#fffdf4"/>
                        <stop offset="100%" stop-color="#eee1b7"/>
                    </linearGradient>
                    <linearGradient id="chicken" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#f8c66d"/>
                        <stop offset="100%" stop-color="#c7792c"/>
                    </linearGradient>
                </defs>

                <ellipse cx="250" cy="320" rx="178" ry="37"
                         fill="#103e24" opacity=".16"/>

                <ellipse cx="250" cy="280" rx="195" ry="76"
                         fill="#174d2d"/>
                <ellipse cx="250" cy="267" rx="190" ry="70"
                         fill="url(#plate)"/>
                <ellipse cx="250" cy="260" rx="161" ry="54"
                         fill="#fff"/>

                <path d="M169 253c0-57 36-100 81-100s81 43 81 100
                         c0 22-38 34-81 34s-81-12-81-34z"
                      fill="url(#rice)"/>

                <g fill="#fff" opacity=".95">
                    <ellipse cx="219" cy="184" rx="9" ry="4" transform="rotate(-25 219 184)"/>
                    <ellipse cx="252" cy="172" rx="9" ry="4"/>
                    <ellipse cx="280" cy="190" rx="9" ry="4" transform="rotate(22 280 190)"/>
                    <ellipse cx="302" cy="216" rx="9" ry="4"/>
                    <ellipse cx="225" cy="225" rx="9" ry="4"/>
                    <ellipse cx="264" cy="241" rx="9" ry="4"/>
                    <ellipse cx="285" cy="201" rx="8" ry="4"/>
                </g>

                <path d="M108 257c-11-26 12-55 40-59l29 19-9 47
                         c-21 16-49 13-60-7z"
                      fill="url(#chicken)"/>
                <path d="M125 231c14-12 26-14 39-10"
                      fill="none" stroke="#ffdc8b" stroke-width="5"
                      stroke-linecap="round"/>

                <g fill="#a7652d">
                    <rect x="336" y="233" width="39" height="25" rx="6"
                          transform="rotate(-8 336 233)"/>
                    <rect x="369" y="248" width="38" height="25" rx="6"
                          transform="rotate(10 369 248)"/>
                </g>
                <g stroke="#e5a65e" stroke-width="3" stroke-linecap="round">
                    <path d="M347 240h17M379 255h17"/>
                </g>

                <ellipse cx="288" cy="272" rx="33" ry="12" fill="#b93820"/>
                <ellipse cx="288" cy="268" rx="27" ry="9" fill="#e6532f"/>

                <g fill="#78b76a">
                    <ellipse cx="208" cy="270" rx="12" ry="8" transform="rotate(-25 208 270)"/>
                    <ellipse cx="225" cy="279" rx="12" ry="8" transform="rotate(20 225 279)"/>
                </g>

                <g stroke="#fff" stroke-width="4" fill="none"
                   stroke-linecap="round" opacity=".85">
                    <path d="M215 118c-13-16 13-26 0-42"/>
                    <path d="M250 108c-13-16 13-26 0-42"/>
                    <path d="M285 118c-13-16 13-26 0-42"/>
                </g>

                <g transform="translate(64 92)">
                    <circle cx="0" cy="0" r="29" fill="#fff"/>
                    <path d="M-12 4h24v11h-24z" fill="#f0b731"/>
                    <path d="M-12 4c0-8 5-13 12-13S12-4 12 4z" fill="#fff4d3"/>
                    <path d="M-12 15h24" stroke="#1f7a43" stroke-width="3"/>
                </g>

                <g transform="translate(420 143)">
                    <circle cx="0" cy="0" r="27" fill="#f2b632"/>
                    <path d="M-10-6h20M-10 0h20M-10 6h20"
                          stroke="#81520b" stroke-width="3" stroke-linecap="round"/>
                </g>
            </svg>
        </div>

        <div class="visual-caption">
            <span class="caption-label">SARAPAN JADI LEBIH MUDAH</span>
            <h2>Rasa rumahan,<br>hangat di setiap suapan.</h2>
            <p>Pesan lebih awal, ambil sarapanmu tanpa ribet.</p>
        </div>

        <div class="visual-footer">
            <span>Disiapkan dengan sepenuh hati</span>
            <span class="footer-star">✳</span>
        </div>
    </aside>

</main>

</body>
</html>
