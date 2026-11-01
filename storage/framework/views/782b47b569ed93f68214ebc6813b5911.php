<?php $__env->startSection('title','Dashboard'); ?><?php $__env->startSection('content'); ?>
<div class="row g-3 mb-3">
<?php $__currentLoopData = [['Penjualan hari ini','Rp '.number_format($omzet,0,',','.'),'bi-cash-stack','success'],['Pesanan online menunggu',$pending,'bi-bag-check','warning'],['Pesanan acara menunggu',$pendingAcara,'bi-calendar-event','info'],['Menu stok menipis (≤5)',$menipis,'bi-exclamation-triangle','danger']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$l,$v,$ic,$c]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="col-6 col-xl-3"><div class="card h-100"><div class="card-body d-flex align-items-center gap-3"><div class="rounded-3 bg-<?php echo e($c); ?>-subtle text-<?php echo e($c); ?> p-3 fs-4"><i class="bi <?php echo e($ic); ?>"></i></div><div><div class="text-muted small"><?php echo e($l); ?></div><div class="h5 fw-bold mb-0"><?php echo e($v); ?></div></div></div></div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
<div class="row g-3"><div class="col-lg-8"><div class="card"><div class="card-body"><h2 class="h6 fw-bold">Penjualan 7 Hari Terakhir (Rp)</h2><canvas id="c1" height="120"></canvas></div></div></div>
<div class="col-lg-4"><div class="card"><div class="card-body"><h2 class="h6 fw-bold">Porsi Terjual per Menu (7 hari)</h2><canvas id="c2"></canvas></div></div></div>
<div class="col-12"><div class="card"><div class="card-body"><h2 class="h6 fw-bold">Stok Kasir Hari Ini (porsi)</h2><canvas id="c3" height="70"></canvas></div></div></div></div>
<?php $__env->startPush('js'); ?><script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script><script>
const G=['#14532d','#16a34a','#4ade80','#86efac','#facc15','#a3a3a3'],L=<?php echo json_encode($labels, 15, 512) ?>;
new Chart(c1,{type:'bar',data:{labels:L,datasets:[{label:'Kasir',data:<?php echo json_encode($kasir, 15, 512) ?>,backgroundColor:'#16a34a'},{label:'Online',data:<?php echo json_encode($online, 15, 512) ?>,backgroundColor:'#86efac'}]},options:{scales:{x:{stacked:true},y:{stacked:true,beginAtZero:true}}}});
new Chart(c2,{type:'doughnut',data:{labels:<?php echo json_encode($names, 15, 512) ?>,datasets:[{data:<?php echo json_encode($terjual, 15, 512) ?>,backgroundColor:G}]},options:{plugins:{legend:{position:'bottom'}}}});
new Chart(c3,{type:'bar',data:{labels:<?php echo json_encode($names, 15, 512) ?>,datasets:[{label:'Stok kasir',data:<?php echo json_encode($stok, 15, 512) ?>,backgroundColor:'#16a34a'}]},options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}});
</script><?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\uduxMu\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>