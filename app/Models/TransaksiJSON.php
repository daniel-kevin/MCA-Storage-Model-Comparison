<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiJSON extends Model
{
    use HasFactory;
    protected $table = 'm_transaksi_json';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}
