<?php
namespace App\Services;
use App\Models\{Batch, Order, OrderItem};
use Carbon\Carbon;
use RuntimeException;

class StockService {
  /** Batch layak jual hari $d, terlama dulu. Sisa lama hanya bila disetujui admin & maks. 2 hari kalender. */
  public static function batches(int $menuId, Carbon $d, bool $lock = false) {
    $q = Batch::where('menu_id', $menuId)->where('qty_remaining', '>', 0)
      ->whereDate('produced_on', '<=', $d)->whereDate('produced_on', '>=', $d->copy()->subDays(2))
      ->where(fn($w) => $w->whereDate('produced_on', $d)->orWhere('resale_approved', true))
      ->orderBy('produced_on')->orderBy('id');
    return ($lock ? $q->lockForUpdate() : $q)->get();
  }
  public static function reserved(int $menuId, Carbon $d, ?int $exceptOrder = null): int {
    return (int) OrderItem::where('menu_id', $menuId)
      ->whereHas('order', fn($o) => $o->whereDate('pickup_date', $d)->whereIn('status', Order::RESERVING)
        ->when($exceptOrder, fn($x) => $x->where('id', '!=', $exceptOrder)))->sum('qty');
  }
  /** Stok kasir = stok layak jual - pesanan online terkonfirmasi (belum diserahkan), minimal 0. */
  public static function kasirStock(int $menuId, Carbon $d, bool $lock = false, ?int $exceptOrder = null): int {
    return max(0, (int) self::batches($menuId, $d, $lock)->sum('qty_remaining') - self::reserved($menuId, $d, $exceptOrder));
  }
  /** Kurangi stok FIFO (jalankan dalam DB::transaction). Return alokasi [batch_id => qty]. */
  public static function deduct(int $menuId, int $qty, Carbon $d): array {
    $alloc = []; $need = $qty;
    foreach (self::batches($menuId, $d, true) as $b) {
      if ($need <= 0) break;
      $take = min($need, $b->qty_remaining);
      $b->decrement('qty_remaining', $take); $alloc[$b->id] = $take; $need -= $take;
    }
    if ($need > 0) throw new RuntimeException('Stok batch tidak mencukupi.');
    return $alloc;
  }
}
