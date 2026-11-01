<?php
use App\Http\Controllers\{AuthController, KasirController, CustomerOrderController};
use App\Http\Controllers\Admin\{MenuController, BatchController, SettingController, OrderController};
use App\Http\Middleware\Role;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'catalog'])->name('home');
Route::middleware('guest')->group(function () {
  Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
  Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
  Route::get('/daftar', [AuthController::class, 'registerForm']);
  Route::post('/daftar', [AuthController::class, 'register']);
  Route::get('/admin/login', [AuthController::class, 'staffForm']);
  Route::post('/admin/login', [AuthController::class, 'staffLogin'])->middleware('throttle:10,1');
});
Route::get('/acara', [\App\Http\Controllers\SpecialOrderController::class, 'form']);
Route::post('/acara', [\App\Http\Controllers\SpecialOrderController::class, 'store'])->middleware('throttle:10,1');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth', Role::class . ':pelanggan'])->group(function () {
  Route::get('/pesanan', [CustomerOrderController::class, 'index']);
  Route::post('/pesanan', [CustomerOrderController::class, 'store']);
  Route::post('/pesanan/{order}/batal', [CustomerOrderController::class, 'cancel']);
});
Route::middleware(['auth', Role::class . ':kasir,admin'])->prefix('kasir')->group(function () {
  Route::get('/', [KasirController::class, 'index']);
  Route::post('/', [KasirController::class, 'store']);
  Route::get('/struk/{sale}', [KasirController::class, 'receipt']);
});
Route::middleware(['auth', Role::class . ':admin'])->prefix('admin')->group(function () {
  Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);
  Route::post('menu/{menu}/toggle', [MenuController::class, 'toggle']);
  Route::resource('menu', MenuController::class)->only(['index', 'edit', 'store', 'update', 'destroy']);
  Route::get('batch', [BatchController::class, 'index']);
  Route::post('batch', [BatchController::class, 'store']);
  Route::post('batch/{batch}/sisa', [BatchController::class, 'decide']);
  Route::get('pengaturan', [SettingController::class, 'index']);
  Route::post('pengaturan', [SettingController::class, 'save']);
  Route::post('kuota', [SettingController::class, 'quota']);
  Route::get('acara', [\App\Http\Controllers\SpecialOrderController::class, 'adminIndex']);
  Route::post('acara/{order}/{aksi}', [\App\Http\Controllers\SpecialOrderController::class, 'adminAct']);
  Route::get('pesanan', [OrderController::class, 'index']);
  Route::post('pesanan/{order}/{aksi}', [OrderController::class, 'act']);
});
