@extends('layout')@section('content')
<h1 class="h3 mb-3">Menu Hari Ini</h1>
<div class="row g-3">@forelse($menus as $m)<div class="col-6 col-md-4 col-lg-3"><div class="card h-100">
@if($m->photo)<img src="{{ asset('storage/'.$m->photo) }}" class="card-img-top" style="height:160px;object-fit:cover" alt="{{ $m->name }}">@endif
<div class="card-body"><h2 class="h6">{{ $m->name }}</h2><div class="fw-bold text-danger">Rp {{ number_format($m->price,0,',','.') }}</div>
@if($m->show_note && $m->note)<small class="text-muted">{{ $m->note }}</small>@endif</div></div></div>
@empty<p class="text-muted">Belum ada menu aktif.</p>@endforelse</div>
<a href="/pesanan" class="btn btn-danger mt-4">Pesan Online</a>
@endsection
