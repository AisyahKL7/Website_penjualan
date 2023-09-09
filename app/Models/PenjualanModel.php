<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table = "penjualan";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_toko', 'alamat', 'nama_produk', 'barcode','kategori','tanggal', 'terjual'];
}
