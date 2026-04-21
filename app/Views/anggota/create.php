<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold fs-5">Tambah Anggota Baru</div>
        <div class="card-body">
            <form action="<?= base_url('anggota/save'); ?>" method="post">
                <?= csrf_field(); ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">NIS</label>
                            <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">Nama Anggota</label>
                            <input type="text" name="nama_anggota" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">No. WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control" placeholder="Contoh: 08123456789">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Untuk login anggota" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password login" required>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap anggota"></textarea>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Data
                    </button>
                    <a href="<?= base_url('anggota'); ?>" class="btn btn-secondary px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>