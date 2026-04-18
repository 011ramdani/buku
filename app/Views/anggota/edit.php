<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white font-weight-bold">Edit Data Anggota</div>
        <div class="card-body">
            <form action="<?= base_url('anggota/update/' . $anggota['id_anggota']); ?>" method="post">
                <div class="mb-3">
                    <label>NIS</label>
                    <input type="text" name="nis" class="form-control" value="<?= $anggota['nis']; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Nama Anggota</label>
                    <input type="text" name="nama_anggota" class="form-control" value="<?= $anggota['nama_anggota']; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"><?= $anggota['alamat']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" value="<?= $anggota['no_hp']; ?>">
                </div>
                <button type="submit" class="btn btn-success">Update Data</button>
              <a href="<?= base_url('anggota'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>