<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StuffModel; //using StuffModel

class StuffController extends Controller
{
    //function to get data in database
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
}
