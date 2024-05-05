<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'm_barang';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function detailTransaksi(){
        return $this->hasMany(DetailTransaksi::class,'barang_id','id');
    }
}
