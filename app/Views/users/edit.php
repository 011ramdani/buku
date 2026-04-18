<?= $this->extend('layouts/main') ?> <?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-lg-6"> <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-person-gear me-2"></i>Edit Profile User</h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="<?= base_url('users/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= $user['nama'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Role</label>
                            <select name="role" class="form-select">
                                <option value="Admin" <?= $user['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="Petugas" <?= $user['role'] == 'Petugas' ? 'selected' : '' ?>>Petugas</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Profil</label>
                            <input type="file" name="foto" class="form-control mb-2">
                            <div class="text-muted small">Foto saat ini:</div>
                            <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" width="100" class="rounded border mt-2">
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('users') ?>" class="btn btn-secondary px-4">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Update Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>