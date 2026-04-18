<?php

namespace App\Controllers;

// INI YANG PENTING, BANGDANNNZ! Tambahkan baris-baris ini:
use App\Models\BukuModel;
use App\Models\AnggotaModel;
use App\Models\PeminjamanModel;
use App\Models\UsersModel; 

class Home extends BaseController
{
    public function index(): string
    {
        // 2. Inisialisasi Model
        $bukuModel = new BukuModel();
        $anggotaModel = new AnggotaModel();
        $pinjamModel = new PeminjamanModel();
        $userModel = new UsersModel(); // Baris 19 yang tadi error

        // 3. Masukkan data ke dalam array
        $data = [
            'title'           => 'Dashboard Maldin17App',
            'total_buku'      => $bukuModel->countAllResults(),
            'total_anggota'   => $anggotaModel->countAllResults(),
            'sirkulasi_aktif' => $pinjamModel->where('status', 'di pinjam')->countAllResults(),
            'total_pinjam'    => $pinjamModel->countAllResults(),
            'users'           => $userModel->findAll(),
        ];

        return view('layouts/dashboard', $data);
    }
}