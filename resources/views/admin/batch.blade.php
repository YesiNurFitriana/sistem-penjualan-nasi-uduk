@extends('layout')@section('content')
<h1 class="h3">Batch Produksi & Stok</h1>
<form method="post" action="/admin/batch" class="card card-body mb-4 row g-2 flex-row">@csrf
<div class="col-md-4"><select name="menu_id" class="form-select" required>@foreach($menus as $m)<option value="{{ $m->id }}">{{ $m->name }}</option>@endforeach</select></div>
<div class="col-md-3"><input type="date" name="produced_on" max="{{ today()->toDateString() }}" value="{{ today()->toDateString() }}" class="form-control" required></div>
<div class="col-md-3"><input type="number" name="qty" min="1" placeholder="Jumlah porsi" class="form-control" required></div>
<div class="col-md-2"><button class="btn btn-danger w-100">Catat Batch</button></div></form>
<h2 class="h5">Stok Hari Ini</h2><div class="table-responsive"><table class="table table-sm bg-white"><tr><th>Menu</th><th>Layak jual</th><th>Stok kasir</th></tr>
@foreach($menusAll as $m)<tr><td>{{ $m->name }}</td><td>{{ $stok[$m->id]['layak'] }}</td><td>{{ $stok[$m->id]['kasir'] }}</td></tr>@endforeach</table></div>
<h2 class="h5">Sisa Makanan (keputusan manual)</h2><div class="table-responsive"><table class="table table-sm bg-white"><tr><th>Menu</th><th>Produksi</th><th>Sisa</th><th>Status</th><th></th></tr>
@forelse($leftovers as $b)<tr><td>{{ $b->menu->name }}</td><td>{{ $b->produced_on->format('d/m/Y') }}</td><td>{{ $b->qty_remaining }}</td><td>{{ $b->resale_approved?'Dijual kembali':'Belum diputuskan' }}</td>
<td><form method="post" action="/admin/batch/{{ $b->id }}/sisa" class="d-flex gap-1">@csrf
<button name="aksi" value="{{ $b->resale_approved?'tarik':'jual' }}" class="btn btn-sm btn-outline-success">{{ $b->resale_approved?'Tarik':'Jual kembali' }}</button>
<button name="aksi" value="buang" class="btn btn-sm btn-outline-danger" onclick="return confirm('Buang sisa?')">Buang</button></form></td></tr>
@empty<tr><td colspan="5" class="text-muted">Tidak ada sisa yang dapat dijual kembali.</td></tr>@endforelse</table></div>
@if($old->count())<h2 class="h5 text-danger">Perlu Dibuang (nasi sisa / lewat 2 hari)</h2><table class="table table-sm bg-white">
@foreach($old as $b)<tr><td>{{ $b->menu->name }}</td><td>{{ $b->produced_on->format('d/m/Y') }}</td><td>{{ $b->qty_remaining }}</td>
<td><form method="post" action="/admin/batch/{{ $b->id }}/sisa">@csrf<button name="aksi" value="buang" class="btn btn-sm btn-danger">Buang</button></form></td></tr>@endforeach</table>@endif
@endsection
