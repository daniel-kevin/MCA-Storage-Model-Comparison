<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganIndex extends Model
{
    use HasFactory;
    protected $table = 'm_pelanggan_index';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function masterTransaksi(){
        return $this->hasMany(MasterTransaksiIndex::class,'pelanggan_id','id');
    }
}
