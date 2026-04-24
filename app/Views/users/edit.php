<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark mb-1">Edit Profil Pengguna</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item small"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item small"><a href="<?= base_url('users') ?>" class="text-decoration-none">Users</a></li>
                    <li class="breadcrumb-item small active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="bi bi-person-gear text-primary fs-5"></i>
                        </div>
                        <h6 class="mb-0 fw-bold">Formulir Pembaruan Data</h6>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <?php 
                        // Pastikan ID yang diambil sesuai dengan kolom di database (id atau id_user)
                        $id_user = $user['id'] ?? $user['id_user']; 
                    ?>

                    <form action="<?= base_url('users/update/' . $id_user) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                    <input type="text" name="nama" class="form-control bg-light border-start-0" value="<?= old('nama', $user['nama'] ?? '') ?>" placeholder="Nama lengkap..." required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control bg-light border-start-0" value="<?= old('email', $user['email'] ?? '') ?>" placeholder="email@contoh.com" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-at text-muted"></i></span>
                                    <input type="text" name="username" class="form-control bg-light border-start-0" value="<?= old('username', $user['username'] ?? '') ?>" placeholder="username_login" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Ganti Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control bg-light border-start-0" placeholder="Isi jika ingin ganti">
                                </div>
                                <div class="form-text" style="font-size: 0.75rem;">
                                    <i class="bi bi-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengubah password.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Hak Akses (Role)</label>
                                <select name="role" class="form-select bg-light" required>
                                    <?php $role_sekarang = strtolower($user['role'] ?? ''); ?>
                                    <option value="Admin" <?= ($role_sekarang == 'admin') ? 'selected' : '' ?>>Administrator</option>
                                    <option value="Petugas" <?= ($role_sekarang == 'petugas') ? 'selected' : '' ?>>Petugas Perpustakaan</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Foto Profil</label>
                                <input type="file" name="foto" class="form-control bg-light" accept="image/*">
                            </div>
                        </div>

                        <div class="bg-light p-3 rounded-3 mt-2 mb-4 d-flex align-items-center">
                            <div class="me-3">
                                <?php 
                                    $namaFoto = $user['foto'] ?? 'default.png';
                                    $pathFoto = 'uploads/users/' . $namaFoto;
                                    $urlFoto = (file_exists($pathFoto) && $namaFoto != '') ? base_url($pathFoto) : base_url('uploads/users/default.png');
                                ?>
                                <img src="<?= $urlFoto ?>" width="80" height="80" class="rounded-circle shadow-sm border border-3 border-white object-fit-cover">
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold small">Preview Foto Saat Ini</h6>
                                <p class="text-muted small mb-0">Ukuran maksimal 2MB (JPG, PNG, JPEG)</p>
                            </div>
                        </div>

                        <hr class="border-light my-4">
                        
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= base_url('users') ?>" class="btn btn-light rounded-pill px-4">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">
                <div class="card-body p-4">
                    <h6 class="fw-bold"><i class="bi bi-lightbulb me-2"></i>Tips Keamanan</h6>
                    <ul class="small mb-0 opacity-75 mt-3 ps-3">
                        <li class="mb-2">Gunakan kombinasi huruf dan angka untuk password yang lebih kuat.</li>
                        <li class="mb-2">Pastikan email aktif untuk keperluan notifikasi sistem.</li>
                        <li>Gunakan foto formal jika akun ini adalah akun Petugas.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .object-fit-cover { object-fit: cover; }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        background-color: #fff !important;
    }
    .input-group-text { border: 1px solid #dee2e6; }
</style>

<?= $this->endSection() ?>