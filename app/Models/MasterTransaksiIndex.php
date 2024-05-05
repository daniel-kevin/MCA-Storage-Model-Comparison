<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTransaksiIndex extends Model
{
    use HasFactory;
    protected $table = 'm_transaksi_index';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;

    public function detailTransaksi(){
        return $this->hasMany(DetailTransaksiIndex::class,'transaksi_id','id');
    }

    public function pelanggan(){
        return $this->belongsTo(PelangganIndex::class,'pelanggan_id','id');
    }
}
