<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Anggota extends Controller
{
    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

   public function index() {
    $data = [
        'title'   => 'Data Anggota',
        // Ambil semua kolom termasuk username
        'anggota' => $this->db->table('anggota')->select('*')->get()->getResultArray()
    ];
    return view('anggota/index', $data);
}
    public function create() {
        $data = ['title' => 'Tambah Anggota Baru'];
        return view('anggota/create', $data);
    }

    // --- INI YANG HARUS DIGANTI JADI 'save' ---
 public function save() {
    $data = [
        'nis'          => $this->request->getPost('nis'),
        'nama_anggota' => $this->request->getPost('nama_anggota'),
        'username'     => $this->request->getPost('username'), // INI HARUS ADA
        'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // INI JUGA
        'no_wa'        => $this->request->getPost('no_wa'),
        'alamat'       => $this->request->getPost('alamat'),
        'role'         => 'anggota'
    ];
    $this->db->table('anggota')->insert($data);
    return redirect()->to('/anggota')->with('success', 'Data berhasil disimpan!');
}
// Halaman form edit anggota
    public function edit($id)
    {
        $data = [
            'title'   => 'Edit Data Anggota',
            'anggota' => $this->db->table('anggota')->where('id_anggota', $id)->get()->getRowArray()
        ];

        if (!$data['anggota']) {
            return redirect()->to('/anggota')->with('error', 'Data anggota tidak ditemukan.');
        }

        return view('anggota/edit', $data);
    }

    // Proses simpan perubahan data anggota
    public function update($id)
    {
        $dataUpdate = [
            'nama_anggota' => $this->request->getPost('nama_anggota'),
            'username'     => $this->request->getPost('username'),
        ];

        // Jika password diisi, maka update passwordnya
        $passBaru = $this->request->getPost('password');
        if (!empty($passBaru)) {
            $dataUpdate['password'] = password_hash($passBaru, PASSWORD_DEFAULT);
        }

        $this->db->table('anggota')->where('id_anggota', $id)->update($dataUpdate);
        return redirect()->to('/anggota')->with('success', 'Data anggota berhasil diperbarui!');
    }
    public function profile()
{
    $db = \Config\Database::connect();
    // Ambil ID dari session yang login
    $id = session()->get('id_anggota');

    $data = [
        'title'   => 'Profil Saya',
        'anggota' => $db->table('anggota')->where('id_anggota', $id)->get()->getRowArray()
    ];

    // Kita arahkan ke view profil
    return view('anggota/profile', $data);
}

public function update_profile()
{
    $db = \Config\Database::connect();
    $id = session()->get('id_anggota');
    $fileFoto = $this->request->getFile('foto');

    $dataUpdate = [
        'nama_anggota' => $this->request->getPost('nama'),
        'username'     => $this->request->getPost('username'),
    ];

    if ($fileFoto && $fileFoto->isValid() && !$fileFoto->hasMoved()) {
        $namaFoto = $fileFoto->getRandomName();
        $fileFoto->move('uploads/users/', $namaFoto); // Pindahkan ke folder users
        $dataUpdate['foto'] = $namaFoto; // Simpan ke kolom 'foto'
        
        session()->set('foto', $namaFoto); // Update session biar langsung berubah
    }

    $db->table('anggota')->where('id_anggota', $id)->update($dataUpdate);

    return redirect()->to(base_url('profile'))->with('success', 'Profil Berhasil Diupdate');
}
    public function delete($id) {
        $this->db->table('anggota')->where('id_anggota', $id)->delete();
        return redirect()->to('/anggota')->with('success', 'Anggota berhasil dihapus!');
    }
}