<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table      = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $allowedFields = [
        'id_anggota', 'id_buku', 'id_petugas', 
        'tanggal_pinjam', 'tanggal_kembali', 'status'
    ];

  public function getPeminjaman()
{
    return $this->db->table('peminjaman')
        ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
        ->join('buku', 'buku.id_buku = peminjaman.id_buku')
        ->select('peminjaman.*, anggota.nama_anggota, buku.judul')
        // Hapus orderBy yang spesifik id_pengembalian karena bikin error
        ->get()->getResultArray();
}
}