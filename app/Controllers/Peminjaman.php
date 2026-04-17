<?php namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use App\Models\UsersModel;
use App\Models\AnggotaModel; // 1. Tambahkan ini

class Peminjaman extends BaseController {
    protected $pinjam, $buku, $user, $anggota; // 2. Tambahkan variabel anggota

    public function __construct() {
        $this->pinjam = new PeminjamanModel();
        $this->buku = new BukuModel();
        $this->user = new UsersModel();
        $this->anggota = new AnggotaModel(); // 3. Inisialisasi AnggotaModel
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
            'title'   => 'Tambah Peminjaman',
            'anggota' => $this->anggota->findAll(), // Mengambil data dari tabel anggota (Adut dkk)
            'buku'    => $this->buku->where('tersedia >', 0)->findAll()
        ];
        return view('peminjaman/create', $data);
    }

    // CREATE: Proses Simpan
    public function store() {
        $id_buku = $this->request->getPost('id_buku');
        $this->pinjam->save([
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'id_buku'         => $id_buku,
            'id_petugas'      => session()->get('id'), // Tetap dari session user (Admin)
            'tanggal_pinjam'  => date('Y-m-d'), // Otomatis tanggal hari ini
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
        'title'   => 'Edit Peminjaman',
        'pinjam'  => $this->pinjam->find($id),
        'anggota' => $this->anggota->findAll(), // Pastikan ini anggota
        'buku'    => $this->buku->findAll()
    ];
    return view('peminjaman/edit', $data);
}

    // UPDATE: Proses Update
    public function update($id) {
    // 1. Ambil data peminjaman lama untuk tahu ID Bukunya
    $dataLama = $this->pinjam->find($id);
    $statusBaru = $this->request->getPost('status');
    $id_buku = $dataLama['id_buku'];

    // 2. Jika status berubah dari 'di pinjam' ke 'di kembalikan'
    if ($dataLama['status'] == 'di pinjam' && $statusBaru == 'di kembalikan') {
        // Ambil data buku
        $buku = $this->buku->find($id_buku);
        // Tambah stok buku +1
        $this->buku->update($id_buku, [
            'tersedia' => $buku['tersedia'] + 1
        ]);
    } 
    // 3. Tambahan: Jika status diubah balik dari 'di kembalikan' ke 'di pinjam' (salah input)
    elseif ($dataLama['status'] == 'di kembalikan' && $statusBaru == 'di pinjam') {
        $buku = $this->buku->find($id_buku);
        $this->buku->update($id_buku, [
            'tersedia' => $buku['tersedia'] - 1
        ]);
    }

    // 4. Update data peminjaman
    $this->pinjam->update($id, [
        'id_anggota'      => $this->request->getPost('id_anggota'),
        'id_buku'         => $this->request->getPost('id_buku'),
        'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
        'status'          => $statusBaru
    ]);

    return redirect()->to('/peminjaman')->with('success', 'Status peminjaman berhasil diperbarui dan stok buku telah disesuaikan');
}

    // DELETE: Hapus Data
    public function delete($id) {
        $this->pinjam->delete($id);
        return redirect()->to('/peminjaman')->with('success', 'Data dihapus');
    }
}