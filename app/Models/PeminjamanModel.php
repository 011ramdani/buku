<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table      = 'peminjaman';
    protected $primaryKey = 'id_peminjaman'; // Sesuai foto DB Mas
    protected $allowedFields = ['id_anggota', 'id_buku', 'id_petugas', 'tanggal_pinjam', 'tanggal_kembali', 'status'];

    // --- TAMBAHKAN FUNGSI INI ---
   public function getPeminjaman()
{
    // Sesuaikan join dengan nama kolom di foto tadi
    return $this->select('peminjaman.*, users.nama as nama_anggota, buku.judul')
                ->join('users', 'users.id = peminjaman.id_anggota') 
                ->join('buku', 'buku.id_buku = peminjaman.id_buku') 
                ->findAll();
}
}