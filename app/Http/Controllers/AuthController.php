<?php
namespace App\Http\Controllers;
use App\Models\{User, Menu};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};

class AuthController extends Controller {
  public function catalog() { return view('catalog', ['menus' => Menu::where('is_active', true)->orderBy('name')->get()]); }
  public function loginForm() { return view('auth.login', ['staff' => false]); }
  public function staffForm() { return view('auth.login', ['staff' => true]); }
  public function login(Request $r) { return $this->attempt($r, false); }
  public function staffLogin(Request $r) { return $this->attempt($r, true); }
  private function attempt(Request $r, bool $staff) {
    $c = $r->validate(['email' => 'required|email', 'password' => 'required'], ['required' => ':attribute wajib diisi.', 'email' => 'Format email tidak valid.']);
    $fail = back()->withErrors(['email' => 'Email atau kata sandi salah.'])->onlyInput('email');
    if (!Auth::attempt($c)) return $fail;
    $isStaff = in_array(Auth::user()->role, ['admin', 'kasir']);
    if ($isStaff !== $staff) { Auth::logout(); return $fail; } // login terisolasi
    $r->session()->regenerate();
    return redirect(match (Auth::user()->role) { 'admin' => '/admin/menu', 'kasir' => '/kasir', default => '/pesanan' });
  }
  public function registerForm() { return view('auth.register'); }
  public function register(Request $r) {
    $d = $r->validate([
      'name' => 'required|string|max:100', 'email' => 'required|email|max:150|unique:users', 'phone' => 'required|string|max:20',
      'password' => 'required|min:8|confirmed',
    ], ['unique' => 'Email sudah terdaftar.', 'min' => 'Kata sandi minimal 8 karakter.', 'confirmed' => 'Konfirmasi kata sandi tidak cocok.', 'required' => ':attribute wajib diisi.']);
    $u = User::create(['name' => $d['name'], 'email' => $d['email'], 'phone' => $d['phone'], 'password' => Hash::make($d['password']), 'role' => 'pelanggan']); // role dipaksa pelanggan
    Auth::login($u); $r->session()->regenerate();
    return redirect('/pesanan');
  }
  public function logout(Request $r) { Auth::logout(); $r->session()->invalidate(); $r->session()->regenerateToken(); return redirect('/'); }
}
