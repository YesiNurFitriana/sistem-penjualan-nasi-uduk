<?php $__env->startSection('content'); ?>
<h1 class="h3">Batch Produksi & Stok</h1>
<form method="post" action="/admin/batch" class="card card-body mb-4 row g-2 flex-row"><?php echo csrf_field(); ?>
<div class="col-md-4"><select name="menu_id" class="form-select" required><?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($m->id); ?>"><?php echo e($m->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
<div class="col-md-3"><input type="date" name="produced_on" max="<?php echo e(today()->toDateString()); ?>" value="<?php echo e(today()->toDateString()); ?>" class="form-control" required></div>
<div class="col-md-3"><input type="number" name="qty" min="1" placeholder="Jumlah porsi" class="form-control" required></div>
<div class="col-md-2"><button class="btn btn-danger w-100">Catat Batch</button></div></form>
<h2 class="h5">Stok Hari Ini</h2><div class="table-responsive"><table class="table table-sm bg-white"><tr><th>Menu</th><th>Layak jual</th><th>Stok kasir</th></tr>
<?php $__currentLoopData = $menusAll; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e($m->name); ?></td><td><?php echo e($stok[$m->id]['layak']); ?></td><td><?php echo e($stok[$m->id]['kasir']); ?></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></table></div>
<h2 class="h5">Sisa Makanan (keputusan manual)</h2><div class="table-responsive"><table class="table table-sm bg-white"><tr><th>Menu</th><th>Produksi</th><th>Sisa</th><th>Status</th><th></th></tr>
<?php $__empty_1 = true; $__currentLoopData = $leftovers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><?php echo e($b->menu->name); ?></td><td><?php echo e($b->produced_on->format('d/m/Y')); ?></td><td><?php echo e($b->qty_remaining); ?></td><td><?php echo e($b->resale_approved?'Dijual kembali':'Belum diputuskan'); ?></td>
<td><form method="post" action="/admin/batch/<?php echo e($b->id); ?>/sisa" class="d-flex gap-1"><?php echo csrf_field(); ?>
<button name="aksi" value="<?php echo e($b->resale_approved?'tarik':'jual'); ?>" class="btn btn-sm btn-outline-success"><?php echo e($b->resale_approved?'Tarik':'Jual kembali'); ?></button>
<button name="aksi" value="buang" class="btn btn-sm btn-outline-danger" onclick="return confirm('Buang sisa?')">Buang</button></form></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="5" class="text-muted">Tidak ada sisa yang dapat dijual kembali.</td></tr><?php endif; ?></table></div>
<?php if($old->count()): ?><h2 class="h5 text-danger">Perlu Dibuang (nasi sisa / lewat 2 hari)</h2><table class="table table-sm bg-white">
<?php $__currentLoopData = $old; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e($b->menu->name); ?></td><td><?php echo e($b->produced_on->format('d/m/Y')); ?></td><td><?php echo e($b->qty_remaining); ?></td>
<td><form method="post" action="/admin/batch/<?php echo e($b->id); ?>/sisa"><?php echo csrf_field(); ?><button name="aksi" value="buang" class="btn btn-sm btn-danger">Buang</button></form></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></table><?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\uduxMu\resources\views/admin/batch.blade.php ENDPATH**/ ?>