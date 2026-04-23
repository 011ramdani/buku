<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table      = 'log_aktivitas';
    protected $primaryKey = 'id_log';
    
    // Sesuaikan persis dengan database: 'id_users'
    protected $allowedFields = ['id_users', 'pesan', 'status_verifikasi']; 

    public function addLog($id_user, $pesan, $status = 'pending')
    {
        return $this->insert([
            'id_users'          => $id_user, // Di sini juga harus 'id_users'
            'pesan'             => $pesan,
            'status_verifikasi' => $status
        ]);
    }
}