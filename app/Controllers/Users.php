<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new UsersModel(); 
    }

    public function index()
    {
        $data = [
            'title' => 'Data Users',
            'users' => $this->users->findAll()
        ];
        return view('users/index', $data); 
    }

    public function create()
    {
        $data = ['title' => 'Tambah User Baru'];
        return view('users/create', $data);
    }

    public function store()
    {
        $fileFoto = $this->request->getFile('foto');
        
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/users', $namaFoto);
        } else {
            $namaFoto = 'default.png';
        }

        $this->users->insert([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
            'foto'     => $namaFoto
        ]);

        return redirect()->to('/users')->with('success', 'User baru berhasil ditambah!');
    }

    public function edit($id = null)
    {
        $id_target = $id ?? session()->get('id_user') ?? session()->get('id');
        $userData = $this->users->find($id_target);
        
        if (!$userData) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Profile',
            'user'  => $userData 
        ];

        return view('users/edit', $data);
    }

    public function update($id)
    {
        $userLama = $this->users->find($id);
        if (!$userLama) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }
        
        $dataUpdate = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
        ];

        $passBaru = $this->request->getPost('password');
        if (!empty($passBaru)) {
            $dataUpdate['password'] = password_hash($passBaru, PASSWORD_DEFAULT);
        }

        $fileFoto = $this->request->getFile('foto');
        if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('uploads/users', $namaFoto);
            
            if ($userLama['foto'] != 'default.png' && file_exists('uploads/users/' . $userLama['foto'])) {
                @unlink('uploads/users/' . $userLama['foto']);
            }
            $dataUpdate['foto'] = $namaFoto;
        }

        // Jalankan Update
        $this->users->update($id, $dataUpdate);

        // --- UPDATE SESSION BIAR MENU GAK HILANG ---
        $currentSessionId = session()->get('id_user') ?? session()->get('id');
        
        if ($currentSessionId == $id) {
            // Ambil data terbaru dari DB biar Role-nya SAMA PERSIS formatnya
            $userBaru = $this->users->find($id);

            session()->set([
                'id_user'   => $id,
                'nama'      => $userBaru['nama'],
                'foto'      => $userBaru['foto'],
                'role'      => $userBaru['role'], // Ini biar sinkron sama database
                'logged_in' => true
            ]);
        }

        return redirect()->to('/users')->with('success', 'Data berhasil diperbarui!');
    }

    public function delete($id)
    {
        $user = $this->users->find($id);
        if ($user) {
            if ($user['foto'] != 'default.png' && file_exists('uploads/users/' . $user['foto'])) {
                @unlink('uploads/users/' . $user['foto']);
            }
            $this->users->delete($id);
            return redirect()->to('/users')->with('success', 'User berhasil dihapus');
        }
        return redirect()->to('/users')->with('error', 'Data tidak ditemukan');
    }

    public function peminjaman()
    {
        $data = ['title' => 'Daftar Peminjaman'];
        return view('peminjaman/index', $data);
    }

    public function pengembalian()
    {
        $data = ['title' => 'Data Pengembalian'];
        return view('pengembalian/index', $data);
    }

    public function denda()
    {
        $data = ['title' => 'Data Denda'];
        return view('denda/index', $data);
    }
}