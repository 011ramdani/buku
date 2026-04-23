<?php

namespace App\Controllers;

use App\Models\LogModel;
use App\Models\BukuModel;
use App\Models\UsersModel;

class Home extends BaseController
{
    public function index()
    {
        // 1. Ambil data session
        $id_login = session()->get('id_users');
        $role     = session()->get('role');
        
        // Cek jika belum login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        // 2. Koneksi Database & Model
        $db         = \Config\Database::connect();
        $logModel   = new LogModel();
        $bukuModel  = new BukuModel();
        $usersModel = new UsersModel();

        // 3. Logika Log Aktivitas
        $cekRole = strtolower($role);
        if ($cekRole == 'admin' || $cekRole == 'petugas') {
            $logs = $logModel->orderBy('id_log', 'DESC')->findAll();
        } else {
            $logs = $logModel->where('id_users', $id_login)
                             ->orderBy('id_log', 'DESC')
                             ->findAll();
        }

        // 4. Siapkan SEMUA variabel
        $data = [
            'title'           => 'Dashboard',
            'logs'            => $logs,
            'total_buku'      => $bukuModel->countAllResults(),
            'total_anggota'   => $db->table('anggota')->countAllResults(),
            'total_pinjam'    => $db->table('peminjaman')->countAllResults(),
            
            // PERBAIKAN DI SINI: Sesuaikan dengan status di database (di pinjam)
            'sirkulasi_aktif' => $db->table('peminjaman')
                                   ->where('status', 'di pinjam') 
                                   ->countAllResults(),
            
            'users'           => $usersModel->findAll(), 
        ];

        // 5. Tampilkan View
        return view('layouts/dashboard', $data);
    }

    public function deleteLog($id)
    {
        $db = \Config\Database::connect();
        $db->table('log_aktivitas')->where('id_log', $id)->delete();
        return redirect()->back()->with('success', 'Log berhasil dihapus!');
    }

    public function clearAllLogs()
    {
        $db = \Config\Database::connect();
        $db->table('log_aktivitas')->emptyTable();
        return redirect()->back()->with('success', 'Semua riwayat telah dibersihkan!');
    }
}