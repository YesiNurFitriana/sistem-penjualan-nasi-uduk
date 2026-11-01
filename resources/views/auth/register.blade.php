@extends('layout')@section('content')
<div class="card mx-auto" style="max-width:460px"><div class="card-body"><h1 class="h4">Daftar Pelanggan</h1>
<form method="post" action="/daftar">@csrf
@foreach(['name'=>['Nama','text'],'email'=>['Email','email'],'phone'=>['No. HP','tel'],'password'=>['Kata sandi (min. 8)','password'],'password_confirmation'=>['Ulangi kata sandi','password']] as $n=>[$l,$t])
<div class="mb-3"><label class="form-label">{{ $l }}</label><input name="{{ $n }}" type="{{ $t }}" value="{{ $t=='password'?'':old($n) }}" class="form-control" required></div>@endforeach
<button class="btn btn-danger w-100">Daftar</button></form></div></div>
@endsection
