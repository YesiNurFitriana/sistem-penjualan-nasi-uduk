<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model {
  protected $guarded = []; protected $casts = ['pickup_date'=>'date','paid_at'=>'datetime'];
  const RESERVING = ['Dikonfirmasi','Sedang Disiapkan','Siap Diambil'];
  public function items(){ return $this->hasMany(OrderItem::class); }
  public function user(){ return $this->belongsTo(User::class); }
  public function customerCanCancel(): bool {
    if ($this->status === 'Menunggu Konfirmasi') return true;
    return $this->status === 'Dikonfirmasi' && $this->pickup_date->gte(today()->addDays(2)); // minimal H-2
  }
}
