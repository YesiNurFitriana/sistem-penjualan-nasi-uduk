<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller {
  const FLOW = ['konfirmasi' => ['Menunggu Konfirmasi', 'Dikonfirmasi'], 'tolak' => ['Menunggu Konfirmasi', 'Ditolak'], 'siapkan' => ['Dikonfirmasi', 'Sedang Disiapkan'],
    'siap' => ['Sedang Disiapkan', 'Siap Diambil'], 'selesai' => ['Siap Diambil', 'Selesai'], 'batal' => [null, 'Dibatalkan']];
  public function index() { return view('admin.orders', ['orders' => Order::with('user', 'items.menu')->latest('pickup_date')->latest('id')->paginate(20)]); }
  public function act(Request $r, Order $order, string $aksi) {
    abort_unless(isset(self::FLOW[$aksi]), 404);
    try {
      DB::transaction(function () use ($r, $order, $aksi) {
        $o = Order::with('items.menu')->lockForUpdate()->findOrFail($order->id);
        [$from, $to] = self::FLOW[$aksi];
        if ($from && $o->status !== $from) throw new \RuntimeException("Status pesanan harus '$from'.");
        if ($aksi === 'batal' && in_array($o->status, ['Selesai', 'Ditolak', 'Dibatalkan'])) throw new \RuntimeException('Pesanan sudah final.');
        if ($aksi === 'konfirmasi' && $o->pickup_date->isToday()) {
          foreach ($o->items as $i) if ($i->qty > StockService::kasirStock($i->menu_id, today(), true))
            throw new \RuntimeException("Stok {$i->menu->name} tidak cukup untuk dikonfirmasi.");
        }
        if ($aksi === 'tolak') $o->reject_reason = $r->validate(['alasan' => 'required|max:200'], ['required' => 'Alasan penolakan wajib diisi.'])['alasan'];
        if ($aksi === 'selesai') { // penjualan terealisasi hanya setelah uang diterima
          if (!$r->boolean('uang_diterima')) throw new \RuntimeException('Centang konfirmasi uang tunai sudah diterima.');
          foreach ($o->items as $i) StockService::deduct($i->menu_id, $i->qty, $o->pickup_date);
          $o->paid_at = now();
        }
        $o->status = $to; $o->save();
      });
    } catch (\RuntimeException $e) { return back()->withErrors(['aksi' => $e->getMessage()]); }
    return back()->with('ok', 'Status pesanan diperbarui.');
  }
}
