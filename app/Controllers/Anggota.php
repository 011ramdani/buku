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

    public function save()
{
    $usersModel = new \App\Models\UsersModel();
    $anggotaModel = new \App\Models\AnggotaModel();

    // 1. DAFTARKAN KE TABEL USERS DULU
    $userData = [
        'username' => $this->request->getPost('nis'), // Kita pakai NIS buat username biar gampang
        'password' => password_hash('12345', PASSWORD_DEFAULT), // Password default semua anggota
        'role'     => 'anggota',
        'nama'     => $this->request->getPost('nama_anggota'),
        'foto'     => 'default.png'
    ];
    
    $usersModel->insert($userData);
    
    // 2. AMBIL ID USER YANG BARU SAJA DIBUAT TADI
    $newUserId = $usersModel->insertID(); 

    // 3. MASUKKAN KE TABEL ANGGOTA DENGAN USER_ID OTOMATIS
    $anggotaData = [
        'user_id'      => $newUserId, // <--- INI DIA OTOMATISNYA!
        'nis'          => $this->request->getPost('nis'),
        'nama_anggota' => $this->request->getPost('nama_anggota'),
        'alamat'       => $this->request->getPost('alamat'),
        'no_hp'        => $this->request->getPost('no_hp'),
    ];

    $anggotaModel->insert($anggotaData);

    return redirect()->to('/anggota')->with('pesan', 'Data Berhasil Ditambah & Akun Login Otomatis Dibuat!');
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