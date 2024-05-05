<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MasterController extends Controller
{
    public function getTableSize(Request $request){

        $tableName = 't_transaksi';
        $tableSize = DB::select("SELECT SUM(data_length + index_length) AS 'size' FROM information_schema.TABLES WHERE table_schema = ? AND table_name = ?", [config('database.connections.mysql.database'), $tableName])[0]->size;
        $data['normal'] = $tableSize;

        $tableName = 't_transaksi_index';
        $tableSize = DB::select("SELECT SUM(data_length + index_length) AS 'size' FROM information_schema.TABLES WHERE table_schema = ? AND table_name = ?", [config('database.connections.mysql.database'), $tableName])[0]->size;
        $data['index'] = $tableSize;

        $tableName = 'm_transaksi_json';
        $tableSize = DB::select("SELECT SUM(data_length + index_length) AS 'size' FROM information_schema.TABLES WHERE table_schema = ? AND table_name = ?", [config('database.connections.mysql.database'), $tableName])[0]->size;
        $data['json'] = $tableSize;

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil data',
            'data' => $data
        ]);
    }
}
