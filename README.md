# Rest-API-with-Laravel
repository ini berisi contoh program rest-api pada laravel

Berikut merupakan langkah-langkah membuat rest-api pada laravel

# Tools yang dibutuhkan :
1. Xampp
2. Composer, untuk file & tutorial instalasi dapat diakses pada https://getcomposer.org/download/
3. Laravel, kali ini saya menggunakan laravel 7.0. Tutorial instalasi dapat diakses pada https://laravel.com/docs/7.x/installation
4. Text Editor
5. Postman

# Membuat project baru menggunakan laravel
Untuk membuat project baru, buka command prompt lalu arahkan ke direktori xampp/htdocs/namafolder.
Jika sudah, ketikan kode berikut 
```
composer create-project --prefer-dist laravel/laravel:^7.0 namaproject
```
Pada project kali ini, nama project yang saya buat adalah rest-api

# Membuat database baru
Untuk membuat database baru, aktifkan xampp terlebih dahulu. Kemudian buat database dengan nama warehouse.

# Ubah file .env
Buka folder project yang dibuat di text editor yang digunakan, lalu pilih file bernama <b>.env</b> 
Ubah nilai database menjadi seperti
```
DB_DATABASE=warehouse
```

# Buat file migrasi
Buka command prompt, lalu ketikkan kode berikut
```
php artisan make:migration create_stuff_table
```

Jika sudah, buka project anda lalu buka folder database->migration-> buka file yang baru saja dibuat. Lalu ubah menjadi seperti berikut,
```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStuffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stuff', function (Blueprint $table) {
            $table->bigIncrements('kode_barang');
            $table->string('nama_barang');
            $table->string('merk');
            $table->integer('stok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stuff');
    }
}
```

Kemudian kembali ke command prompt dan ketikkan kode berikut 
```
php artisan migrate
```
Jika berhasil maka database warehouse akan terupdate.

# Membuat controller dengan nama StuffController
Untuk membuat controller, ketikkan kode berikut pada command prompt
```
php artisan make:controller StuffController
```

# Membuat model dengan nama StuffModel
Ketikkan kode berikut pada command prompt
```
php artisan make:model StuffModel
```
Jika sudah, buka file model yang baru dibuat lalu ubah isinya menjadi seperti berikut
```
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
```

Kemudian, kita akan membuat Restfull API nya

# 1. GET
Pertama, tambahkan kode untuk mengakses model pada file StuffController
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StuffModel; //using StuffModel
```

Kedua, tambahkan function untuk mengakses / get data pada database
```
class StuffController extends Controller
{
    //function to get data in database
    public function get_all_stuff() {
    	return response()->json(StuffModel::all(), 200);
    }
```

Kemudian buat url. Buka folder routes->api.php lalu tambahkan kode berikut
```
Route::get('stuff','StuffController@get_all_stuff');
```

Jika sudah, kita bisa jalankan pada browser dengan mengakses alamat
```
http://127.0.0.1:8000/api/stuff
```

Jika berhasil maka akan muncul data array yang berhasil diakses dari database.

# 2. POST
Tambahkan function pada StuffController untuk melakukan action post. Berikut kodenya
```
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
```

Kemudian tambahkan url. Buka folder routes->api.php lalu tambahkan kode berikut
```
Route::post('stuff/add','StuffController@insert_data_stuff');
```

Terakhir, untuk menguji fungsi tersebut, kita perlu menggunakan Postman.

Buka postman, lalu pilih POST dan pastekan url berikut
```
http://127.0.0.1:8000/api/stuff/add
```

# 3. PUT
Tambahkan function pada StuffController untuk melakukan action put. Berikut kodenya
```
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
```

Kemudian tambahkan url. Buka folder routes->api.php lalu tambahkan kode berikut
```
Route::put('stuff/update/{kode_barang}','StuffController@update_data_stuff');
```

Terakhir, untuk menguji fungsi tersebut, kita perlu menggunakan Postman.

Buka postman, lalu pilih PUT dan pastekan url berikut
```
http://127.0.0.1:8000/api/stuff/update/2
```

# 4. DELETE
Tambahkan function pada StuffController untuk melakukan action delete. Berikut kodenya
```
//function to delete data
    public function delete_data_stuff($id) {
    	$stuff_check = StuffModel::firstWhere('kode_barang', $id);
    	if ($stuff_check) {
    		StuffModel::destroy($id);
    		return response([
    			'status' => 'OK',
    			'message' => 'Data berhasil dihapus', 200);
    	} else {
    		return response([
    			'status' => 'Data not found',
    			'message' => 'Kode tidak ditemukan'], 404);
    	}
    }
 ```
 Kemudian tambahkan url. Buka folder routes->api.php lalu tambahkan kode berikut
```
Route::put('stuff/update/{kode_barang}','StuffController@update_data_stuff');
```

Terakhir, untuk menguji fungsi tersebut, kita perlu menggunakan Postman.

Buka postman, lalu pilih DELETE dan pastekan url berikut
```
http://127.0.0.1:8000/api/stuff/delete/1
```
