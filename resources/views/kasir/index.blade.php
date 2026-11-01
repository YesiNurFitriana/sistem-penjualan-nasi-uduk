@extends('layout')@section('content')
<h1 class="h3">Kasir</h1>
<form method="post" action="/kasir">@csrf
<div class="table-responsive"><table class="table bg-white align-middle"><tr><th>Menu</th><th>Harga</th><th>Stok</th><th style="width:110px">Jumlah</th></tr>
@foreach($menus as $m)<tr><td>{{ $m->name }}</td><td>Rp {{ number_format($m->price,0,',','.') }}</td><td>{{ $m->stok }}</td>
<td><input type="number" min="0" max="{{ $m->stok }}" name="qty[{{ $m->id }}]" value="{{ old('qty.'.$m->id,0) }}" data-price="{{ $m->price }}" class="form-control q" @disabled($m->stok<1)></td></tr>@endforeach</table></div>
<div class="card card-body"><div class="row g-3 align-items-end">
<div class="col-md-4"><div class="text-muted">Total</div><div class="h4" id="total">Rp 0</div></div>
<div class="col-md-4"><label class="form-label">Uang diterima (Rp)</label><input type="number" min="0" name="paid" id="paid" class="form-control" value="{{ old('paid') }}" required></div>
<div class="col-md-4"><div class="text-muted">Kembalian</div><div class="h4" id="chg">Rp 0</div></div></div>
<button class="btn btn-danger mt-3">Proses & Cetak Struk</button></div></form>
@push('js')<script>
const f=n=>'Rp '+n.toLocaleString('id-ID');
function hit(){let t=0;document.querySelectorAll('.q').forEach(i=>t+=(+i.value||0)*i.dataset.price);
const p=+document.getElementById('paid').value||0;document.getElementById('total').textContent=f(t);document.getElementById('chg').textContent=f(Math.max(0,p-t));}
document.querySelectorAll('.q,#paid').forEach(i=>i.addEventListener('input',hit));hit();</script>@endpush
@endsection
