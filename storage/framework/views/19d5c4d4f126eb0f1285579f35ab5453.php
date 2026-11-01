<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?php echo $__env->yieldContent('title','UduxMu'); ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>@media print{.no-print{display:none!important}}</style></head><body class="bg-light">
<nav class="navbar navbar-expand-md navbar-dark bg-danger no-print mb-4"><div class="container">
<a class="navbar-brand fw-bold" href="/">UduxMu</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nv"><span class="navbar-toggler-icon"></span></button>
<div id="nv" class="collapse navbar-collapse"><ul class="navbar-nav me-auto">
<li class="nav-item"><a class="nav-link" href="/">Menu</a></li>
<?php if(auth()->guard()->check()): ?> <?php $role = auth()->user()->role; ?>
<?php if($role==='pelanggan'): ?><li class="nav-item"><a class="nav-link" href="/pesanan">Pesanan Saya</a></li><?php endif; ?>
<?php if(in_array($role,['admin','kasir'])): ?><li class="nav-item"><a class="nav-link" href="/kasir">Kasir</a></li><?php endif; ?>
<?php if($role==='admin'): ?><?php $__currentLoopData = ['menu'=>'Kelola Menu','batch'=>'Batch & Stok','pesanan'=>'Pesanan Online','pengaturan'=>'Pengaturan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<li class="nav-item"><a class="nav-link" href="/admin/<?php echo e($u); ?>"><?php echo e($l); ?></a></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php endif; ?>
<?php endif; ?></ul>
<div class="d-flex gap-2"><?php if(auth()->guard()->check()): ?><span class="navbar-text text-white"><?php echo e(auth()->user()->name); ?></span>
<form method="post" action="/logout"><?php echo csrf_field(); ?><button class="btn btn-light btn-sm">Keluar</button></form>
<?php else: ?><a class="btn btn-light btn-sm" href="/login">Masuk</a><a class="btn btn-outline-light btn-sm" href="/daftar">Daftar</a><?php endif; ?></div></div></div></nav>
<main class="container pb-5">
<?php if(session('ok')): ?><div class="alert alert-success"><?php echo e(session('ok')); ?></div><?php endif; ?>
<?php if($errors->any()): ?><div class="alert alert-danger"><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div><?php endif; ?>
<?php echo $__env->yieldContent('content'); ?></main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script><?php echo $__env->yieldPushContent('js'); ?></body></html>
<?php /**PATH C:\laragon\www\uduxMu\resources\views/layout.blade.php ENDPATH**/ ?>