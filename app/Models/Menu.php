<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Menu extends Model { protected $guarded = []; protected $casts = ['is_active'=>'bool','resellable'=>'bool','show_note'=>'bool']; }
