<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table      = 'anggota';
    protected $primaryKey = 'id_anggota';
    
    // Sesuaikan dengan foto struktur tabel Mas
    protected $allowedFields = ['user_id', 'nis', 'nama_anggota', 'alamat', 'no_hp', 'tanggal_daftar'];
}