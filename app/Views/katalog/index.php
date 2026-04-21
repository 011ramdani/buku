<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h4>Selamat Datang di Katalog Buku</h4>
    <p>Halo, <?= session()->get('nama'); ?>! Kamu login sebagai Anggota.</p>
</div>
<?= $this->endSection() ?>