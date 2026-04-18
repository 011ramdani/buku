<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table      = 'kategori'; // Nama tabel di database kamu
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = ['nama_kategori']; // Field yang boleh diisi
}