@extends('layout')@section('content')
<h1 class="h3">Pesanan Online</h1>
@foreach($orders as $o)<div class="card mb-3"><div class="card-body">
<div class="d-flex justify-content-between flex-wrap"><strong>#{{ $o->id }} — {{ $o->user->name }} ({{ $o->user->phone }})</strong><span class="badge bg-secondary">{{ $o->status }}</span></div>
<div>Ambil: {{ $o->pickup_date->format('d/m/Y') }} {{ substr($o->pickup_time,0,5) }} · Total Rp {{ number_format($o->total,0,',','.') }}</div>
<ul class="mb-2">@foreach($o->items as $i)<li>{{ $i->menu->name }} × {{ $i->qty }}</li>@endforeach</ul>
@php $next=['Menunggu Konfirmasi'=>['konfirmasi'=>'Konfirmasi'],'Dikonfirmasi'=>['siapkan'=>'Mulai Siapkan'],'Sedang Disiapkan'=>['siap'=>'Siap Diambil'],'Siap Diambil'=>[]][$o->status] ?? []; @endphp
<div class="d-flex flex-wrap gap-2 align-items-center">
@foreach($next as $a=>$l)<form method="post" action="/admin/pesanan/{{ $o->id }}/{{ $a }}">@csrf<button class="btn btn-sm btn-success">{{ $l }}</button></form>@endforeach
@if($o->status==='Menunggu Konfirmasi')<form method="post" action="/admin/pesanan/{{ $o->id }}/tolak" class="d-flex gap-1">@csrf<input name="alasan" class="form-control form-control-sm" placeholder="Alasan tolak" required><button class="btn btn-sm btn-outline-danger">Tolak</button></form>@endif
@if($o->status==='Siap Diambil')<form method="post" action="/admin/pesanan/{{ $o->id }}/selesai" class="d-flex gap-2 align-items-center">@csrf
<label class="form-check-label"><input type="checkbox" name="uang_diterima" value="1" class="form-check-input"> Uang tunai diterima</label><button class="btn btn-sm btn-primary">Serahkan</button></form>@endif
@unless(in_array($o->status,['Selesai','Ditolak','Dibatalkan']))<form method="post" action="/admin/pesanan/{{ $o->id }}/batal" onsubmit="return confirm('Batalkan pesanan?')">@csrf<button class="btn btn-sm btn-outline-secondary">Batalkan</button></form>@endunless
</div></div></div>@endforeach{{ $orders->links() }}
@endsection
