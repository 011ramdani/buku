<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\AnggotaModel;
use App\Models\BukuModel;
use App\Models\LogModel;

class Peminjaman extends BaseController
{
    protected $pinjam;
    protected $anggota;
    protected $buku;
    protected $log;

    public function __construct()
    {
        $this->pinjam = new PeminjamanModel();
        $this->anggota = new AnggotaModel();
        $this->buku = new BukuModel();
        $this->log = new LogModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Sirkulasi Peminjaman',
            'peminjaman' => $this->pinjam->getPeminjaman()
        ];
        return view('peminjaman/index', $data);
    }

    public function ajukan($id_buku)
    {
        $role = strtolower(session()->get('role') ?? '');
        $id_anggota = session()->get('id_anggota');
        $nama_user = session()->get('nama');
        // PERBAIKAN: Gunakan id_users agar sinkron dengan Dashboard
        $id_log_user = session()->get('id_users'); 

        if ($role !== 'anggota') {
            return redirect()->to('/buku')->with('error', 'Hanya anggota yang dapat mengajukan.');
        }

        $dataBuku = $this->buku->find($id_buku);
        if (!$dataBuku || $dataBuku['tersedia'] <= 0) {
            return redirect()->to('/buku')->with('error', 'Stok buku habis.');
        }

        $data = [
            'id_anggota'      => $id_anggota,
            'id_buku'         => $id_buku,
            'id_petugas'      => 1, 
            'tanggal_pinjam'  => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status'          => 'menunngu verifikasi', 
        ];

        $this->pinjam->insert($data);

        // PERBAIKAN: Pakai $id_log_user (id_users)
        $this->log->addLog($id_log_user, "$nama_user mengajukan pinjaman buku: " . $dataBuku['judul'], 'pending');

        return redirect()->to('/buku')->with('success', 'Berhasil mengajukan pinjaman!');
    }

    public function setujui($id)
{
    $dataPinjam = $this->pinjam->find($id);
    if (!$dataPinjam) return redirect()->back();

    $this->pinjam->update($id, [
        'status' => 'di pinjam'
    ]);

    // Tambahkan LOG BARU dengan status 'diverifikasi' (Hijau)
    // Kita ambil ID Anggota agar log muncul di dashboard si Anggota tersebut
    $this->log->addLog($dataPinjam['id_anggota'], "Admin menyetujui peminjaman buku ID: " . $dataPinjam['id_buku'], 'diverifikasi');

    return redirect()->to('/peminjaman')->with('success', 'Pinjaman disetujui!');
}

public function kembalikan($id_peminjaman)
{
    $db = \Config\Database::connect();
    
    // 1. Ambil data peminjaman
    $pinjam = $this->pinjam->find($id_peminjaman);
    if (!$pinjam) return redirect()->back();

    // 2. Update status di tabel peminjaman
    $this->pinjam->update($id_peminjaman, ['status' => 'di kembalikan']);

    // 3. Hitung Denda
    $tgl_kembali = new \DateTime($pinjam['tanggal_kembali']);
    $tgl_sekarang = new \DateTime(date('Y-m-d'));
    $total_denda = 0;
    
    if ($tgl_sekarang > $tgl_kembali) {
        $selisih = $tgl_sekarang->diff($tgl_kembali);
        $hari_terlambat = $selisih->days;
        $total_denda = $hari_terlambat * 2000; // Contoh: Rp 2.000 per hari
    }

    // 4. Masukkan ke tabel pengembalian (Nama kolom: tanggal_dikembalikan)
    $db->table('pengembalian')->insert([
        'id_peminjaman'        => $id_peminjaman,
        'tanggal_dikembalikan' => date('Y-m-d'), // SESUAI SCREENSHOT ABANG
        'denda'                => $total_denda
    ]);
    $id_pengembalian = $db->insertID();

    // 5. Jika ada denda, masukkan juga ke tabel denda agar muncul di menu Data Denda
    if ($total_denda > 0) {
        $db->table('denda')->insert([
            'id_pengembalian' => $id_pengembalian,
            'jumlah_denda'    => $total_denda,
            'status'          => 'belum bayar'
        ]);
    }

    // 6. Log Aktivitas
    $this->log->addLog($pinjam['id_anggota'], "Buku telah dikembalikan.", 'diverifikasi');

    return redirect()->to('/peminjaman')->with('success', "Buku telah dikembalikan!");
}
public function list_denda()
{
    $db = \Config\Database::connect();
    
    // Query ini mengikuti jalur: denda -> pengembalian -> peminjaman -> anggota & buku
    $queryDenda = $db->table('denda')
        ->select('denda.*, anggota.nama_anggota, buku.judul')
        ->join('pengembalian', 'pengembalian.id_pengembalian = denda.id_pengembalian')
        ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman')
        ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
        ->join('buku', 'buku.id_buku = peminjaman.id_buku')
        ->get()
        ->getResultArray();

    $data = [
        'title' => 'Manajemen Denda',
        'denda' => $queryDenda
    ];

    return view('peminjaman/denda', $data); 
}
public function konfirmasi_bayar($id)
{
    $db = \Config\Database::connect();
    
    // Update status di tabel denda
    $db->table('denda')->where('id_denda', $id)->update([
        'status' => 'lunas',
        'tgl_pembayaran' => date('Y-m-d H:i:s') // Isi juga tanggal bayarnya
    ]);

    return redirect()->to('/peminjaman/list_denda')->with('success', 'Pembayaran denda berhasil diverifikasi!');
}
public function edit($id)
{
    $data = [
        'title'      => 'Edit Peminjaman',
        'peminjaman' => $this->pinjam->find($id),
        'anggota'    => $this->anggota->findAll(),
        'buku'       => $this->buku->findAll()
    ];

    // Pastikan Abang punya file view: app/Views/peminjaman/edit.php
    return view('peminjaman/edit', $data);
}

public function update($id)
{
    $data = [
        'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam'),
        'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
        'status'          => $this->request->getPost('status'),
    ];

    $this->pinjam->update($id, $data);

    return redirect()->to('/peminjaman')->with('success', 'Data peminjaman berhasil diubah!');
}
public function delete($id)
{
    // 1. Cek apakah data peminjaman ada
    $data = $this->pinjam->find($id);

    if ($data) {
        // 2. Hapus datanya
        $this->pinjam->delete($id);

        // 3. Catat ke Log (Opsional, biar makin keren)
        $this->log->addLog(session()->get('id_users'), "Menghapus data peminjaman ID: " . $id, 'diverifikasi');

        return redirect()->to('/peminjaman')->with('success', 'Data peminjaman berhasil dihapus!');
    } else {
        return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan!');
    }
}
public function delete_denda($id)
{
    $db = \Config\Database::connect();
    
    // 1. Cek dulu apakah datanya ada di tabel denda
    $cek = $db->table('denda')->where('id_denda', $id)->get()->getRowArray();

    if ($cek) {
        // 2. Hapus datanya
        $db->table('denda')->where('id_denda', $id)->delete();

        return redirect()->to('/peminjaman/list_denda')->with('success', 'Riwayat denda berhasil dihapus!');
    } else {
        return redirect()->to('/peminjaman/list_denda')->with('error', 'Data denda tidak ditemukan!');
    }
}
}