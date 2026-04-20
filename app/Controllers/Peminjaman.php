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
        $data = [
            'peminjaman' => $this->pinjam->getPeminjaman()
        ];
        return view('peminjaman/index', $data);
    }

    public function create()
    {
        $data = [
            'anggota' => $this->anggota->findAll(),
            'buku'    => $this->buku->findAll()
        ];
        return view('peminjaman/create', $data);
    }

    public function store()
    {
        $data = [
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'id_buku'         => $this->request->getPost('id_buku'),
            'id_petugas'      => session()->get('id_user') ?? 1,
            'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'          => 'di pinjam',
        ];

        $this->pinjam->insert($data);
        return redirect()->to('/peminjaman')->with('success', 'Data Berhasil Ditambah!');
    }

    public function kembalikan($id_peminjaman)
    {
        $pinjam = $this->pinjam->find($id_peminjaman);
        $id_buku = $pinjam['id_buku'];
        
        // Update stok buku
        $bukuSekarang = $this->buku->find($id_buku);
        $this->buku->update($id_buku, ['tersedia' => $bukuSekarang['tersedia'] + 1]);

        $tgl_deadline = new \DateTime($pinjam['tanggal_kembali']);
        $tgl_sekarang = new \DateTime(date('Y-m-d'));
        
        $pesan = "Buku kembali tepat waktu.";

        if ($tgl_sekarang > $tgl_deadline) {
            $selisih = $tgl_sekarang->diff($tgl_deadline);
            $total_denda = $selisih->days * 1000;

            // FIX: Panggil koneksi DB
            $db = \Config\Database::connect();
            
            $db->table('denda')->insert([
                'id_pengembalian' => $id_peminjaman, // FIX: Pakai variabel yang benar
                'jumlah_denda'    => $total_denda,
                'status'          => 'belum bayar'
            ]);
            $pesan = "Buku kembali. Denda: Rp " . number_format($total_denda);
        }

        $this->pinjam->update($id_peminjaman, ['status' => 'di kembalikan']);
        return redirect()->to('/peminjaman')->with('success', $pesan);
    }

    public function ajukan($id_buku)
    {
        if (session()->get('role') !== 'anggota') {
            return redirect()->to('/buku')->with('error', 'Hanya anggota yang bisa mengajukan.');
        }

        $id_anggota = session()->get('id_anggota');
        $buku = $this->buku->find($id_buku);

        if ($buku['tersedia'] <= 0) {
            return redirect()->to('/buku')->with('error', 'Maaf, stok buku sedang habis.');
        }

        $this->pinjam->save([
            'id_buku'         => $id_buku,
            'id_anggota'      => $id_anggota,
            'tanggal_pinjam'  => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status'          => 'diajukan'
        ]);

        return redirect()->to('/buku')->with('success', 'Berhasil mengajukan!');
    }

    public function setujui($id)
    {
        $dataPinjam = $this->pinjam->find($id);
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

    public function edit($id = null)
    {
        $data = [
            'pinjam'  => $this->pinjam->find($id),
            'anggota' => $this->anggota->findAll(),
            'buku'    => $this->buku->findAll()
        ];
        return view('peminjaman/edit', $data);
    }

    public function update($id = null)
    {
        $id_final = $id ?: $this->request->getPost('id_peminjaman');
        $data = [
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'id_buku'         => $this->request->getPost('id_buku'),
            'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'          => $this->request->getPost('status'),
        ];

        $db = \Config\Database::connect();
        if ($db->table('peminjaman')->where('id_peminjaman', $id_final)->update($data)) {
            return redirect()->to('/peminjaman')->with('success', 'Berhasil update!');
        }
        return redirect()->back()->with('error', 'Gagal update!');
    }

    public function delete($id = null)
    {
        $db = \Config\Database::connect();
        $db->table('peminjaman')->where('id_peminjaman', $id)->delete();
        return redirect()->to('/peminjaman')->with('success', 'Berhasil hapus data!');
    }
    public function list_denda()
{
    $db = \Config\Database::connect();
    
    // Ambil keyword kalau ada pencarian
    $keyword = $this->request->getGet('keyword');
    $builder = $db->table('denda')
        ->join('peminjaman', 'peminjaman.id_peminjaman = denda.id_pengembalian')
        ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
        ->join('buku', 'buku.id_buku = peminjaman.id_buku')
        ->select('denda.*, anggota.nama_anggota, buku.judul');

    if ($keyword) {
        $builder->like('anggota.nama_anggota', $keyword)
                ->orLike('buku.judul', $keyword);
    }

    $data['denda'] = $builder->get()->getResultArray();

    // Pastikan nama file view-nya benar (misal: denda.php atau list_denda.php)
    return view('peminjaman/denda', $data); 
}

public function konfirmasi_bayar($id)
{
    $db = \Config\Database::connect();
    $db->table('denda')->where('id_denda', $id)->update(['status' => 'lunas']);
    
    return redirect()->back()->with('success', 'Pembayaran denda berhasil diverifikasi!');
}

public function delete_denda($id)
{
    $db = \Config\Database::connect();
    $db->table('denda')->where('id_denda', $id)->delete();
    
    return redirect()->back()->with('success', 'Riwayat denda berhasil dihapus!');
}
}