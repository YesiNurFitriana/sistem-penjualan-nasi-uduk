<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>@yield('title','UduxMu')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>@media print{.no-print{display:none!important}}</style></head><body class="bg-light">
<nav class="navbar navbar-expand-md navbar-dark bg-danger no-print mb-4"><div class="container">
<a class="navbar-brand fw-bold" href="/">UduxMu</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nv"><span class="navbar-toggler-icon"></span></button>
<div id="nv" class="collapse navbar-collapse"><ul class="navbar-nav me-auto">
<li class="nav-item"><a class="nav-link" href="/">Menu</a></li>
@auth @php $role = auth()->user()->role; @endphp
@if($role==='pelanggan')<li class="nav-item"><a class="nav-link" href="/pesanan">Pesanan Saya</a></li>@endif
@if(in_array($role,['admin','kasir']))<li class="nav-item"><a class="nav-link" href="/kasir">Kasir</a></li>@endif
@if($role==='admin')@foreach(['menu'=>'Kelola Menu','batch'=>'Batch & Stok','pesanan'=>'Pesanan Online','pengaturan'=>'Pengaturan'] as $u=>$l)
<li class="nav-item"><a class="nav-link" href="/admin/{{ $u }}">{{ $l }}</a></li>@endforeach @endif
@endauth</ul>
<div class="d-flex gap-2">@auth<span class="navbar-text text-white">{{ auth()->user()->name }}</span>
<form method="post" action="/logout">@csrf<button class="btn btn-light btn-sm">Keluar</button></form>
@else<a class="btn btn-light btn-sm" href="/login">Masuk</a><a class="btn btn-outline-light btn-sm" href="/daftar">Daftar</a>@endauth</div></div></div></nav>
<main class="container pb-5">
@if(session('ok'))<div class="alert alert-success">{{ session('ok') }}</div>@endif
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
@yield('content')</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>@stack('js')</body></html>
