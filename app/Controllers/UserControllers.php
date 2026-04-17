<?php 

namespace App\Controllers;

// Jangan lupa panggil Modelnya di sini
use App\Models\UserModel; 

class UserController extends BaseController {

    public function index() {
        $model = new UserModel();
        
        // Logika SEARCH: mengambil input dari search bar
        $cari = $this->request->getVar('keyword');
        
        if ($cari) {
            // Jika ada kata kunci, cari nama yang mirip
            $data['users'] = $model->like('nama', $cari)->findAll();
        } else {
            // Jika tidak ada, tampilkan semua
            $data['users'] = $model->findAll();
        }

        return view('user/index', $data);
    }
}