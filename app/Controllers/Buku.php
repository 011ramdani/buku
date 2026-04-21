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
        $data['title'] = 'Daftar Buku';
        return view('buku/index', $data);
    }

    public function create()
    {
        $data = [
            'title'    => 'Tambah Buku',
            'kategori' => $this->kategoriModel->findAll(),
            'penulis'  => $this->penulisModel->findAll(),
            'penerbit' => $this->penerbitModel->findAll(),
            'rak'      => $this->rakModel->findAll(),
        ];
        return view('buku/create', $data);
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

    public function edit($id)
    {
        $data = [
            'title'    => 'Edit Data Buku',
            'buku'     => $this->bukuModel->find($id),
            'kategori' => $this->kategoriModel->findAll(),
            'penulis'  => $this->penulisModel->findAll(),
            'penerbit' => $this->penerbitModel->findAll(),
            'rak'      => $this->rakModel->findAll(),
        ];

        // Ambil ID rak saat ini
        $data['current_rak'] = $this->db->table('buku_rak')->where('id_buku', $id)->get()->getRowArray();

        if (empty($data['buku'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data buku tidak ditemukan.');
        }

        return view('buku/edit', $data);
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

    public function delete($id)
    {
        $buku = $this->bukuModel->find($id);
        if ($buku['cover'] != 'default.jpg' && file_exists('assets/img/buku/' . $buku['cover'])) {
            unlink('assets/img/buku/' . $buku['cover']);
        }
        
        $this->db->table('buku_rak')->where('id_buku', $id)->delete();
        $this->bukuModel->delete($id);
        return redirect()->to('/buku')->with('success', 'Buku berhasil dihapus!');
    }

    public function detail($id)
    {
        $builder = $this->db->table('buku');
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
}