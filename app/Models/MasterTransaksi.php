<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTransaksi extends Model
{
    use HasFactory;
    protected $table = 'm_transaksi';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;

    public function detailTransaksi(){
        return $this->hasMany(DetailTransaksi::class,'transaksi_id','id');
    }

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class,'pelanggan_id','id');
    }
}
