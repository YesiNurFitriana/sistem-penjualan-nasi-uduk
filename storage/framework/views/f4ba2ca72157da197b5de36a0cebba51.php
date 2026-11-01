<?php $__env->startSection('content'); ?>
<h1 class="h3">Pesanan Online</h1>
<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div class="card mb-3"><div class="card-body">
<div class="d-flex justify-content-between flex-wrap"><strong>#<?php echo e($o->id); ?> — <?php echo e($o->user->name); ?> (<?php echo e($o->user->phone); ?>)</strong><span class="badge bg-secondary"><?php echo e($o->status); ?></span></div>
<div>Ambil: <?php echo e($o->pickup_date->format('d/m/Y')); ?> <?php echo e(substr($o->pickup_time,0,5)); ?> · Total Rp <?php echo e(number_format($o->total,0,',','.')); ?></div>
<ul class="mb-2"><?php $__currentLoopData = $o->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($i->menu->name); ?> × <?php echo e($i->qty); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
<?php $next=['Menunggu Konfirmasi'=>['konfirmasi'=>'Konfirmasi'],'Dikonfirmasi'=>['siapkan'=>'Mulai Siapkan'],'Sedang Disiapkan'=>['siap'=>'Siap Diambil'],'Siap Diambil'=>[]][$o->status] ?? []; ?>
<div class="d-flex flex-wrap gap-2 align-items-center">
<?php $__currentLoopData = $next; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a=>$l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><form method="post" action="/admin/pesanan/<?php echo e($o->id); ?>/<?php echo e($a); ?>"><?php echo csrf_field(); ?><button class="btn btn-sm btn-success"><?php echo e($l); ?></button></form><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if($o->status==='Menunggu Konfirmasi'): ?><form method="post" action="/admin/pesanan/<?php echo e($o->id); ?>/tolak" class="d-flex gap-1"><?php echo csrf_field(); ?><input name="alasan" class="form-control form-control-sm" placeholder="Alasan tolak" required><button class="btn btn-sm btn-outline-danger">Tolak</button></form><?php endif; ?>
<?php if($o->status==='Siap Diambil'): ?><form method="post" action="/admin/pesanan/<?php echo e($o->id); ?>/selesai" class="d-flex gap-2 align-items-center"><?php echo csrf_field(); ?>
<label class="form-check-label"><input type="checkbox" name="uang_diterima" value="1" class="form-check-input"> Uang tunai diterima</label><button class="btn btn-sm btn-primary">Serahkan</button></form><?php endif; ?>
<?php if (! (in_array($o->status,['Selesai','Ditolak','Dibatalkan']))): ?><form method="post" action="/admin/pesanan/<?php echo e($o->id); ?>/batal" onsubmit="return confirm('Batalkan pesanan?')"><?php echo csrf_field(); ?><button class="btn btn-sm btn-outline-secondary">Batalkan</button></form><?php endif; ?>
</div></div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php echo e($orders->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\uduxMu\resources\views/admin/orders.blade.php ENDPATH**/ ?>