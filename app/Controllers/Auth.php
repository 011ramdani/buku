<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        // Jika sudah login, lempar sesuai role
        if (session()->get('logged_in')) {
            if (session()->get('role') == 'Anggota') {
                return redirect()->to('/dashboard');
            }
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
                    'id_user'   => $user['id_user'] ?? $user['id'],
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

        // 2. CEK DI TABEL ANGGOTA (KALAU DI USERS GAK ADA)
        $anggota = $db->table('anggota')->where('username', $username)->get()->getRowArray();

        if ($anggota) {
            if (password_verify($password, $anggota['password'])) {
                session()->set([
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

        // 3. JIKA SEMUA GAGAL
        return redirect()->back()->with('error', 'User tidak ditemukan');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
    // Fungsi untuk menampilkan halaman pendaftaran
    public function register()
    {
        // Kalau sudah login, tendang ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Daftar Anggota Baru | Dadan Library'
        ];
        return view('auth/register', $data);
    }

    // Fungsi untuk memproses penyimpanan data pendaftaran
    public function save_register()
    {
        $db = \Config\Database::connect();
        
        // Ambil data dari form
        $nama     = $this->request->getPost('nama');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi sederhana: Cek apakah username sudah dipakai di tabel anggota
        $cek = $db->table('anggota')->where('username', $username)->get()->getRow();
        
        if ($cek) {
            return redirect()->back()->with('error', 'Username sudah terdaftar, gunakan yang lain!');
        }

        // Siapkan data untuk disimpan ke tabel anggota
        $data = [
            'nama_anggota' => $nama,
            'username'     => $username,
            // Password di-hash biar aman (encrypted)
            'password'     => password_hash($password, PASSWORD_DEFAULT),
            'status'       => 'Aktif' // Default anggota baru langsung aktif
        ];

        // Simpan ke tabel anggota
        $db->table('anggota')->insert($data);

        // Kasih notif sukses dan balik ke halaman login
        return redirect()->to('/login')->with('success', 'Pendaftaran Berhasil! Silakan Login.');
    }
}