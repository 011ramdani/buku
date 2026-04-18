<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    protected $anggotaModel;

    public function __construct() {
        $this->anggotaModel = new AnggotaModel();
    }

    public function index() {
        $data = [
            'title'   => 'Daftar Anggota',
            'anggota' => $this->anggotaModel->findAll()
        ];
        return view('anggota/index', $data);
    }

    public function create() {
        return view('anggota/create', ['title' => 'Tambah Anggota']);
    }

    public function save() {
        $this->anggotaModel->save([
            'nis'          => $this->request->getPost('nis'),
            'nama_anggota' => $this->request->getPost('nama_anggota'),
            'alamat'       => $this->request->getPost('alamat'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'tanggal_daftar' => date('Y-m-d')
        ]);
        return redirect()->to('/anggota');
    }

    public function edit($id) {
        $data = [
            'title'   => 'Edit Anggota',
            'anggota' => $this->anggotaModel->find($id)
        ];
        return view('anggota/edit', $data);
    }

    public function update($id) {
        $this->anggotaModel->update($id, [
            'nis'          => $this->request->getPost('nis'),
            'nama_anggota' => $this->request->getPost('nama_anggota'),
            'alamat'       => $this->request->getPost('alamat'),
            'no_hp'        => $this->request->getPost('no_hp')
        ]);
        return redirect()->to('/anggota');
    }

    public function delete($id) {
        $this->anggotaModel->delete($id);
        return redirect()->to('/anggota');
    }
}