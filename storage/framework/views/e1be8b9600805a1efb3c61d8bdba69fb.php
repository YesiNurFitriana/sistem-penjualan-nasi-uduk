<?php $__env->startSection('content'); ?>
<?php $s = fn($k,$d)=>old($k, \App\Models\Setting::val($k,$d)); ?>
<h1 class="h3">Pengaturan</h1>
<form method="post" action="/admin/pengaturan" class="card card-body mb-4 row g-2 flex-row"><?php echo csrf_field(); ?>
<?php $__currentLoopData = [['open_time','Jam buka','time','07:00'],['pickup_start','Pengambilan mulai','time','08:00'],['pickup_end','Pengambilan sampai (maks. 12:00)','time','12:00'],['prep_minutes','Waktu persiapan (menit)','number','60'],['default_quota','Kuota default (porsi/hari)','number','50']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$k,$l,$t,$d]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="col-md-4"><label class="form-label"><?php echo e($l); ?></label><input name="<?php echo e($k); ?>" type="<?php echo e($t); ?>" value="<?php echo e($s($k,$d)); ?>" class="form-control" required></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<div class="col-12"><button class="btn btn-danger">Simpan</button></div></form>
<h2 class="h5">Kuota per Tanggal</h2>
<form method="post" action="/admin/kuota" class="row g-2 mb-3"><?php echo csrf_field(); ?><div class="col-6 col-md-3"><input type="date" name="date" min="<?php echo e(today()->toDateString()); ?>" class="form-control" required></div>
<div class="col-6 col-md-3"><input type="number" name="quota" min="0" class="form-control" placeholder="Kuota" required></div><div class="col-auto"><button class="btn btn-outline-danger">Simpan</button></div></form>
<table class="table table-sm bg-white w-auto"><?php $__currentLoopData = $quotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e(\Carbon\Carbon::parse($q->date)->format('d/m/Y')); ?></td><td><?php echo e($q->quota); ?> porsi</td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\uduxMu\resources\views/admin/settings.blade.php ENDPATH**/ ?>