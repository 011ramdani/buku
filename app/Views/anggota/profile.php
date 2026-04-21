<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-person-gear me-2"></i>Pengaturan Profil</h5>
            </div>
            <div class="card-body p-4">
              <form action="<?= base_url('anggota/update_profile') ?>" method="post" enctype="multipart/form-data">
                    <div class="text-center mb-4">
                        <?php $foto_path = session('foto') ?: 'default.png'; ?>
                        <img src="<?= base_url('uploads/users/' . $foto_path) ?>" 
                             class="rounded-circle border border-4 border-primary-subtle shadow-sm object-fit-cover" 
                             width="120" height="120"
                             onerror="this.src='https://ui-avatars.com/api/?name=<?= session('nama') ?>&background=0D6EFD&color=fff'">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= $anggota['nama_anggota'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= $anggota['username'] ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Ganti Foto Profil</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <div class="form-text text-muted">Format: JPG, PNG (Maks. 2MB)</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary shadow-sm">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>