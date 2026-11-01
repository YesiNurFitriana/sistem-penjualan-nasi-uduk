@extends('layout')@section('content')
<h1 class="h3">Kelola Menu</h1>
<form method="post" enctype="multipart/form-data" action="{{ $edit ? '/admin/menu/'.$edit->id : '/admin/menu' }}" class="card card-body mb-4 row g-2 flex-row">@csrf @if($edit)@method('PUT')@endif
<div class="col-md-4"><label class="form-label">Nama</label><input name="name" class="form-control" value="{{ old('name',$edit->name??'') }}" required></div>
<div class="col-md-3"><label class="form-label">Harga (Rp)</label><input name="price" type="number" min="0" class="form-control" value="{{ old('price',$edit->price??'') }}" required></div>
<div class="col-md-5"><label class="form-label">Foto</label><input name="photo" type="file" accept="image/*" class="form-control"></div>
<div class="col-12"><label class="form-label">Catatan</label><input name="note" class="form-control" value="{{ old('note',$edit->note??'') }}"></div>
<div class="col-12 d-flex flex-wrap gap-3">
<div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active',$edit->is_active??true))><label class="form-check-label">Aktif</label></div>
<div class="form-check"><input type="checkbox" name="show_note" value="1" class="form-check-input" @checked(old('show_note',$edit->show_note??false))><label class="form-check-label">Tampilkan catatan</label></div>
<div class="form-check"><input type="checkbox" name="resellable" value="1" class="form-check-input" @checked(old('resellable',$edit->resellable??false))><label class="form-check-label">Boleh dijual kembali (ayam bacem/rica-rica/kuah kuning)</label></div></div>
<div class="col-12"><button class="btn btn-danger">{{ $edit ? 'Simpan' : 'Tambah' }}</button>@if($edit)<a href="/admin/menu" class="btn btn-link">Batal</a>@endif</div></form>
<div class="table-responsive"><table class="table table-sm bg-white"><tr><th>Nama</th><th>Harga</th><th>Status</th><th>Catatan</th><th></th></tr>
@foreach($menus as $m)<tr><td>{{ $m->name }}</td><td>Rp {{ number_format($m->price,0,',','.') }}</td><td>{{ $m->is_active?'Aktif':'Nonaktif' }}</td>
<td>{{ $m->note }} <em class="text-muted">{{ $m->show_note?'(tampil)':'(sembunyi)' }}</em></td>
<td class="text-nowrap"><a class="btn btn-sm btn-outline-secondary" href="/admin/menu/{{ $m->id }}/edit">Ubah</a>
<form method="post" action="/admin/menu/{{ $m->id }}" class="d-inline" onsubmit="return confirm('Hapus menu?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr>@endforeach</table></div>
@endsection
