@extends('layout')@section('title','Pesanan Online')@section('content')
<ul class="nav nav-pills mb-3 gap-1">@foreach(['minggu'=>'Minggu Ini','lainnya'=>'Bukan Minggu Ini','riwayat'=>'Riwayat'] as $k=>$l)
<li class="nav-item"><a class="nav-link {{ $tab===$k?'active bg-success':'text-success' }}" href="?tab={{ $k }}">{{ $l }} <span class="badge bg-light text-dark">{{ $counts[$k] }}</span></a></li>@endforeach</ul>
@forelse($orders as $o)<div class="card mb-3"><div class="card-body">
<div class="d-flex justify-content-between flex-wrap gap-1"><strong>#{{ $o->id }} — {{ $o->user->name }} ({{ $o->user->phone }})</strong><span class="badge bg-success">{{ $o->status }}</span></div>
<div>Ambil: {{ $o->pickup_date->translatedFormat('D, d/m/Y') }} {{ substr($o->pickup_time,0,5) }} · Total Rp {{ number_format($o->total,0,',','.') }}</div>
<ul class="mb-2">@foreach($o->items as $i)<li>{{ $i->menu->name }} × {{ $i->qty }}</li>@endforeach</ul>
@if($o->reject_reason)<div class="text-danger small">Ditolak: {{ $o->reject_reason }}</div>@endif
@php $next=['Menunggu Konfirmasi'=>['konfirmasi'=>'Konfirmasi'],'Dikonfirmasi'=>['siapkan'=>'Mulai Siapkan'],'Sedang Disiapkan'=>['siap'=>'Siap Diambil']][$o->status] ?? []; @endphp
<div class="d-flex flex-wrap gap-2 align-items-center">
@foreach($next as $a=>$l)<form method="post" action="/admin/pesanan/{{ $o->id }}/{{ $a }}">@csrf<button class="btn btn-sm btn-success">{{ $l }}</button></form>@endforeach
@if($o->status==='Menunggu Konfirmasi')<form method="post" action="/admin/pesanan/{{ $o->id }}/tolak" class="d-flex gap-1">@csrf<input name="alasan" class="form-control form-control-sm" placeholder="Alasan tolak" required><button class="btn btn-sm btn-outline-danger">Tolak</button></form>@endif
@if($o->status==='Siap Diambil')<form method="post" action="/admin/pesanan/{{ $o->id }}/selesai" class="d-flex gap-2 align-items-center">@csrf<label class="form-check-label"><input type="checkbox" name="uang_diterima" value="1" class="form-check-input"> Uang tunai diterima</label><button class="btn btn-sm btn-primary">Serahkan</button></form>@endif
@unless(in_array($o->status,['Selesai','Ditolak','Dibatalkan']))<form method="post" action="/admin/pesanan/{{ $o->id }}/batal" onsubmit="return confirm('Batalkan pesanan?')">@csrf<button class="btn btn-sm btn-outline-secondary">Batalkan</button></form>@endunless
</div></div></div>
@empty<div class="card"><div class="card-body text-center text-muted py-5"><i class="bi bi-inbox fs-1"></i><div class="mt-2">Belum ada pesanan.</div></div></div>@endforelse
{{ $orders->links() }}
@endsection
