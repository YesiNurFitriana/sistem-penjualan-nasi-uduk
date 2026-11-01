@extends('layout')@section('content')
<div class="card mx-auto" style="max-width:420px"><div class="card-body"><h1 class="h4">{{ $staff ? 'Login Staf (Admin/Kasir)' : 'Masuk Pelanggan' }}</h1>
<form method="post" action="{{ $staff ? '/admin/login' : '/login' }}">@csrf
<div class="mb-3"><label class="form-label">Email</label><input name="email" type="email" value="{{ old('email') }}" class="form-control" required></div>
<div class="mb-3"><label class="form-label">Kata sandi</label><input name="password" type="password" class="form-control" required></div>
<button class="btn btn-danger w-100">Masuk</button></form>
@unless($staff)<p class="mt-3 mb-0">Belum punya akun? <a href="/daftar">Daftar</a></p>@endunless</div></div>
@endsection
