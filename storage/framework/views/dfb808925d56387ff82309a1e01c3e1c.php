<?php $__env->startSection('content'); ?>
<h1 class="h3">Buat Pesanan</h1>
<form method="post" action="/pesanan" class="card card-body mb-4"><?php echo csrf_field(); ?>
<div class="row g-2 mb-2"><div class="col-md-4"><label class="form-label">Tanggal ambil</label><input type="date" name="pickup_date" min="<?php echo e(today()->toDateString()); ?>" value="<?php echo e(old('pickup_date')); ?>" class="form-control" required></div>
<div class="col-md-4"><label class="form-label">Jam ambil (maks. 12:00)</label><input type="time" name="pickup_time" max="12:00" value="<?php echo e(old('pickup_time')); ?>" class="form-control" required></div></div>
<div class="row g-2"><?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div class="col-6 col-md-3"><label class="form-label"><?php echo e($m->name); ?><br><small>Rp <?php echo e(number_format($m->price,0,',','.')); ?></small></label><input type="number" min="0" name="qty[<?php echo e($m->id); ?>]" value="<?php echo e(old('qty.'.$m->id,0)); ?>" class="form-control"></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<small class="text-muted mt-2">Pembayaran tunai saat pengambilan. Total dihitung server.</small>
<button class="btn btn-danger mt-3 align-self-start">Kirim Pesanan</button></form>
<h2 class="h5">Riwayat Pesanan</h2>
<?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="card mb-2"><div class="card-body"><div class="d-flex justify-content-between"><strong>#<?php echo e($o->id); ?> · <?php echo e($o->pickup_date->format('d/m/Y')); ?> <?php echo e(substr($o->pickup_time,0,5)); ?></strong><span class="badge bg-secondary"><?php echo e($o->status); ?></span></div>
<div><?php $__currentLoopData = $o->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($i->menu->name); ?> ×<?php echo e($i->qty); ?><?php if(!$loop->last): ?>, <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> — Rp <?php echo e(number_format($o->total,0,',','.')); ?></div>
<?php if($o->reject_reason): ?><div class="text-danger">Alasan ditolak: <?php echo e($o->reject_reason); ?></div><?php endif; ?>
<?php if($o->customerCanCancel()): ?><form method="post" action="/pesanan/<?php echo e($o->id); ?>/batal" class="mt-2" onsubmit="return confirm('Batalkan pesanan?')"><?php echo csrf_field(); ?><button class="btn btn-sm btn-outline-danger">Batalkan</button></form>
<?php elseif(!in_array($o->status,['Selesai','Ditolak','Dibatalkan'])): ?><small class="text-muted">Tidak dapat dibatalkan sendiri; hubungi admin.</small><?php endif; ?></div></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="text-muted">Belum ada pesanan.</p><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\uduxMu\resources\views/customer/orders.blade.php ENDPATH**/ ?>