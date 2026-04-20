
<div class="container mt-4 mb-5">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h3 class="card-title mb-0">Edit Data Peminjaman</h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('peminjaman/update/' . $pinjam['id_peminjaman']); ?>" method="post">
                <?= csrf_field(); ?>

                <input type="hidden" name="id_peminjaman" value="<?= $pinjam['id_peminjaman']; ?>">

                <div class="mb-3">
                    <label class="form-label">Nama Anggota (Peminjam)</label>
                    <select name="id_anggota" class="form-select" required>
                        <?php foreach($anggota as $a) : ?>
                            <option value="<?= $a['id_anggota']; ?>" <?= ($a['id_anggota'] == $pinjam['id_anggota']) ? 'selected' : ''; ?>>
                                <?= $a['nama_anggota']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <select name="id_buku" class="form-select" required>
                        <?php foreach($buku as $b) : ?>
                            <option value="<?= $b['id_buku']; ?>" <?= ($b['id_buku'] == $pinjam['id_buku']) ? 'selected' : ''; ?>>
                                <?= $b['judul']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" value="<?= $pinjam['tanggal_pinjam']; ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" class="form-control" value="<?= $pinjam['tanggal_kembali']; ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Peminjaman</label>
                    <select name="status" class="form-select">
                        <option value="diajukan" <?= ($pinjam['status'] == 'diajukan') ? 'selected' : ''; ?>>Diajukan</option>
                        <option value="di pinjam" <?= ($pinjam['status'] == 'di pinjam') ? 'selected' : ''; ?>>Di Pinjam</option>
                        <option value="di kembalikan" <?= ($pinjam['status'] == 'di kembalikan') ? 'selected' : ''; ?>>Di Kembalikan</option>
                    </select>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary px-4">Update Data</button>
                    <a href="<?= base_url('peminjaman'); ?>" class="btn btn-secondary px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>