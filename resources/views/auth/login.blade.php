@extends('layout')

@section('content')

{{-- Card form login --}}
<div class="card mx-auto" style="max-width: 420px">
    <div class="card-body">

        {{-- Judul menyesuaikan jenis pengguna --}}
        <h1 class="h4">
            {{ $staff ? 'Login Staf (Admin/Kasir)' : 'Masuk Pelanggan' }}
        </h1>

        {{-- Form login --}}
        <form method="post" action="{{ $staff ? '/admin/login' : '/login' }}">
            @csrf

            {{-- Input email --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    class="form-control"
                    required
                >
            </div>

            {{-- Input kata sandi --}}
            <div class="mb-3">
                <label class="form-label">Kata sandi</label>
                <input
                    name="password"
                    type="password"
                    class="form-control"
                    required
                >
            </div>

            {{-- Tombol masuk --}}
            <button class="btn btn-danger w-100">Masuk</button>
        </form>

        {{-- Link daftar hanya ditampilkan untuk pelanggan --}}
        @unless($staff)
            <p class="mt-3 mb-0">
                Belum punya akun? <a href="/daftar">Daftar</a>
            </p>
        @endunless

    </div>
</div>

@endsection