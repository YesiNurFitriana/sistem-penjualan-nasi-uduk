@extends('layout')@section('title','Kasir')@section('content')
@php $emo=['🍗','🍛','🍚','🥘','🥤']; @endphp
<form method="post" action="/kasir" class="row g-3">@csrf
<div class="col-xl-8"><div class="row g-3">@foreach($menus as $m)<div class="col-6 col-md-4"><div class="card h-100 kc {{ $m->stok<1?'opacity-50':'' }}" data-id="{{ $m->id }}" data-p="{{ $m->price }}" data-s="{{ $m->stok }}" data-n="{{ $m->name }}">
@if($m->photo)<img src="{{ asset('storage/'.$m->photo) }}" class="card-img-top" style="height:110px;object-fit:cover" alt="{{ $m->name }}">@else<div class="d-flex align-items-center justify-content-center fs-1" style="height:110px;background:linear-gradient(135deg,#bbf7d0,#fef9c3)">{{ $emo[$loop->index%5] }}</div>@endif
<div class="card-body p-2"><div class="fw-semibold small">{{ $m->name }}</div><div class="text-danger fw-bold small">Rp {{ number_format($m->price,0,',','.') }}</div><div class="small text-muted">{{ $m->stok<1?'Habis':'Stok: '.$m->stok }}</div>
<div class="d-flex align-items-center justify-content-between mt-2"><button type="button" class="btn btn-sm btn-outline-secondary" data-d>−</button><b class="qn">0</b><button type="button" class="btn btn-sm btn-success" data-i @disabled($m->stok<1)>+</button></div></div></div></div>@endforeach</div></div>
<div class="col-xl-4"><div class="card position-sticky" style="top:76px"><div class="card-body"><h2 class="h6 fw-bold"><i class="bi bi-receipt"></i> Ringkasan Pesanan</h2>
<div id="sum" class="small mb-2"></div><div id="hid"></div><hr>
<div class="d-flex justify-content-between fs-5 fw-bold"><span>Total</span><span id="total">Rp 0</span></div>
<label class="form-label mt-2 mb-1">Uang diterima (Rp)</label><input type="number" min="0" name="paid" id="paid" class="form-control form-control-lg" value="{{ old('paid') }}" required>
<div class="d-flex flex-wrap gap-1 my-2"><button type="button" class="btn btn-sm btn-outline-success" id="pas">Uang pas</button>@foreach([20000,50000,100000] as $n)<button type="button" class="btn btn-sm btn-outline-success qp" data-v="{{ $n }}">{{ number_format($n,0,',','.') }}</button>@endforeach</div>
<div class="d-flex justify-content-between"><span>Kembalian</span><b id="chg">Rp 0</b></div>
<button class="btn btn-success w-100 mt-3 py-2" id="go" disabled><i class="bi bi-printer"></i> Proses & Cetak Struk</button></div></div></div></form>
@push('js')<script>
const f=n=>'Rp '+n.toLocaleString('id-ID'),C={},o=@json(old('qty',[]));for(const k in o)if(+o[k]>0)C[k]=+o[k];
const cards=[...document.querySelectorAll('.kc')];
function draw(){let t=0,s='',h='';cards.forEach(c=>{const id=c.dataset.id,q=C[id]||0;c.querySelector('.qn').textContent=q;
if(q){t+=q*c.dataset.p;s+=`<div class="d-flex justify-content-between"><span>${c.dataset.n} ×${q}</span><span>${f(q*c.dataset.p)}</span></div>`;h+=`<input type="hidden" name="qty[${id}]" value="${q}">`}});
sum.innerHTML=s||'<span class="text-muted">Pilih menu di sebelah kiri.</span>';hid.innerHTML=h;total.textContent=f(t);const p=+paid.value||0;chg.textContent=f(Math.max(0,p-t));go.disabled=!(t>0&&p>=t);window.T=t}
cards.forEach(c=>{c.querySelector('[data-i]').onclick=()=>{const id=c.dataset.id;C[id]=Math.min(+c.dataset.s,(C[id]||0)+1);draw()};
c.querySelector('[data-d]').onclick=()=>{const id=c.dataset.id;C[id]=(C[id]||0)-1;if(C[id]<1)delete C[id];draw()}});
paid.oninput=draw;pas.onclick=()=>{paid.value=window.T||0;draw()};document.querySelectorAll('.qp').forEach(b=>b.onclick=()=>{paid.value=b.dataset.v;draw()});draw();</script>@endpush
@endsection
