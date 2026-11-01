<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Batch extends Model { protected $guarded = []; protected $casts = ['produced_on'=>'date','resale_approved'=>'bool'];
  public function menu(){ return $this->belongsTo(Menu::class); } }
