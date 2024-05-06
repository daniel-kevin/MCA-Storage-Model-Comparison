<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\DetailTransaksiIndex;
use App\Models\MasterTransaksi;
use App\Models\MasterTransaksiIndex;
use App\Models\TransaksiJSON;
use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Cache;

class DetailTransaksiController extends Controller
{
    public function getData(Request $request){
        $timeStart = microtime(true);

        // $data = DetailTransaksi::select('t_transaksi.*','m_transaksi.*','m_pelanggan.*','m_barang.*')
        // ->join('m_transaksi','m_transaksi.id','t_transaksi.transaksi_id')
        // ->join('m_pelanggan','m_pelanggan.id','m_transaksi.pelanggan_id')
        // ->join('m_barang','m_barang.id','t_transaksi.barang_id')
        // ->get();
        $data = null;
        $time = Benchmark::measure(function (){
            DetailTransaksi::with([
                'masterTransaksi.pelanggan',
                'barang'
            ])->get();    
        });
        // $data = DetailTransaksi::with([
        //     'masterTransaksi.pelanggan',
        //     'barang'
        // ])->get();

        $timeEnd = microtime(true);

        $timeTaken = ($timeEnd - $timeStart);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil data',
            'data' => $data,
            'time' => $timeTaken,
            'benchmark' => $time
        ]);
    }
    public function getIndexedData(Request $request){
        $timeStart = microtime(true);

        // $data = DetailTransaksiIndex::select('t_transaksi_index.*','m_transaksi_index.*','m_pelanggan_index.*','m_barang_index.*')
        // ->join('m_transaksi_index','m_transaksi_index.id','t_transaksi_index.transaksi_id')
        // ->join('m_pelanggan_index','m_pelanggan_index.id','m_transaksi_index.pelanggan_id')
        // ->join('m_barang_index','m_barang_index.id','t_transaksi_index.barang_id')
        // ->get();
        $data = null;
        $time = Benchmark::measure(function (){
            DetailTransaksiIndex::with([
                'masterTransaksi.pelanggan',
                'barang'
            ])->get();   
        });

        // $data = DetailTransaksiIndex::with([
        //     'masterTransaksi.pelanggan',
        //     'barang'
        // ])->get();

        $timeEnd = microtime(true);

        $timeTaken = ($timeEnd - $timeStart);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil data',
            'data' => $data,
            'time' => $timeTaken,
            'benchmark' => $time
        ]);
    }
    public function getJSONData(Request $request){
        $timeStart = microtime(true);

        $data = null;
        $time = Benchmark::measure(function () {
            TransaksiJSON::get();
        });
        // $data = TransaksiJSON::get();

        $timeEnd = microtime(true);

        $timeTaken = ($timeEnd - $timeStart);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengambil data',
            'data' => $data,
            'time' => $timeTaken,
            'benchmark' => $time
        ]);
    }

    public function getCachedData(Request $request){

        $cacheTime = 3600;
        $timeStart = microtime(true);

        $time = Benchmark::measure(function () use ($cacheTime) {
            $data = Cache::remember('t_transaksi', $cacheTime, function (){
                // return $data = DetailTransaksiIndex::select('t_transaksi_index.*','m_transaksi_index.*','m_pelanggan_index.*','m_barang_index.*')
                // ->join('m_transaksi_index','m_transaksi_index.id','t_transaksi_index.transaksi_id')
                // ->join('m_pelanggan_index','m_pelanggan_index.id','m_transaksi_index.pelanggan_id')
                // ->join('m_barang_index','m_barang_index.id','t_transaksi_index.barang_id')
                // ->get();
                
                return DetailTransaksiIndex::with([
                    'masterTransaksi.pelanggan',
                    'barang'
                ])->get();
            });    
        });

        $data = Cache::remember('t_transaksi', $cacheTime, function (){
            // return $data = DetailTransaksiIndex::select('t_transaksi_index.*','m_transaksi_index.*','m_pelanggan_index.*','m_barang_index.*')
            // ->join('m_transaksi_index','m_transaksi_index.id','t_transaksi_index.transaksi_id')
            // ->join('m_pelanggan_index','m_pelanggan_index.id','m_transaksi_index.pelanggan_id')
            // ->join('m_barang_index','m_barang_index.id','t_transaksi_index.barang_id')
            // ->get();
            
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
            'benchmark' => $time
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
