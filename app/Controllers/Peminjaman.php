<?php namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use App\Models\UsersModel;
use App\Models\AnggotaModel;

class Peminjaman extends BaseController {
    // 1. Deklarasi property secara formal
    protected $pinjam;
    protected $buku;
    protected $user;
    protected $anggota;
    protected $db;

    public function __construct() {
        $this->pinjam = new PeminjamanModel();
        $this->buku = new BukuModel();
        $this->user = new UsersModel();
        $this->anggota = new AnggotaModel();
        // 2. Inisialisasi koneksi database
        $this->db = \Config\Database::connect(); 
    }

    public function index() {
        $data = [
            'title' => 'Data Peminjaman',
            'peminjaman' => $this->pinjam->getPeminjaman()
        ];
        return view('peminjaman/index', $data);
    }

    public function create() {
        $data = [
            'title'   => 'Tambah Peminjaman',
            'anggota' => $this->anggota->findAll(),
            'buku'    => $this->buku->where('tersedia >', 0)->findAll()
        ];
        return view('peminjaman/create', $data);
    }

    public function store() {
        $id_buku = $this->request->getPost('id_buku');
        $this->pinjam->save([
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'id_buku'         => $id_buku,
            'id_petugas'      => session()->get('id'),
            'tanggal_pinjam'  => date('Y-m-d'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'          => 'di pinjam'
        ]);

        $buku = $this->buku->find($id_buku);
        $this->buku->update($id_buku, ['tersedia' => $buku['tersedia'] - 1]);

        return redirect()->to('/peminjaman')->with('success', 'Data berhasil dipinjam');
    }

    public function edit($id) {
        $data = [
            'title'   => 'Edit Peminjaman',
            'pinjam'  => $this->pinjam->find($id),
            'anggota' => $this->anggota->findAll(),
            'buku'    => $this->buku->findAll()
        ];
        return view('peminjaman/edit', $data);
    }

    public function update($id) {
        $dataLama = $this->pinjam->find($id);
        $statusBaru = $this->request->getPost('status');
        $id_buku = $dataLama['id_buku'];

        if ($dataLama['status'] == 'di pinjam' && $statusBaru == 'di kembalikan') {
            $buku = $this->buku->find($id_buku);
            $this->buku->update($id_buku, ['tersedia' => $buku['tersedia'] + 1]);
        } 
        elseif ($dataLama['status'] == 'di kembalikan' && $statusBaru == 'di pinjam') {
            $buku = $this->buku->find($id_buku);
            $this->buku->update($id_buku, ['tersedia' => $buku['tersedia'] - 1]);
        }

        $this->pinjam->update($id, [
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'id_buku'         => $this->request->getPost('id_buku'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'          => $statusBaru
        ]);

        return redirect()->to('/peminjaman')->with('success', 'Status diperbarui!');
    }

    public function kembalikan($id_peminjaman)
    {
        $pinjam = $this->db->table('peminjaman')->where('id_peminjaman', $id_peminjaman)->get()->getRowArray();
        
        $id_buku = $pinjam['id_buku'];
        $buku = $this->buku->find($id_buku);
        $this->buku->update($id_buku, ['tersedia' => $buku['tersedia'] + 1]);

        $tgl_deadline = new \DateTime($pinjam['tanggal_kembali']);
        $tgl_sekarang = new \DateTime(date('Y-m-d'));
        
        if ($tgl_sekarang > $tgl_deadline) {
            $selisih = $tgl_sekarang->diff($tgl_deadline);
            $hari_terlambat = $selisih->days;
            $total_denda = $hari_terlambat * 1000;

            // 3. Pastikan status 'belum bayar' (sudah sinkron dengan View)
           $this->db->table('denda')->insert([
    'id_pengembalian' => $id_peminjaman,
    'jumlah_denda'    => $total_denda,
    'status'          => 'belum bayar' // Pastikan tidak ada kata "denda" di sini
]);
            
            $pesan = "Buku kembali. Terlambat $hari_terlambat hari, denda Rp " . number_format($total_denda);
        } else {
            $pesan = "Buku kembali tepat waktu.";
        }

        $this->db->table('peminjaman')->where('id_peminjaman', $id_peminjaman)->update([
            'status' => 'di kembalikan'
        ]);

        return redirect()->to('/peminjaman')->with('success', $pesan);
    }

    public function list_denda()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->db->table('denda')
            ->select('denda.*, buku.judul, anggota.nama_anggota')
            ->join('peminjaman', 'peminjaman.id_peminjaman = denda.id_pengembalian')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota');

        if ($keyword) {
            $builder->groupStart()
                    ->like('anggota.nama_anggota', $keyword)
                    ->orLike('buku.judul', $keyword)
                    ->groupEnd();
        }

        $data = [
            'title' => 'Data Denda',
            'denda' => $builder->get()->getResultArray()
        ];
        return view('peminjaman/denda', $data);
    }

    public function konfirmasi_bayar($id_denda)
    {
        // 4. Update status jadi 'lunas' (sinkron dengan View)
        $this->db->table('denda')->where('id_denda', $id_denda)->update([
            'status' => 'lunas',
            'tgl_pembayaran' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Denda berhasil diverifikasi Admin!');
    }

    public function delete_denda($id)
    {
        $this->db->table('denda')->where('id_denda', $id)->delete();
        return redirect()->back()->with('success', 'Riwayat denda dihapus!');
    }

    public function delete($id) {
        $this->pinjam->delete($id);
        return redirect()->to('/peminjaman')->with('success', 'Data dihapus');
    }
}