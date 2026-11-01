<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller {
  public function index() { return view('admin.menu', ['menus' => Menu::orderBy('name')->get(), 'edit' => null]); }
  public function edit(Menu $menu) { return view('admin.menu', ['menus' => Menu::orderBy('name')->get(), 'edit' => $menu]); }
  private function data(Request $r): array {
    $d = $r->validate(['name' => 'required|max:100', 'price' => 'required|integer|min:0|max:10000000', 'note' => 'nullable|max:500', 'photo' => 'nullable|image|max:2048'],
      ['required' => ':attribute wajib diisi.', 'integer' => 'Harga harus berupa angka bulat.', 'image' => 'File harus berupa gambar.', 'max' => 'Isian terlalu besar.']);
    $d['is_active'] = $r->boolean('is_active'); $d['resellable'] = $r->boolean('resellable'); $d['show_note'] = $r->boolean('show_note');
    if ($r->hasFile('photo')) $d['photo'] = $r->file('photo')->store('menu', 'public'); else unset($d['photo']);
    return $d;
  }
  public function store(Request $r) { Menu::create($this->data($r)); return redirect('/admin/menu')->with('ok', 'Menu ditambahkan.'); }
  public function update(Request $r, Menu $menu) { $menu->update($this->data($r)); return redirect('/admin/menu')->with('ok', 'Menu diperbarui.'); }
  public function destroy(Menu $menu) {
    try { $menu->delete(); } catch (\Throwable) { $menu->update(['is_active' => false]); return back()->with('ok', 'Menu memiliki riwayat, hanya dinonaktifkan.'); }
    return back()->with('ok', 'Menu dihapus.');
  }
}
