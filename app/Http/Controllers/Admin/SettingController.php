<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller {
  public function index() { return view('admin.settings', ['quotas' => DB::table('daily_quotas')->whereDate('date', '>=', today())->orderBy('date')->get()]); }
  public function save(Request $r) {
    $d = $r->validate(['open_time' => 'required|date_format:H:i', 'pickup_start' => 'required|date_format:H:i', 'pickup_end' => 'required|date_format:H:i|after:pickup_start|before_or_equal:12:00',
      'prep_minutes' => 'required|integer|min:0|max:2880', 'default_quota' => 'required|integer|min:0|max:10000'],
      ['before_or_equal' => 'Jam pengambilan maksimal 12.00.', 'after' => 'Jam akhir harus setelah jam mulai.', 'required' => ':attribute wajib diisi.']);
    foreach ($d as $k => $v) Setting::put($k, $v);
    return back()->with('ok', 'Pengaturan disimpan.');
  }
  public function quota(Request $r) {
    $d = $r->validate(['date' => 'required|date|after_or_equal:today', 'quota' => 'required|integer|min:0|max:10000']);
    DB::table('daily_quotas')->updateOrInsert(['date' => $d['date']], ['quota' => $d['quota']]);
    return back()->with('ok', 'Kuota tanggal tersebut disimpan.');
  }
}
