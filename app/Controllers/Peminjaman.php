<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\AnggotaModel;
use App\Models\BukuModel;

class Peminjaman extends BaseController
{
    protected $pinjam;
    protected $anggota;
    protected $buku;

    public function __construct()
    {
        $this->pinjam = new PeminjamanModel();
        $this->anggota = new AnggotaModel();
        $this->buku = new BukuModel();
    }

    public function index()
    {
        // Ambil data lengkap dengan join yang ada di Model
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
            'status'          => 'menunggu verifikasi', 
        ];

        $this->pinjam->insert($data);
        return redirect()->to('/buku')->with('success', 'Berhasil mengajukan pinjaman!');
    }

    public function store()
    {
        $id_buku = $this->request->getPost('id_buku');
        $data = [
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'id_buku'         => $id_buku,
            'id_petugas'      => session()->get('id_user') ?? 1,
            'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'          => 'di pinjam', // Pastikan konsisten pakai spasi
        ];

        $this->pinjam->insert($data);
        
        $buku = $this->buku->find($id_buku);
        $this->buku->update($id_buku, ['tersedia' => $buku['tersedia'] - 1]);

        return redirect()->to('/peminjaman')->with('success', 'Data Berhasil Ditambah!');
    }

    public function setujui($id)
    {
        $dataPinjam = $this->pinjam->find($id);
        if (!$dataPinjam) return redirect()->back();

        $id_buku = $dataPinjam['id_buku'];

        $this->pinjam->update($id, [
            'tanggal_pinjam'  => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status'          => 'di pinjam'
        ]);

        $buku = $this->buku->find($id_buku);
        $this->buku->update($id_buku, ['tersedia' => $buku['tersedia'] - 1]);

        return redirect()->to('/peminjaman')->with('success', 'Pinjaman disetujui!');
    }

    public function kembalikan($id_peminjaman)
    {
        $pinjam = $this->pinjam->find($id_peminjaman);
        if (!$pinjam) return redirect()->back();

        $id_buku = $pinjam['id_buku'];
        
        // Kembalikan stok buku
        $bukuSekarang = $this->buku->find($id_buku);
        $this->buku->update($id_buku, ['tersedia' => $bukuSekarang['tersedia'] + 1]);

        // Cek Denda
        $tgl_deadline = new \DateTime($pinjam['tanggal_kembali']);
        $tgl_sekarang = new \DateTime(date('Y-m-d'));
        $pesan = "Buku telah dikembalikan.";

        if ($tgl_sekarang > $tgl_deadline) {
            $selisih = $tgl_sekarang->diff($tgl_deadline);
            $total_denda = $selisih->days * 1000;
            
            $db = \Config\Database::connect();
            $db->table('denda')->insert([
                'id_pengembalian' => $id_peminjaman,
                'jumlah_denda'    => $total_denda,
                'status'          => 'belum bayar'
            ]);
            $pesan = "Buku kembali. Denda: Rp " . number_format($total_denda);
        }

        $this->pinjam->update($id_peminjaman, ['status' => 'di kembalikan']);
        return redirect()->to('/peminjaman')->with('success', $pesan);
    }

    // Fungsi untuk menampilkan halaman form edit
public function edit($id)
{
    // Kita panggil koneksi database dulu biar tidak error
    $db = \Config\Database::connect();

    $data = [
        'title'      => 'Edit Transaksi Peminjaman',
        'peminjaman' => $this->pinjam->find($id),
        'anggota'    => $db->table('anggota')->get()->getResultArray(), 
        'buku'       => $db->table('buku')->get()->getResultArray(),
    ];

    if (empty($data['peminjaman'])) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Data transaksi tidak ditemukan.');
    }

    return view('peminjaman/edit', $data);
}
// Fungsi untuk memproses perubahan data ke database
public function update($id)
{
    $this->pinjam->update($id, [
        'id_anggota'      => $this->request->getPost('id_anggota'),
        'id_buku'         => $this->request->getPost('id_buku'),
        'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam'),
        'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
    ]);

    return redirect()->to('/peminjaman')->with('success', 'Data transaksi berhasil diperbarui!');
}
    public function delete($id = null)
    {
        $this->pinjam->delete($id);
        return redirect()->to('/peminjaman')->with('success', 'Berhasil hapus data!');
    }

 // Ubah nama fungsinya jadi list_denda biar sesuai dengan URL yang error itu
public function list_denda()
{
    $db = \Config\Database::connect();
    $keyword = $this->request->getGet('keyword');
    
    $builder = $db->table('denda');
    $builder->select('denda.*, anggota.nama_anggota, buku.judul');
    
    // JOIN disesuaikan dengan gambar database Abang
    // denda -> pengembalian -> peminjaman -> anggota/buku
    $builder->join('pengembalian', 'pengembalian.id_pengembalian = denda.id_pengembalian', 'left');
    $builder->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left');
    $builder->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left');
    $builder->join('buku', 'buku.id_buku = peminjaman.id_buku', 'left');

    if ($keyword) {
        $builder->groupStart();
        $builder->like('anggota.nama_anggota', $keyword);
        $builder->orLike('buku.judul', $keyword);
        $builder->groupEnd();
    }

    $data = [
        'title' => 'Manajemen Denda',
        'denda' => $builder->get()->getResultArray()
    ];

    return view('peminjaman/denda', $data);
}
    public function konfirmasi_bayar($id)
{
    // Panggil koneksi databasenya dulu
    $db = \Config\Database::connect();

    // Gunakan variabel $db (bukan $this->db)
    $db->table('denda')->where('id_denda', $id)->update([
        'status' => 'lunas'
    ]);

    // Arahkan kembali ke halaman list_denda
    return redirect()->to('/peminjaman/list_denda')->with('success', 'Pembayaran denda berhasil diverifikasi!');
}
   public function delete_denda($id)
{
    $db = \Config\Database::connect();
    
    $db->table('denda')->where('id_denda', $id)->delete();

    return redirect()->to('/peminjaman/list_denda')->with('success', 'Riwayat denda berhasil dihapus!');
}
}