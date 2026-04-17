<?php namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use App\Models\UsersModel;

class Peminjaman extends BaseController {
    protected $pinjam, $buku, $user;

    public function __construct() {
        $this->pinjam = new PeminjamanModel();
        $this->buku = new BukuModel();
        $this->user = new UsersModel();
    }

    // READ: Tampil Data
    public function index() {
        $data = [
            'title' => 'Data Peminjaman',
            'peminjaman' => $this->pinjam->getPeminjaman()
        ];
        return view('peminjaman/index', $data);
    }

    // CREATE: Form Tambah
    public function create() {
        $data = [
            'title' => 'Tambah Peminjaman',
            'users' => $this->user->findAll(),
            'buku'  => $this->buku->where('tersedia >', 0)->findAll()
        ];
        return view('peminjaman/create', $data);
    }

    // CREATE: Proses Simpan
    public function store() {
        $id_buku = $this->request->getPost('id_buku');
        $this->pinjam->save([
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'id_buku'         => $id_buku,
            'id_petugas'      => session()->get('id'),
            'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'          => 'di pinjam'
        ]);

        // Kurangi stok buku
        $buku = $this->buku->find($id_buku);
        $this->buku->update($id_buku, ['tersedia' => $buku['tersedia'] - 1]);

        return redirect()->to('/peminjaman')->with('success', 'Data berhasil dipinjam');
    }

    // UPDATE: Form Edit
    public function edit($id) {
        $data = [
            'title' => 'Edit Peminjaman',
            'pinjam' => $this->pinjam->find($id),
            'users' => $this->user->findAll(),
            'buku'  => $this->buku->findAll()
        ];
        return view('peminjaman/edit', $data);
    }

    // UPDATE: Proses Update
    public function update($id) {
        $this->pinjam->update($id, [
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'id_buku'         => $this->request->getPost('id_buku'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'          => $this->request->getPost('status')
        ]);
        return redirect()->to('/peminjaman')->with('success', 'Data diperbarui');
    }

    // DELETE: Hapus Data
    public function delete($id) {
        $this->pinjam->delete($id);
        return redirect()->to('/peminjaman')->with('success', 'Data dihapus');
    }
    
}