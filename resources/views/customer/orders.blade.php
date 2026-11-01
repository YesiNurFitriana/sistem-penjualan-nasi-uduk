@extends('layout')@section('content')
<h1 class="h3">Buat Pesanan</h1>
<form method="post" action="/pesanan" class="card card-body mb-4">@csrf
<div class="row g-2 mb-2"><div class="col-md-4"><label class="form-label">Tanggal ambil</label><input type="date" name="pickup_date" min="{{ today()->toDateString() }}" value="{{ old('pickup_date') }}" class="form-control" required></div>
<div class="col-md-4"><label class="form-label">Jam ambil (maks. 12:00)</label><input type="time" name="pickup_time" max="12:00" value="{{ old('pickup_time') }}" class="form-control" required></div></div>
<div class="row g-2">@foreach($menus as $m)<div class="col-6 col-md-3"><label class="form-label">{{ $m->name }}<br><small>Rp {{ number_format($m->price,0,',','.') }}</small></label><input type="number" min="0" name="qty[{{ $m->id }}]" value="{{ old('qty.'.$m->id,0) }}" class="form-control"></div>@endforeach</div>
<small class="text-muted mt-2">Pembayaran tunai saat pengambilan. Total dihitung server.</small>
<button class="btn btn-danger mt-3 align-self-start">Kirim Pesanan</button></form>
<h2 class="h5">Riwayat Pesanan</h2>
@forelse($orders as $o)<div class="card mb-2"><div class="card-body"><div class="d-flex justify-content-between"><strong>#{{ $o->id }} · {{ $o->pickup_date->format('d/m/Y') }} {{ substr($o->pickup_time,0,5) }}</strong><span class="badge bg-secondary">{{ $o->status }}</span></div>
<div>@foreach($o->items as $i){{ $i->menu->name }} ×{{ $i->qty }}@if(!$loop->last), @endif @endforeach — Rp {{ number_format($o->total,0,',','.') }}</div>
@if($o->reject_reason)<div class="text-danger">Alasan ditolak: {{ $o->reject_reason }}</div>@endif
@if($o->customerCanCancel())<form method="post" action="/pesanan/{{ $o->id }}/batal" class="mt-2" onsubmit="return confirm('Batalkan pesanan?')">@csrf<button class="btn btn-sm btn-outline-danger">Batalkan</button></form>
@elseif(!in_array($o->status,['Selesai','Ditolak','Dibatalkan']))<small class="text-muted">Tidak dapat dibatalkan sendiri; hubungi admin.</small>@endif</div></div>
@empty<p class="text-muted">Belum ada pesanan.</p>@endforelse
@endsection
