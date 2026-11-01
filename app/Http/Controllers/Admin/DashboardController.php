<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Menu, Order, OrderItem, Sale, SaleItem, SpecialOrder};
use App\Services\StockService;

class DashboardController extends Controller {
  public function index() {
    $days = collect(range(6, 0))->map(fn($i) => today()->subDays($i));
    $kasir = $days->map(fn($d) => (int) Sale::whereDate('created_at', $d)->sum('total'));
    $online = $days->map(fn($d) => (int) Order::where('status', 'Selesai')->whereDate('paid_at', $d)->sum('total'));
    $from = today()->subDays(6);
    $a = SaleItem::selectRaw('menu_id, sum(qty) q')->whereHas('sale', fn($s) => $s->whereDate('created_at', '>=', $from))->groupBy('menu_id')->pluck('q', 'menu_id');
    $b = OrderItem::selectRaw('menu_id, sum(qty) q')->whereHas('order', fn($o) => $o->where('status', 'Selesai')->whereDate('paid_at', '>=', $from))->groupBy('menu_id')->pluck('q', 'menu_id');
    $menus = Menu::orderBy('name')->get();
    $stok = $menus->map(fn($m) => StockService::kasirStock($m->id, today()));
    return view('admin.dashboard', [
      'labels' => $days->map(fn($d) => $d->translatedFormat('d M')), 'kasir' => $kasir, 'online' => $online,
      'names' => $menus->pluck('name'), 'terjual' => $menus->map(fn($m) => (int) ($a[$m->id] ?? 0) + (int) ($b[$m->id] ?? 0)), 'stok' => $stok,
      'omzet' => $kasir->last() + $online->last(),
      'pending' => Order::where('status', 'Menunggu Konfirmasi')->count(), 'pendingAcara' => SpecialOrder::where('status', 'Menunggu Konfirmasi')->count(),
      'menipis' => $menus->filter(fn($m, $i) => $m->is_active && $stok[$i] <= 5)->count(),
    ]);
  }
}
