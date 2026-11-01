@extends('layout')@section('title','Pesanan Acara')@section('content')
@foreach($orders as $s)<div class="card mb-3"><div class="card-body"><div class="d-flex justify-content-between flex-wrap gap-2"><strong>#{{ $s->id }} · {{ $s->event_type }} — {{ $s->name }}</strong><span class="badge bg-success">{{ $s->status }}</span></div>
<div>Tanggal {{ $s->event_date->format('d/m/Y') }} · ambil {{ substr($s->pickup_time,0,5) }} · WA <a href="https://wa.me/{{ preg_replace('/^0/','62',preg_replace('/\D/','',$s->whatsapp)) }}" target="_blank">{{ $s->whatsapp }}</a></div>
<ul class="mb-1">@foreach($s->items as $i)<li>{{ $i['name'] }} × {{ $i['portions'] }} porsi</li>@endforeach</ul>@if($s->notes)<div class="text-muted small">Catatan: {{ $s->notes }}</div>@endif
@if($s->status==='Menunggu Konfirmasi')<form method="post" class="d-flex flex-wrap gap-2 mt-2">@csrf<input name="admin_note" class="form-control form-control-sm w-auto" placeholder="Catatan / alasan tolak">
<button formaction="/admin/acara/{{ $s->id }}/konfirmasi" class="btn btn-sm btn-success">Konfirmasi</button><button formaction="/admin/acara/{{ $s->id }}/tolak" class="btn btn-sm btn-outline-danger">Tolak</button></form>
@elseif($s->admin_note)<div class="small mt-1">Catatan admin: {{ $s->admin_note }}</div>@endif</div></div>@endforeach{{ $orders->links() }}
@endsection
