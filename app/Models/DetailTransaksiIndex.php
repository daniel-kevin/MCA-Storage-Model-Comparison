<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiIndex extends Model
{
    use HasFactory;
    protected $table = 't_transaksi_index';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;

    public function barang(){
        return $this->belongsTo(BarangIndex::class,'barang_id','id');
    }

    public function masterTransaksi(){
        return $this->belongsTo(MasterTransaksiIndex::class,'transaksi_id','id');
    }
}
