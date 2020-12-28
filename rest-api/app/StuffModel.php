<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StuffModel extends Model
{
    //intial table
    protected $table = 'stuff';

    //primary key off stuff table
    protected $primaryKey = 'kode_barang';
}
