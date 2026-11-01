<?php $__env->startSection('content'); ?>
<h1 class="h3">Kelola Menu</h1>
<form method="post" enctype="multipart/form-data" action="<?php echo e($edit ? '/admin/menu/'.$edit->id : '/admin/menu'); ?>" class="card card-body mb-4 row g-2 flex-row"><?php echo csrf_field(); ?> <?php if($edit): ?><?php echo method_field('PUT'); ?><?php endif; ?>
<div class="col-md-4"><label class="form-label">Nama</label><input name="name" class="form-control" value="<?php echo e(old('name',$edit->name??'')); ?>" required></div>
<div class="col-md-3"><label class="form-label">Harga (Rp)</label><input name="price" type="number" min="0" class="form-control" value="<?php echo e(old('price',$edit->price??'')); ?>" required></div>
<div class="col-md-5"><label class="form-label">Foto</label><input name="photo" type="file" accept="image/*" class="form-control"></div>
<div class="col-12"><label class="form-label">Catatan</label><input name="note" class="form-control" value="<?php echo e(old('note',$edit->note??'')); ?>"></div>
<div class="col-12 d-flex flex-wrap gap-3">
<div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" <?php if(old('is_active',$edit->is_active??true)): echo 'checked'; endif; ?>><label class="form-check-label">Aktif</label></div>
<div class="form-check"><input type="checkbox" name="show_note" value="1" class="form-check-input" <?php if(old('show_note',$edit->show_note??false)): echo 'checked'; endif; ?>><label class="form-check-label">Tampilkan catatan</label></div>
<div class="form-check"><input type="checkbox" name="resellable" value="1" class="form-check-input" <?php if(old('resellable',$edit->resellable??false)): echo 'checked'; endif; ?>><label class="form-check-label">Boleh dijual kembali (ayam bacem/rica-rica/kuah kuning)</label></div></div>
<div class="col-12"><button class="btn btn-danger"><?php echo e($edit ? 'Simpan' : 'Tambah'); ?></button><?php if($edit): ?><a href="/admin/menu" class="btn btn-link">Batal</a><?php endif; ?></div></form>
<div class="table-responsive"><table class="table table-sm bg-white"><tr><th>Nama</th><th>Harga</th><th>Status</th><th>Catatan</th><th></th></tr>
<?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><tr><td><?php echo e($m->name); ?></td><td>Rp <?php echo e(number_format($m->price,0,',','.')); ?></td><td><?php echo e($m->is_active?'Aktif':'Nonaktif'); ?></td>
<td><?php echo e($m->note); ?> <em class="text-muted"><?php echo e($m->show_note?'(tampil)':'(sembunyi)'); ?></em></td>
<td class="text-nowrap"><a class="btn btn-sm btn-outline-secondary" href="/admin/menu/<?php echo e($m->id); ?>/edit">Ubah</a>
<form method="post" action="/admin/menu/<?php echo e($m->id); ?>" class="d-inline" onsubmit="return confirm('Hapus menu?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></table></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\uduxMu\resources\views/admin/menu.blade.php ENDPATH**/ ?>