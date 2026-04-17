<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    // WAJIB tambahkan field yang ingin kamu simpan/update di sini
    protected $allowedFields = ['username', 'password', 'role', 'nama', 'email', 'foto']; 

    public function getUsersByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function searchPetugas($keyword) {
        return $this->where('role', 'petugas')
                    ->like('username', $keyword);
    }
}