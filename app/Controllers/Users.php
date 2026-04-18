<?php

namespace App\Controllers;

use App\Models\UsersModel; // Sesuaikan dengan nama class di file Model kamu

class Users extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new UsersModel(); 
    }

    // --- TAMBAHKAN INI (Fungsi Index) ---
    public function index()
    {
        $data = [
            'title' => 'Data Users',
            'users' => $this->users->findAll()
        ];
        return view('users/index', $data); 
    }

    // --- TAMBAHKAN INI (Fungsi Create) ---
    public function create()
    {
        return view('users/create');
    }

   public function store()
{
    // 1. Ambil file foto
    $fileFoto = $this->request->getFile('foto');
    
    // 2. Cek apakah ada foto yang diupload, kalau nggak ada pakai default
    if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
        $namaFoto = $fileFoto->getRandomName();
        $fileFoto->move('uploads/users', $namaFoto);
    } else {
        $namaFoto = 'default.png'; // Pastikan file default.png ada di folder
    }

    // 3. Koneksi database dan simpan
    $this->db = \Config\Database::connect();
    $this->db->table('users')->insert([
        'nama'     => $this->request->getPost('nama'),
        'email'    => $this->request->getPost('email'),
        'username' => $this->request->getPost('username'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role'     => $this->request->getPost('role'),
        'foto'     => $namaFoto
    ]);

    // 4. Balik ke halaman daftar user
    return redirect()->to('/users')->with('success', 'User baru berhasil ditambah!');
}
    public function edit($id)
    {
        $userData = $this->users->find($id);
        if (!$userData) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan');
        }

        $data = [
            'title' => 'Edit User',
            'user'  => $userData
        ];
        return view('users/edit', $data);
    }

    public function update($id)
{
    $oldUser = $this->users->find($id);
    
    // Jika data lama tidak ketemu, hentikan proses
    if (!$oldUser) {
        return redirect()->to('/users')->with('error', 'User tidak ditemukan');
    }

    $foto = $this->request->getFile('foto');
    $namaFoto = $oldUser['foto'];

    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        $namaFoto = $foto->getRandomName();
        $foto->move(FCPATH . 'uploads/users', $namaFoto);
        if ($oldUser['foto'] && $oldUser['foto'] != 'default.png' && file_exists(FCPATH . 'uploads/users/' . $oldUser['foto'])) {
            @unlink(FCPATH . 'uploads/users/' . $oldUser['foto']);
        }
    }

    // ============== PERBAIKAN DI SINI ==============
    $dataUpdate = [
        'id'       => $id, // GANTI id_user MENJADI id
        'nama'     => $this->request->getPost('nama'),
        'email'    => $this->request->getPost('email'),
        'username' => $this->request->getPost('username'),
        'role'     => $this->request->getPost('role'),
        'foto'     => $namaFoto
    ];
    // ===============================================

    $pass = $this->request->getPost('password');
    if ($pass) {
        $dataUpdate['password'] = password_hash($pass, PASSWORD_DEFAULT);
    }

    // Gunakan update() lebih aman daripada save() untuk proses edit
    $this->users->update($id, $dataUpdate);

    // Update session juga sesuaikan id-nya
    if (session()->get('id') == $id) { 
        session()->set('nama', $dataUpdate['nama']);
        session()->set('foto', $namaFoto);
        session()->set('role', $dataUpdate['role']); // Tambahkan ini agar role di session juga update
    }

    return redirect()->to('/users')->with('success', 'Data berhasil diperbarui!');
}
public function delete($id)
{
    // Cari data dulu untuk hapus foto
    $user = $this->users->find($id);

    if ($user) {
        // Hapus foto jika bukan default
        if ($user['foto'] && $user['foto'] != 'default.png') {
            @unlink(FCPATH . 'uploads/users/' . $user['foto']);
        }
        
        // Hapus data dari database
        $this->users->delete($id);
        return redirect()->to('/users')->with('success', 'User berhasil dihapus');
    }

    return redirect()->to('/users')->with('error', 'Gagal menghapus, data tidak ditemukan');
}
}