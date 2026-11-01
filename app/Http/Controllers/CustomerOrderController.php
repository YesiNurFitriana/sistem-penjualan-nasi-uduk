<?php
namespace App\Http\Controllers;
use App\Models\{Menu, Order, OrderItem, Setting};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller {
  public function index(Request $r) {
    return view('customer.orders', ['orders' => Order::with('items.menu')->where('user_id', $r->user()->id)->latest()->get(),
      'menus' => Menu::where('is_active', true)->orderBy('name')->get()]);
  }
  public function store(Request $r) {
    $d = $r->validate(['pickup_date' => 'required|date|after_or_equal:today', 'pickup_time' => 'required|date_format:H:i', 'qty' => 'required|array', 'qty.*' => 'nullable|integer|min:0|max:100'],
      ['required' => ':attribute wajib diisi.', 'after_or_equal' => 'Tanggal pengambilan tidak boleh lewat.']);
    $items = array_filter($d['qty']);
    if (!$items) return back()->withErrors(['qty' => 'Pilih minimal satu menu.'])->withInput();
    $start = Setting::val('pickup_start', '08:00'); $end = Setting::val('pickup_end', '12:00'); $prep = (int) Setting::val('prep_minutes', 60);
    $pickup = Carbon::parse("{$d['pickup_date']} {$d['pickup_time']}");
    if ($d['pickup_time'] < $start || $d['pickup_time'] > min($end, '12:00')) return back()->withErrors(['pickup_time' => "Jam pengambilan harus antara $start dan " . min($end, '12:00') . '.'])->withInput();
    if ($pickup->lt(now()->addMinutes($prep))) return back()->withErrors(['pickup_time' => "Pesanan membutuhkan waktu persiapan minimal $prep menit."])->withInput();
    try {
      DB::transaction(function () use ($r, $d, $items) {
        DB::table('settings')->where('key', 'default_quota')->lockForUpdate()->first(); // serialisasi pengecekan kuota
        $quota = DB::table('daily_quotas')->where('date', $d['pickup_date'])->value('quota') ?? (int) Setting::val('default_quota', 0);
        $used = (int) OrderItem::whereHas('order', fn($o) => $o->whereDate('pickup_date', $d['pickup_date'])->whereNotIn('status', ['Ditolak', 'Dibatalkan']))->sum('qty');
        $want = array_sum($items);
        if ($used + $want > $quota) throw new \RuntimeException('Kuota pesanan tanggal tersebut tidak mencukupi (sisa ' . max(0, $quota - $used) . ' porsi).');
        $total = 0; $rows = [];
        foreach ($items as $id => $q) { $m = Menu::where('is_active', true)->findOrFail($id); $rows[] = ['menu_id' => $m->id, 'qty' => (int) $q, 'price' => $m->price]; $total += $m->price * $q; }
        $o = Order::create(['user_id' => $r->user()->id, 'pickup_date' => $d['pickup_date'], 'pickup_time' => $d['pickup_time'], 'total' => $total]);
        $o->items()->createMany($rows);
      });
    } catch (\RuntimeException $e) { return back()->withErrors(['qty' => $e->getMessage()])->withInput(); }
    return redirect('/pesanan')->with('ok', 'Pesanan dikirim. Menunggu konfirmasi admin. Pembayaran tunai saat pengambilan.');
  }
  public function cancel(Request $r, Order $order) {
    abort_unless($order->user_id === $r->user()->id, 403);
    return DB::transaction(function () use ($order) {
      $o = Order::lockForUpdate()->find($order->id);
      if (!$o->customerCanCancel()) return back()->withErrors(['aksi' => 'Pesanan ini tidak dapat dibatalkan sendiri. Silakan hubungi admin.']);
      $o->update(['status' => 'Dibatalkan']);
      return back()->with('ok', 'Pesanan dibatalkan.');
    });
  }
}
