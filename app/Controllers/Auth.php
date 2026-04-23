<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        // Jika sudah login, langsung lempar ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function prosesLogin()
{
    $db = \Config\Database::connect();
    $model = new UsersModel();
    
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    // 1. CEK DI TABEL USERS (ADMIN/PETUGAS)
    $user = $model->where('username', $username)->first();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $fixRole = ucfirst(strtolower($user['role']));
            session()->set([
                // Pastikan key session-nya sama untuk semua role agar Log tidak bingung
                'id_users'  => $user['id'], // Pakai 'id' sesuai database
                'username'  => $user['username'],
                'nama'      => $user['nama'],
                'role'      => $fixRole,
                'foto'      => $user['foto'] ?? 'default.png',
                'logged_in' => true
            ]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Password Admin Salah');
        }
    }

    // 2. CEK DI TABEL ANGGOTA
    $anggota = $db->table('anggota')->where('username', $username)->get()->getRowArray();

    if ($anggota) {
        if (password_verify($password, $anggota['password'])) {
            session()->set([
                // Tambahkan 'id_users' di sini juga agar Anggota punya ID saat catat Log
                'id_users'   => $anggota['id_anggota'], 
                'id_anggota' => $anggota['id_anggota'],
                'username'   => $anggota['username'],
                'nama'       => $anggota['nama_anggota'],
                'role'       => 'Anggota',
                'foto'       => 'default.png',
                'logged_in'  => true
            ]);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Password Anggota Salah');
        }
    }

    return redirect()->back()->with('error', 'User tidak ditemukan');
}
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }

    // Fungsi untuk menampilkan halaman register (kalau diakses via URL)
    public function register()
    {
        return view('auth/login'); // Karena form register sudah kita gabung di login.php
    }

    public function save_register()
    {
        $db = \Config\Database::connect();
        
        // Ambil data dari form
        $data = [
            'nis'            => $this->request->getPost('nis'),
            'nama_anggota'   => $this->request->getPost('nama'),
            'username'       => $this->request->getPost('username'),
            'password'       => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'           => 'Anggota', // Pastikan huruf depannya Besar/Kecil sama dengan sistem login
            'tanggal_daftar' => date('Y-m-d'),
            'foto'           => 'default.png'
        ];

        // Eksekusi Simpan
        try {
            $db->table('anggota')->insert($data);
            return redirect()->to('/auth/login')->with('success', 'Pendaftaran berhasil, silakan login!');
        } catch (\Exception $e) {
            // Jika error (misal username kembar)
            return redirect()->back()->with('error', 'Gagal mendaftar: Username atau NIS mungkin sudah ada.');
        }
    }
}