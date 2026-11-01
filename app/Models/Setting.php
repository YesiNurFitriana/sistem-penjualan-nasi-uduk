<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Setting extends Model {
  public $incrementing = false; public $timestamps = false; protected $primaryKey = 'key'; protected $keyType = 'string'; protected $guarded = [];
  public static function val(string $k, $d = null) { return static::find($k)?->value ?? $d; }
  public static function put(string $k, $v) { static::updateOrCreate(['key'=>$k], ['value'=>(string)$v]); }
}
