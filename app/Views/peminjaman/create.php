
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h3 class="card-title mb-0">Form Tambah Peminjaman</h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('peminjaman/store'); ?>" method="post">
                <?= csrf_field(); ?>

                <div class="mb-3">
                    <label class="form-label">Nama Anggota (Peminjam)</label>
                    <select name="id_anggota" class="form-select" required>
                        <option value="">-- Pilih Anggota --</option>
                        <?php foreach($anggota as $a) : ?>
                            <option value="<?= $a['id_anggota']; ?>">
                                <?= $a['nama_anggota']; ?> (NIS: <?= $a['nis']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <select name="id_buku" class="form-select" required>
                        <option value="">-- Pilih Buku --</option>
                        <?php foreach($buku as $b) : ?>
                            <option value="<?= $b['id_buku']; ?>"><?= $b['judul']; ?> (Stok: <?= $b['tersedia']; ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d'); ?>" readonly>
                        <small class="text-muted text-italic">*Otomatis hari ini</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Harus Kembali</label>
                        <input type="date" name="tanggal_kembali" class="form-control" required>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Pinjaman</button>
                    <a href="<?= base_url('peminjaman'); ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

