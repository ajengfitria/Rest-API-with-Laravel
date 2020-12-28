<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StuffModel; //using StuffModel

class StuffController extends Controller
{
    //function to get data from database
    public function get_all_stuff() {
    	return response()->json(StuffModel::all(), 200);
    }

    //function to post data into database
    public function insert_data_stuff() {
    	$insert_stuff = new StuffModel;
    	$insert_stuff->nama_barang = $request->namaBarang;
    	$insert_stuff->merk = $request->merk;
    	$insert_stuff->stok = $request->stok;
    	$insert_stuff->save();
    	return response([
    		'status' => 'OK',
    		'massage' => 'Barang berhasil ditambahkan',
    		'data' => $insert_stuff], 200);
    }

    //function to put data from database
    public function update_data_stuff(Request $request, $id) {
    	$stuff_check = StuffModel::firstWhere('kode_barang', $id);
    	if ($stuff_check) {
    		$data_stuff = StuffModel::find($id);
    		$data_stuff->nama_barang = $request->namaBarang;
    		$data_stuff->merk = $request->merk;
    		$data_stuff->stok = $request->stok;
    		$data_stuff->save();

    		return response([
    			'status' => 'OK',
    			'message' => 'Data berhasil diubah',
    			'update-data' => $data_stuff], 200);
    	} else {
    		return response([
    			'status' => 'Data not found',
    			'message' => 'Kode tidak ditemukan'], 404);
    	}
    }
}
