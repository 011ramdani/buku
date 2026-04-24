<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\AnggotaModel;
use App\Models\BukuModel;
use App\Models\LogModel;
use App\Models\DendaModel; // HARUS ADA INI BANG

class Peminjaman extends BaseController
{
    protected $pinjam;
    protected $anggota;
    protected $buku;
    protected $log;
    protected $dendaModel;

    public function __construct()
    {
        $this->pinjam = new PeminjamanModel();
        $this->anggota = new AnggotaModel();
        $this->buku = new BukuModel();
        $this->log = new LogModel();
        $this->dendaModel = new DendaModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Sirkulasi Peminjaman',
            'peminjaman' => $this->pinjam->getPeminjaman()
        ];
        return view('peminjaman/index', $data);
    }

    public function create() 
    {
        $data = [
            'title'   => 'Tambah Peminjaman',
            'anggota' => $this->anggota->findAll(),
            'buku'    => $this->buku->where('tersedia >', 0)->findAll() 
        ];
        return view('peminjaman/create', $data);
    }

    // --- FITUR UNTUK ANGGOTA (SISWA) ---

    public function denda_anggota()
    {
        $id_anggota = session()->get('id_anggota');
        $db = \Config\Database::connect();

        // Ambil denda khusus milik anggota yang login
        $queryDenda = $db->table('denda')
            ->select('denda.*, buku.judul')
            ->join('pengembalian', 'pengembalian.id_pengembalian = denda.id_pengembalian')
            ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->where('peminjaman.id_anggota', $id_anggota)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Denda Saya',
            'denda' => $queryDenda
        ];
        return view('peminjaman/denda_anggota', $data);
    }

    public function upload_dana()
    {
        $id_denda = $this->request->getPost('id_denda');
        $fileBukti = $this->request->getFile('bukti_bayar');

        if ($fileBukti->isValid() && !$fileBukti->hasMoved()) {
            $namaFile = $fileBukti->getRandomName();
            $fileBukti->move('assets/uploads/bukti_dana', $namaFile);

            $this->dendaModel->update($id_denda, [
                'bukti_bayar' => $namaFile
            ]);

            return redirect()->back()->with('success', 'Bukti DANA berhasil dikirim! Menunggu verifikasi Admin.');
        }
        return redirect()->back()->with('error', 'Gagal mengupload bukti.');
    }

    // --- FITUR ADMIN ---

    public function list_denda()
    {
        $db = \Config\Database::connect();
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
        $dataDenda = $this->dendaModel->find($id);

        // 1. Update denda jadi lunas
        $this->dendaModel->update($id, [
            'status' => 'lunas', 
            'tgl_pembayaran' => date('Y-m-d')
        ]);

        // 2. Update status pengembalian jadi Selesai
        $db = \Config\Database::connect();
        $db->table('pengembalian')
           ->where('id_pengembalian', $dataDenda['id_pengembalian'])
          ->update(['status' => 'Selesai']); // GANTI 'status_kembali' JADI 'status'

        return redirect()->back()->with('success', 'Denda lunas & pengembalian buku selesai!');
    }

    public function kembalikan($id_peminjaman)
    {
        $db = \Config\Database::connect();
        $pinjam = $this->pinjam->find($id_peminjaman);
        if (!$pinjam) return redirect()->back();

        $this->pinjam->update($id_peminjaman, ['status' => 'di kembalikan']);

        $tgl_kembali = new \DateTime($pinjam['tanggal_kembali']);
        $tgl_sekarang = new \DateTime(date('Y-m-d'));
        $total_denda = 0;
        
        if ($tgl_sekarang > $tgl_kembali) {
            $selisih = $tgl_sekarang->diff($tgl_kembali);
            $total_denda = $selisih->days * 2000; 
        }

        $db->table('pengembalian')->insert([
            'id_peminjaman'        => $id_peminjaman,
            'tanggal_dikembalikan' => date('Y-m-d'),
            'denda'                => $total_denda
        ]);
        $id_pengembalian = $db->insertID();

        if ($total_denda > 0) {
            $db->table('denda')->insert([
                'id_pengembalian' => $id_pengembalian,
                'jumlah_denda'    => $total_denda,
                'status'          => 'belum bayar'
            ]);
        }

        $this->log->addLog($pinjam['id_anggota'], "Buku telah dikembalikan.", 'diverifikasi');
        return redirect()->to('/peminjaman')->with('success', "Buku telah dikembalikan!");
    }

    // --- FUNGSI PENDUKUNG LAINNYA ---

    public function ajukan($id_buku)
    {
        $role = strtolower(session()->get('role') ?? '');
        $id_anggota = session()->get('id_anggota');
        $nama_user = session()->get('nama');
        $id_log_user = session()->get('id_users'); 

        if ($role !== 'anggota') {
            return redirect()->to('/buku')->with('error', 'Hanya anggota yang dapat mengajukan.');
        }

        $dataBuku = $this->buku->find($id_buku);
        if (!$dataBuku || $dataBuku['tersedia'] <= 0) {
            return redirect()->to('/buku')->with('error', 'Stok buku habis.');
        }

        $this->pinjam->insert([
            'id_anggota'      => $id_anggota,
            'id_buku'         => $id_buku,
            'id_petugas'      => 1, 
            'tanggal_pinjam'  => date('Y-m-d'),
            'tanggal_kembali' => date('Y-m-d', strtotime('+7 days')),
            'status'          => 'menunngu verifikasi', 
        ]);

        $this->log->addLog($id_log_user, "$nama_user mengajukan pinjaman: " . $dataBuku['judul'], 'pending');
        return redirect()->to('/buku')->with('success', 'Berhasil mengajukan pinjaman!');
    }

    public function setujui($id)
    {
        $dataPinjam = $this->pinjam->find($id);
        if (!$dataPinjam) return redirect()->back();

        $this->pinjam->update($id, ['status' => 'di pinjam']);
        $this->log->addLog($dataPinjam['id_anggota'], "Admin menyetujui pinjaman buku ID: " . $dataPinjam['id_buku'], 'diverifikasi');

        return redirect()->to('/peminjaman')->with('success', 'Pinjaman disetujui!');
    }

    public function edit($id)
    {
        $data = [
            'title'      => 'Edit Peminjaman',
            'peminjaman' => $this->pinjam->find($id),
            'anggota'    => $this->anggota->findAll(),
            'buku'       => $this->buku->findAll()
        ];
        return view('peminjaman/edit', $data);
    }

    public function update($id)
    {
        $this->pinjam->update($id, [
            'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'          => $this->request->getPost('status'),
        ]);
        return redirect()->to('/peminjaman')->with('success', 'Data berhasil diubah!');
    }

    public function delete($id)
    {
        if ($this->pinjam->find($id)) {
            $this->pinjam->delete($id);
            return redirect()->to('/peminjaman')->with('success', 'Data berhasil dihapus!');
        }
        return redirect()->to('/peminjaman')->with('error', 'Data tidak ditemukan!');
    }

    public function delete_denda($id)
    {
        $db = \Config\Database::connect();
        if ($db->table('denda')->where('id_denda', $id)->get()->getRowArray()) {
            $db->table('denda')->where('id_denda', $id)->delete();
            return redirect()->to('/peminjaman/list_denda')->with('success', 'Riwayat denda dihapus!');
        }
        return redirect()->to('/peminjaman/list_denda')->with('error', 'Data tidak ditemukan!');
    }
}