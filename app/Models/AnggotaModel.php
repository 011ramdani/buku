<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table      = 'anggota';
    protected $primaryKey = 'id_anggota';
    
    // Sesuaikan dengan foto struktur tabel Mas
   protected $allowedFields = ['nis', 'nama_anggota', 'username', 'password', 'role', 'alamat', 'no_hp'];
}