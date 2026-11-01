<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Batch, Menu};
use App\Services\StockService;
use Illuminate\Http\Request;

class BatchController extends Controller {
  public function index() {
    $menus = Menu::orderBy('name')->get();
    $stok = $menus->mapWithKeys(fn($m) => [$m->id => ['layak' => StockService::batches($m->id, today())->sum('qty_remaining'), 'kasir' => StockService::kasirStock($m->id, today())]]);
    $leftovers = Batch::with('menu')->where('qty_remaining', '>', 0)->whereDate('produced_on', '<', today())
      ->whereDate('produced_on', '>=', today()->subDays(2))->whereHas('menu', fn($q) => $q->where('resellable', true))->get();
    $old = Batch::with('menu')->where('qty_remaining', '>', 0)->where(fn($q) => $q->whereDate('produced_on', '<', today()->subDays(2))
      ->orWhere(fn($w) => $w->whereDate('produced_on', '<', today())->whereHas('menu', fn($m) => $m->where('resellable', false))))->get();
    return view('admin.batch', ['menus' => $menus->where('is_active', true), 'stok' => $stok, 'menusAll' => $menus, 'leftovers' => $leftovers, 'old' => $old,
      'recent' => Batch::with('menu')->latest('id')->limit(15)->get()]);
  }
  public function store(Request $r) {
    $d = $r->validate(['menu_id' => 'required|exists:menus,id', 'produced_on' => 'required|date|before_or_equal:today', 'qty' => 'required|integer|min:1|max:5000'],
      ['required' => ':attribute wajib diisi.', 'min' => 'Jumlah minimal 1.', 'before_or_equal' => 'Tanggal produksi tidak boleh di masa depan.']);
    Batch::create($d + ['qty_remaining' => $d['qty']]);
    return back()->with('ok', 'Batch produksi dicatat.');
  }
  /** Keputusan manual admin: jual kembali (hanya menu resellable, maks. 2 hari) atau buang. */
  public function decide(Request $r, Batch $batch) {
    $r->validate(['aksi' => 'required|in:jual,tarik,buang']);
    abort_unless($batch->menu->resellable || $r->aksi === 'buang', 422, 'Menu ini tidak dapat dijual kembali (nasi sisa dibuang).');
    if ($r->aksi === 'buang') $batch->update(['discarded' => $batch->discarded + $batch->qty_remaining, 'qty_remaining' => 0, 'resale_approved' => false]);
    else {
      abort_if($batch->produced_on->lt(today()->subDays(2)), 422, 'Melewati batas 2 hari kalender.');
      $batch->update(['resale_approved' => $r->aksi === 'jual']);
    }
    return back()->with('ok', 'Keputusan sisa makanan disimpan.');
  }
}
