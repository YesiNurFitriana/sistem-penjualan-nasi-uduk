<?php $__env->startSection('content'); ?>
<div class="card mx-auto" style="max-width:420px"><div class="card-body"><h1 class="h4"><?php echo e($staff ? 'Login Staf (Admin/Kasir)' : 'Masuk Pelanggan'); ?></h1>
<form method="post" action="<?php echo e($staff ? '/admin/login' : '/login'); ?>"><?php echo csrf_field(); ?>
<div class="mb-3"><label class="form-label">Email</label><input name="email" type="email" value="<?php echo e(old('email')); ?>" class="form-control" required></div>
<div class="mb-3"><label class="form-label">Kata sandi</label><input name="password" type="password" class="form-control" required></div>
<button class="btn btn-danger w-100">Masuk</button></form>
<?php if (! ($staff)): ?><p class="mt-3 mb-0">Belum punya akun? <a href="/daftar">Daftar</a></p><?php endif; ?></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\uduxMu\resources\views/auth/login.blade.php ENDPATH**/ ?>