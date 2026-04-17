<?php namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use App\Models\UserModel;

class Peminjaman extends BaseController {
    protected $pinjam, $buku, $user;

    public function __construct() {
        $this->pinjam = new PeminjamanModel();
        $this->buku = new BukuModel();
        $this->user = new UserModel();
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
            'title' => 'Tambah Peminjaman',
            'users' => $this->user->findAll(),
            'buku'  => $this->buku->where('stok >', 0)->findAll() // Hanya buku yang ada stok
        ];
        return view('peminjaman/create', $data);
    }

    public function store() {
        $id_buku = $this->request->getPost('id_buku');

        // 1. Simpan data peminjaman
        $this->pinjam->save([
            'id_user'        => $this->request->getPost('id_user'),
            'id_buku'        => $id_buku,
            'tanggal_pinjam' => date('Y-m-d'),
            'tanggal_kembali'=> $this->request->getPost('tanggal_kembali'),
            'status'         => 'dipinjam'
        ]);

        // 2. Kurangi stok buku
        $bukuLama = $this->buku->find($id_buku);
        $this->buku->update($id_buku, ['stok' => $bukuLama['stok'] - 1]);

        return redirect()->to('/peminjaman')->with('success', 'Buku berhasil dipinjam!');
    }
}