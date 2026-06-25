# AI Prompting Log - Inventory Service (Tugas 3)
**Nama:** Ahmad Rizky Ivanzya
**NIM:** 102022400004
**Service:** Inventory Service (Service A - Gudang Bahan Baku)
**Mata Kuliah:** BBK2HAB3 - Integrasi Aplikasi Enterprise

**Rabu, 10 Juni 2026 Jam: 08.00**
```text
PS D:\IAE\tugas2\inventory-service> php artisan migrate
Illuminate\Database\QueryException
SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for db failed: No such host is known.
```
ini kenapa pas mau migrate error *host db no such host is known* ya?

**Rabu, 10 Juni 2026 Jam: 08.20**
```text
PS D:\IAE\tugas2\inventory-service> php artisan migrate
Illuminate\Database\QueryException
SQLSTATE[HY000] [1045] Access denied for user 'root'@'localhost' (using password: YES)
```
nah kalau yang ini malah *access denied* pas dicoba ganti host-nya ke 127.0.0.1, salah di password-nya kah?

**Rabu, 10 Juni 2026 Jam: 08.45**
pas lagi composer require buat install package, di proses *generating optimized autoload files* emang lumayan lama gini ya? ditunggu aja atau ada yang nyangkut?

**Rabu, 10 Juni 2026 Jam: 08.50**
proses *generating optimized autoload files* nya emang agak lama kah? kok belum beres-beres dari tadi?

**Rabu, 10 Juni 2026 Jam: 09.15**
sekarang lanjut ke tugas 3 . konsep pengamanan sso pakai jwt itu gimana? (baca file yang saya cantumkan)

**Rabu, 10 Juni 2026 Jam: 10.00**
kalo tokennya udah sukses, gimana cara nyamain user dari sso itu ke database lokal saya? 

**Rabu, 10 Juni 2026 Jam: 13.30**
cara nyusun ini pake http client gimana ya?

**Rabu, 10 Juni 2026 Jam: 14.45**
Cara agar sama seperti punya dosen gimana? saya mau ngambil nilai  sama  seperti digambar

**Rabu, 10 Juni 2026 Jam: 16.20**
gabungin semua aja tadi (sso jwt, local database transaction, soap audit, sama rabbitmq proxy) jadi satu method utuh di ComponentController@receive

**Kamis, 11 Juni 2026 Jam: 09.10**
pas nyoba hit M2M pake body {"api_key": "KEY-MHS-01"}, kok respon dari server bilang key-mhs nya gaada atau ga terdaftar?

**Kamis, 11 Juni 2026 Jam: 09.30**
```text
<?php
use App\Http\Controllers\ComponentController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
   Route::middleware('check.api.key')->group(function () {
        Route::get('/components', [ComponentController::class, 'index']);
        Route::get('/components/{id}', [ComponentController::class, 'show']);
    });
    
    Route::post('/components/receive', [ComponentController::class, 'receive']);
});
```
ini routes saya, tapi pas di-test di Postman kenapa responsenya malah balik ke halaman welcome html laravel status 200 ok? bukan json sukses?

**Kamis, 11 Juni 2026 Jam: 10.15**
oke terus postman tadi gimana? saya udah masukin bearer token tapi kenapa di response json keluar error "unauthorized. bearer token is missing"? padahal tokennya udah saya taruh di headers manual

**Kamis, 11 Juni 2026 Jam: 11.00**
saya udah pindahin tokennya ke tab authorization bearer token di postman, tapi sekarang malah keluar error html lagi (welcome page laravel title inventoryservice), kenapa ya?

**Kamis, 11 Juni 2026 Jam: 13.15**
tetep gak succes, rutenya udah dipastikan masuk, tapi responsenya masih berupa kode html panjang bawaan laravel

**Kamis, 11 Juni 2026 Jam: 14.00**
kenapa ini? status html udah hilang tapi kenapa validasinya gagal? padahal body json yang saya kirim itu {"component_id": 1, "qty": 50}

**Kamis, 11 Juni 2026 Jam: 14.15**
pas ditest lagi di Postman malah muncul error *Component with that part_number not found*, ini salah di datanya atau query di controller saya ya?

**Kamis, 11 Juni 2026 Jam: 14.45**
ini output saya, udah benar? alur sso, soap, sama rabbitmq ke cloud dosen berarti udah berhasil kan tanpa error?

**Kamis, 11 Juni 2026 Jam: 15.00**
oke, responnya udah aman semua dan gaada error lagi. habis ini enaknya ngapain lagi ya buat mastiin atau lanjut modul lain?

**Kamis, 11 Juni 2026 Jam: 15.30**
saya udah pasang IAE_API_KEY=KEY-MHS-01 sama IAE_TEAM_ID=TEAM-03 di file .env, tapi pas dijalankan kok kedeteksinya gaada terus ya? apa perlu di-clear cache dulu env-nya?