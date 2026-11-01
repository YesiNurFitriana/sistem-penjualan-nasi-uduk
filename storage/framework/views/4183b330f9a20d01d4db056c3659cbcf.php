<?php $__env->startSection('content'); ?>
<h1 class="h3 mb-3">Menu Hari Ini</h1>
<div class="row g-3"><?php $__empty_1 = true; $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="col-6 col-md-4 col-lg-3"><div class="card h-100">
<?php if($m->photo): ?><img src="<?php echo e(asset('storage/'.$m->photo)); ?>" class="card-img-top" style="height:160px;object-fit:cover" alt="<?php echo e($m->name); ?>"><?php endif; ?>
<div class="card-body"><h2 class="h6"><?php echo e($m->name); ?></h2><div class="fw-bold text-danger">Rp <?php echo e(number_format($m->price,0,',','.')); ?></div>
<?php if($m->show_note && $m->note): ?><small class="text-muted"><?php echo e($m->note); ?></small><?php endif; ?></div></div></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="text-muted">Belum ada menu aktif.</p><?php endif; ?></div>
<a href="/pesanan" class="btn btn-danger mt-4">Pesan Online</a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\uduxMu\resources\views/catalog.blade.php ENDPATH**/ ?>