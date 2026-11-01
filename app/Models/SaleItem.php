<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SaleItem extends Model { public $timestamps = false; protected $guarded = []; protected $casts = ['allocations'=>'array'];
  public function menu(){ return $this->belongsTo(Menu::class); }
  public function sale(){ return $this->belongsTo(Sale::class); } }
