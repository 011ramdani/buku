<?php namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model {
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman'; // Sesuai gambar
    protected $allowedFields = [
        'id_anggota', 
        'id_buku', 
        'id_petugas', 
        'tanggal_pinjam', 
        'tanggal_kembali', 
        'status'
    ];

    public function getPeminjaman()
    {
        // Join ke tabel lain agar muncul nama & judul (sesuaikan primary key tabel masing-masing)
        return $this->select('peminjaman.*, users.nama as nama_anggota, buku.judul_buku')
                    ->join('users', 'users.id = peminjaman.id_anggota') 
                    ->join('buku', 'buku.id_buku = peminjaman.id_buku')
                    ->findAll();
    }
}