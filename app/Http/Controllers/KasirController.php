<?php
namespace App\Http\Controllers;
use App\Models\{Menu, Sale, SaleItem};
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller {
  public function index() {
    $menus = Menu::where('is_active', true)->orderBy('name')->get()->each(fn($m) => $m->stok = StockService::kasirStock($m->id, today()));
    return view('kasir.index', compact('menus'));
  }
  public function store(Request $r) {
    $d = $r->validate(['qty' => 'required|array', 'qty.*' => 'nullable|integer|min:0|max:500', 'paid' => 'required|integer|min:0'],
      ['paid.required' => 'Jumlah uang diterima wajib diisi.', 'integer' => 'Harus berupa angka bulat.']);
    $items = array_filter($d['qty']); // harga TIDAK diambil dari browser
    if (!$items) return back()->withErrors(['qty' => 'Pilih minimal satu menu.'])->withInput();
    try {
      $sale = DB::transaction(function () use ($items, $d, $r) {
        $total = 0; $lines = [];
        foreach ($items as $id => $q) {
          $m = Menu::where('is_active', true)->findOrFail($id);
          $avail = StockService::kasirStock($m->id, today(), true); // row-lock batch
          if ($q > $avail) throw new \RuntimeException("Stok {$m->name} tidak cukup (tersisa $avail).");
          $lines[] = [$m, (int) $q]; $total += $m->price * $q;
        }
        if ($d['paid'] < $total) throw new \RuntimeException('Uang diterima kurang dari total (Rp ' . number_format($total, 0, ',', '.') . ').');
        $sale = Sale::create(['user_id' => $r->user()->id, 'total' => $total, 'paid' => $d['paid'], 'change' => $d['paid'] - $total]);
        foreach ($lines as [$m, $q])
          SaleItem::create(['sale_id' => $sale->id, 'menu_id' => $m->id, 'qty' => $q, 'price' => $m->price, 'allocations' => StockService::deduct($m->id, $q, today())]);
        return $sale;
      });
    } catch (\RuntimeException $e) { return back()->withErrors(['qty' => $e->getMessage()])->withInput(); }
    return redirect("/kasir/struk/{$sale->id}");
  }
  public function receipt(Sale $sale) { return view('kasir.struk', ['sale' => $sale->load('items.menu')]); }
}
