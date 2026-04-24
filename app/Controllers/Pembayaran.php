<?php

namespace App\Controllers;

use App\Models\DendaModel;
use App\Models\LogModel;

class Pembayaran extends BaseController
{
    protected $dendaModel;
    protected $log;

    public function __construct()
    {
        $this->dendaModel = new DendaModel();
        $this->log = new LogModel();
    }

    // Fungsi Anggota untuk Upload Bukti DANA
    public function upload_dana()
    {
        $id_denda = $this->request->getPost('id_denda');
        $fileBukti = $this->request->getFile('bukti_bayar');

        if ($fileBukti->isValid() && !$fileBukti->hasMoved()) {
            $namaFile = $fileBukti->getRandomName();
            $fileBukti->move('assets/uploads/bukti_dana', $namaFile);

            $this->dendaModel->update($id_denda, [
                'bukti_bayar'       => $namaFile,
                'metode_pembayaran' => 'DANA'
            ]);

            return redirect()->back()->with('success', 'Bukti transfer berhasil dikirim! Menunggu verifikasi admin.');
        }
        return redirect()->back()->with('error', 'Gagal upload bukti bayar.');
    }

    // Fungsi Admin untuk Verifikasi (Lunas)
    public function verifikasi($id_denda)
{
    $dataDenda = $this->dendaModel->find($id_denda);
    
    // 1. Update status denda jadi lunas
    $this->dendaModel->update($id_denda, [
        'status'         => 'lunas',
        'tgl_pembayaran' => date('Y-m-d H:i:s')
    ]);

    // 2. Update status di tabel pengembalian (Sekarang pakai kolom 'status')
    $db = \Config\Database::connect();
    $db->table('pengembalian')
       ->where('id_pengembalian', $dataDenda['id_pengembalian'])
       ->update(['status' => 'Selesai']); 

    return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi!');
}
}