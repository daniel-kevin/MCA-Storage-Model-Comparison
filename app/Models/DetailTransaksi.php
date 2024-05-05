<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 't_transaksi';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;

    public function barang(){
        return $this->belongsTo(Barang::class,'barang_id','id');
    }

    public function masterTransaksi(){
        return $this->belongsTo(MasterTransaksi::class,'transaksi_id','id');
    }
}
