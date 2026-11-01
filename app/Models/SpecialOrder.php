<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SpecialOrder extends Model { protected $guarded = []; protected $casts = ['items'=>'array','event_date'=>'date']; }
