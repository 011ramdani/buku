<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        // Kalau sudah login, jangan kasih masuk ke halaman login lagi
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function prosesLogin()
    {
        $session = session();
        $usersModel = new UsersModel();
        $db = \Config\Database::connect(); // Kita butuh koneksi DB buat cek tabel anggota

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $users = $usersModel->getUsersByUsername($username);

        if ($users) {
            if (password_verify($password, $users['password'])) {
                
                // --- BAGIAN BARU: CARI ID_ANGGOTA JIKA DIA ANGGOTA ---
                $id_anggota = null;
                if ($users['role'] == 'anggota') {
                    $query = $db->table('anggota')->getWhere(['user_id' => $users['id']])->getRowArray();
                    if ($query) {
                        $id_anggota = $query['id_anggota'];
                    }
                }
                // -----------------------------------------------------

                $session->set([
                    'id'         => $users['id'],
                    'id_anggota' => $id_anggota, // Simpan ID Anggota di sini!
                    'nama'       => $users['nama'],
                    'email'      => $users['email'],
                    'username'   => $users['username'],
                    'role'       => $users['role'],
                    'foto'       => $users['foto'],
                    'logged_in'  => true
                ]);

                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('salahpw', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Nama tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}