<?php
namespace Database\Seeders;
use App\Models\{User, Menu, Setting};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder {
  public function run(): void {
    foreach ([['Admin UduxMu','admin@uduxmu.test','admin'],['Kasir UduxMu','kasir@uduxmu.test','kasir']] as [$n,$e,$r])
      User::updateOrCreate(['email'=>$e], ['name'=>$n,'role'=>$r,'password'=>Hash::make('password')]);
    foreach ([['Nasi Putih',4000,0],['Ayam Bacem',15000,1],['Ayam Rica-Rica',16000,1],['Ayam Kuah Kuning',16000,1],['Es Teh',3000,0]] as [$n,$p,$rs])
      Menu::firstOrCreate(['name'=>$n], ['price'=>$p,'resellable'=>$rs]);
    foreach (['open_time'=>'07:00','pickup_start'=>'08:00','pickup_end'=>'12:00','prep_minutes'=>'60','default_quota'=>'50'] as $k=>$v) Setting::put($k,$v);
  }
}
