<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class InventoryInvoice extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function productOut() {
        return $this->hasMany(InventoryProductOut::class, 'invoice_id', 'id');
    }

    public function shop() {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function statusTransaksi() {
      return $this->belongsTo(StatusTransaksi::class, 'status_transaksi', 'id');
    }

    public function getWaktuPengirimanAttribute() {
      return Carbon::parse($this->attributes['waktu_pengiriman'])->translatedFormat('l, d F Y - H:i');
    }

    public function getTanggalTempoAttribute() {
      return Carbon::parse($this->attributes['tanggal_tempo'])->translatedFormat('l, d F Y');
    }

    public function getCreatedAtAttribute() {
      return Carbon::parse($this->attributes['created_at'])->translatedFormat('d-m-Y');
    }
}
