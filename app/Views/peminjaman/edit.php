<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold text-dark mb-0">Edit Transaksi Peminjaman</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?= base_url('peminjaman/update/' . $peminjaman['id_peminjaman']); ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Anggota (Peminjam)</label>
                            <select name="id_anggota" class="form-select" required>
                                <option value="">-- Pilih Anggota --</option>
                                <?php foreach ($anggota as $a) : ?>
                                    <option value="<?= $a['id_anggota'] ?>" <?= ($a['id_anggota'] == $peminjaman['id_anggota']) ? 'selected' : '' ?>>
                                        <?= $a['nama_anggota'] ?> (<?= $a['id_anggota'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Buku</label>
                            <select name="id_buku" class="form-select" required>
                                <option value="">-- Pilih Buku --</option>
                                <?php foreach ($buku as $b) : ?>
                                    <option value="<?= $b['id_buku'] ?>" <?= ($b['id_buku'] == $peminjaman['id_buku']) ? 'selected' : '' ?>>
                                        <?= $b['judul'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" class="form-control" value="<?= $peminjaman['tanggal_pinjam'] ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Batas Kembali</label>
                                <input type="date" name="tanggal_kembali" class="form-control" value="<?= $peminjaman['tanggal_kembali'] ?>" required>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('peminjaman') ?>" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>