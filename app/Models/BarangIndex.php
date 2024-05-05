<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangIndex extends Model
{
    use HasFactory;
    protected $table = 'm_barang_index';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function detailTransaksi(){
        return $this->hasMany(DetailTransaksiIndex::class,'barang_id','id');
    }
}
