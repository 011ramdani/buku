<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h3>Detail Buku</h3>
    <hr>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <?php 
                        $namaFoto = !empty($buku['cover']) ? $buku['cover'] : 'default.jpg';
                        $path = 'assets/img/buku/' . $namaFoto;
                    ?>
                    <img src="<?= base_url($path) ?>" class="img-fluid rounded shadow" alt="Cover Buku" style="max-height: 400px;">
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="150">ID Buku</th>
                    <td><?= $buku['id_buku'] ?></td>
                </tr>
                <tr>
                    <th>Judul</th>
                    <td><strong><?= $buku['judul'] ?></strong></td>
                </tr>
                <tr>
                    <th>ISBN</th>
                    <td><?= $buku['isbn'] ?></td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td><?= $buku['nama_kategori'] ?? '-' ?></td>
                </tr>
                <tr>
                    <th>Penulis</th>
                    <td><?= $buku['nama_penulis'] ?? '-' ?></td>
                </tr>
                <tr>
                    <th>Penerbit</th>
                    <td><?= $buku['nama_penerbit'] ?? '-' ?></td>
                </tr>
                <tr>
                    <th>Lokasi Rak</th>
                    <td>
                        <span class="badge bg-info text-dark">
                            <?= ($buku['nama_rak'] ?? '-') . " ( " . ($buku['lokasi'] ?? '-') . " )" ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Tahun Terbit</th>
                    <td><?= $buku['tahun_terbit'] ?></td>
                </tr>
                <tr>
                    <th>Stok</th>
                    <td>Tersedia: <?= $buku['tersedia'] ?> / Total: <?= $buku['jumlah'] ?></td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td><?= nl2br($buku['deskripsi']) ?></td>
                </tr>
            </table>

            <div class="mt-3">
                <a href="<?= base_url('buku') ?>" class="btn btn-secondary">Kembali</a>
                <a href="<?= base_url('buku/wa/' . $buku['id_buku']) ?>" target="_blank" class="btn btn-success">
                    <i class="fab fa-whatsapp"></i> Kirim WA
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>