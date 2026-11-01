<?php
namespace App\Console\Commands;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
class MakeStaff extends Command {
  protected $signature = 'uduxmu:staff {email} {name} {role=admin}';
  protected $description = 'Buat atau ubah akun admin/kasir (untuk deploy, tanpa seeder)';
  public function handle() {
    $role = $this->argument('role');
    if (!in_array($role, ['admin', 'kasir'])) { $this->error('Role harus admin atau kasir.'); return self::FAILURE; }
    $pw = $this->secret('Kata sandi (min. 8 karakter)');
    if (strlen((string) $pw) < 8) { $this->error('Kata sandi terlalu pendek.'); return self::FAILURE; }
    User::updateOrCreate(['email' => $this->argument('email')], ['name' => $this->argument('name'), 'role' => $role, 'password' => Hash::make($pw)]);
    $this->info("Akun $role siap. Login di /admin/login"); return self::SUCCESS;
  }
}
