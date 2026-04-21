<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\KategoriModel;
use App\Models\PenulisModel;
use App\Models\PenerbitModel;
use App\Models\RakModel;

class Buku extends BaseController
{
    protected $bukuModel;
    protected $kategoriModel;
    protected $penulisModel;
    protected $penerbitModel;
    protected $rakModel;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->bukuModel     = new BukuModel();
        $this->kategoriModel = new KategoriModel();
        $this->penulisModel  = new PenulisModel();
        $this->penerbitModel = new PenerbitModel();
        $this->rakModel      = new RakModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->db->table('buku');
        
        // PENTING: Jika di View pakai $b['gambar'], maka kita alias-kan 'cover' AS 'gambar'
        $builder->select('buku.*, buku.cover as gambar, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit, rak.nama_rak, rak.lokasi');
        $builder->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left');
        $builder->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left');
        $builder->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left');
        $builder->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left');
        $builder->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');

        if ($keyword) {
            $builder->like('buku.judul', $keyword)
                    ->orLike('penulis.nama_penulis', $keyword);
        }

        $data['buku'] = $builder->get()->getResultArray();
        return view('buku/index', $data);
    }

    public function store()
    {
        $file = $this->request->getFile('gambar'); 
        $namaFile = 'default.jpg';

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('assets/img/buku/', $namaFile);
        }

        $this->bukuModel->insert([
            'isbn'         => $this->request->getPost('isbn'),
            'judul'        => $this->request->getPost('judul'),
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'id_penulis'   => $this->request->getPost('id_penulis'),
            'id_penerbit'  => $this->request->getPost('id_penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'jumlah'       => $this->request->getPost('jumlah'),
            'tersedia'     => $this->request->getPost('tersedia'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'cover'        => $namaFile 
        ]);

        $id_buku = $this->bukuModel->getInsertID();
        $this->db->table('buku_rak')->insert([
            'id_buku' => $id_buku,
            'id_rak'  => $this->request->getPost('id_rak')
        ]);

        return redirect()->to('/buku')->with('success', 'Buku berhasil ditambah');
    }

    public function update($id)
    {
        $bukuLama = $this->bukuModel->find($id);
        $file = $this->request->getFile('gambar'); 
        $namaFile = $bukuLama['cover']; 

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('assets/img/buku/', $namaFile);

            if (!empty($bukuLama['cover']) && $bukuLama['cover'] != 'default.jpg' && file_exists('assets/img/buku/' . $bukuLama['cover'])) {
                unlink('assets/img/buku/' . $bukuLama['cover']);
            }
        }

        $this->bukuModel->update($id, [
            'isbn'         => $this->request->getPost('isbn'),
            'judul'        => $this->request->getPost('judul'),
            'id_kategori'  => $this->request->getPost('id_kategori'),
            'id_penulis'   => $this->request->getPost('id_penulis'),
            'id_penerbit'  => $this->request->getPost('id_penerbit'),
            'tahun_terbit' => $this->request->getPost('tahun_terbit'),
            'jumlah'       => $this->request->getPost('jumlah'),
            'tersedia'     => $this->request->getPost('tersedia'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'cover'        => $namaFile 
        ]);

        // Update Rak
        $this->db->table('buku_rak')
                 ->where('id_buku', $id)
                 ->update(['id_rak' => $this->request->getPost('id_rak')]);

        return redirect()->to('/buku')->with('success', 'Data berhasil diupdate');
    }

    public function detail($id)
    {
        $builder = $this->db->table('buku');
        // Tambahkan alias cover AS gambar di sini juga
        $builder->select('buku.*, buku.cover as gambar, kategori.nama_kategori, penulis.nama_penulis, penerbit.nama_penerbit, rak.nama_rak, rak.lokasi');
        $builder->join('kategori', 'kategori.id_kategori = buku.id_kategori', 'left');
        $builder->join('penulis', 'penulis.id_penulis = buku.id_penulis', 'left');
        $builder->join('penerbit', 'penerbit.id_penerbit = buku.id_penerbit', 'left');
        $builder->join('buku_rak', 'buku_rak.id_buku = buku.id_buku', 'left');
        $builder->join('rak', 'rak.id_rak = buku_rak.id_rak', 'left');
        $builder->where('buku.id_buku', $id);

        $data['buku'] = $builder->get()->getRowArray();
        return view('buku/detail', $data);
    }

    public function wa($id)
    {
        $buku = $this->bukuModel->find($id);
        if ($buku) {
            $nomor_admin = "628123456789"; // Sesuaikan nomor WA Abang
            $pesan = "Halo Admin Dadan Library, saya mau tanya tentang buku: " . $buku['judul'] . " (ISBN: " . $buku['isbn'] . ")";
            return redirect()->to("https://wa.me/" . $nomor_admin . "?text=" . urlencode($pesan));
        }
        return redirect()->to('/buku')->with('error', 'Buku tidak ditemukan.');
    }
    
    // Create, Edit, dan Delete tetap seperti punya Abang
    public function create() { /* ... kode abang sudah benar ... */ }
    public function edit($id) { /* ... kode abang sudah benar ... */ }
    public function delete($id) { /* ... kode abang sudah benar ... */ }
}