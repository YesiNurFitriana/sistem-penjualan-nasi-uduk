<?php
namespace App\Http\Controllers;
use App\Models\{Menu, Setting, SpecialOrder};
use Illuminate\Http\Request;

class SpecialOrderController extends Controller {
  public function form(Request $r) {
    $mine = $r->user() ? SpecialOrder::where('user_id', $r->user()->id)->latest()->get() : collect();
    return view('customer.acara', ['menus' => Menu::where('is_active', true)->orderBy('name')->get(), 'mine' => $mine]);
  }
  public function store(Request $r) {
    $end = min(Setting::val('pickup_end', '12:00'), '12:00'); $start = Setting::val('pickup_start', '08:00');
    $d = $r->validate([
      'name' => 'required|max:100', 'whatsapp' => ['required', 'regex:/^(\+62|62|0)8[0-9]{7,12}$/'],
      'event_date' => 'required|date|after_or_equal:' . today()->addDays(2)->toDateString(), // H+2 ke atas; besok = pesanan reguler
      'pickup_time' => "required|date_format:H:i|after_or_equal:$start|before_or_equal:$end", 'event_type' => 'required|max:60',
      'items' => 'required|array|min:1', 'items.*.menu_id' => 'required|exists:menus,id', 'items.*.portions' => 'required|integer|min:1|max:1000', 'notes' => 'nullable|max:1000',
    ], ['whatsapp.regex' => 'Nomor WhatsApp tidak valid (contoh: 081234567890).', 'event_date.after_or_equal' => 'Tanggal acara minimal 2 hari dari sekarang. Untuk besok pagi gunakan Menu Besok Pagi.',
        'pickup_time.after_or_equal' => "Jam pengambilan mulai $start.", 'pickup_time.before_or_equal' => "Jam pengambilan maksimal $end.", 'required' => ':attribute wajib diisi.']);
    $items = collect($d['items'])->map(fn($i) => ['menu_id' => (int) $i['menu_id'], 'name' => Menu::find($i['menu_id'])->name, 'portions' => (int) $i['portions']])->all();
    SpecialOrder::create(['user_id' => $r->user()?->id, 'name' => $d['name'], 'whatsapp' => $d['whatsapp'], 'event_date' => $d['event_date'], 'pickup_time' => $d['pickup_time'],
      'event_type' => $d['event_type'], 'items' => $items, 'notes' => $d['notes'] ?? null]);
    return redirect('/acara')->with('ok', 'Pesanan acara terkirim. Admin akan memeriksa dan menghubungi Anda lewat WhatsApp.');
  }
  public function adminIndex() { return view('admin.acara', ['orders' => SpecialOrder::latest()->paginate(15)]); }
  public function adminAct(Request $r, SpecialOrder $order, string $aksi) {
    abort_unless(in_array($aksi, ['konfirmasi', 'tolak']), 404);
    if ($order->status !== 'Menunggu Konfirmasi') return back()->withErrors(['aksi' => 'Pesanan ini sudah diproses.']);
    $note = $r->validate(['admin_note' => ($aksi === 'tolak' ? 'required' : 'nullable') . '|max:200'], ['required' => 'Alasan penolakan wajib diisi.'])['admin_note'] ?? null;
    $order->update(['status' => $aksi === 'konfirmasi' ? 'Dikonfirmasi' : 'Ditolak', 'admin_note' => $note]);
    return back()->with('ok', 'Pesanan acara diperbarui.');
  }
}
