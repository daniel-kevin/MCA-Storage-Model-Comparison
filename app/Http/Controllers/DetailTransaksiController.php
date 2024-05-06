<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\DetailTransaksiIndex;
use App\Models\MasterTransaksi;
use App\Models\MasterTransaksiIndex;
use App\Models\TransaksiJSON;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DetailTransaksiController extends Controller
{
    public function getData(Request $request){
        $timeStart = microtime(true);

        $data = DetailTransaksi::with([
            'masterTransaksi.pelanggan',
            'barang'
        ])->get();

        $timeEnd = microtime(true);

        $timeTaken = ($timeEnd - $timeStart);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil data',
            'data' => $data,
            'time' => $timeTaken,
        ]);
    }
    public function getIndexedData(Request $request){
        $timeStart = microtime(true);

        $data = DetailTransaksiIndex::with([
            'masterTransaksi.pelanggan',
            'barang'
        ])->get();

        $timeEnd = microtime(true);

        $timeTaken = ($timeEnd - $timeStart);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil data',
            'data' => $data,
            'time' => $timeTaken,
        ]);
    }
    public function getJSONData(Request $request){
        $timeStart = microtime(true);

        $data = TransaksiJSON::get();

        $timeEnd = microtime(true);

        $timeTaken = ($timeEnd - $timeStart);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil data',
            'data' => $data,
            'time' => $timeTaken,
        ]);
    }

    public function getCachedData(Request $request){

        $cacheTime = 3600;
        $timeStart = microtime(true);

        $data = Cache::remember('t_transaksi', $cacheTime, function (){
            return DetailTransaksiIndex::with([
                'masterTransaksi.pelanggan',
                'barang'
            ])->get();
        });

        $timeEnd = microtime(true);

        $timeTaken = ($timeEnd - $timeStart);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil data',
            'data' => $data,
            'time' => $timeTaken,
        ]);
    }

    public function storeData(Request $request){
        $masterData = MasterTransaksi::create([
            'pelanggan_id' => $request->pelanggan_id,
            'tanggal' => $request->tanggal
        ]);

        $data = json_decode($request->barang);
        foreach($data->barang as $barang){
            DetailTransaksi::create([
                'barang_id' => $barang->barang->id,
                'qty' => $barang->qty,
                'transaksi_id' => $masterData->id
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menyimpan data',
            'data' => null
        ]);
    }

    public function storeIndexedData(Request $request){
        $masterData = MasterTransaksiIndex::create([
            'pelanggan_id' => $request->pelanggan_id,
            'tanggal' => $request->tanggal
        ]);

        $data = json_decode($request->barang);
        foreach($data->barang as $barang){
            DetailTransaksiIndex::create([
                'barang_id' => $barang->barang->id,
                'qty' => $barang->qty,
                'transaksi_id' => $masterData->id
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menyimpan data',
            'data' => null
        ]);
    }

    public function storeJSONData(Request $request){
        TransaksiJSON::create([
            'value' => $request->barang
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menyimpan data',
            'data' => null
        ]);
    }
}
