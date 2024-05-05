<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    protected $table = 'm_pelanggan';
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function masterTransaksi(){
        return $this->hasMany(MasterTransaksi::class,'pelanggan_id','id');
    }
}
