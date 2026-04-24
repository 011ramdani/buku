<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User | Dadan Library</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card-create {
            border: none;
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #495057;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control, .form-select {
            border-radius: 0.75rem;
            padding: 0.6rem 1rem;
            border: 1px solid #dee2e6;
            background-color: #fcfcfd;
        }

        .form-control:focus, .form-select:focus {
            background-color: #fff;
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        }

        .btn-save {
            border-radius: 0.75rem;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }

        .input-group-text {
            border-radius: 0.75rem 0 0 0.75rem;
            background-color: #f8f9fa;
            border-right: none;
        }

        .input-group .form-control {
            border-radius: 0 0.75rem 0.75rem 0;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="text-center mb-4">
                    <div class="bg-primary d-inline-block p-3 rounded-circle shadow-sm mb-3">
                        <i class="bi bi-person-plus-fill text-white fs-3"></i>
                    </div>
                    <h4 class="fw-bold text-dark">Registrasi User Baru</h4>
                    <p class="text-muted small">Silakan lengkapi formulir di bawah ini</p>
                </div>

                <div class="card card-create p-2">
                    <div class="card-body p-4">
                        
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div><?= session()->getFlashdata('error') ?></div>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person text-muted"></i></span>
                                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Alamat Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope text-muted"></i></span>
                                        <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-at text-muted"></i></span>
                                        <input type="text" name="username" class="form-control" placeholder="username" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key text-muted"></i></span>
                                        <input type="password" name="password" class="form-control" placeholder="******" required>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Hak Akses (Role)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shield-lock text-muted"></i></span>
                                        <select name="role" class="form-select" required>
                                            <option value="" selected disabled>Pilih Hak Akses</option>
                                            <option value="admin">Administrator</option>
                                            <option value="petugas">Petugas</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label">Foto Profil</label>
                                    <input type="file" name="foto" class="form-control" accept="image/*">
                                    <div class="form-text text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-info-circle me-1"></i> Opsional. Format JPG/PNG maksimal 2MB.
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-save">
                                    <i class="bi bi-check-circle me-2"></i>Simpan Data User
                                </button>
                                <a href="<?= base_url('login') ?>" class="btn btn-link text-decoration-none text-muted small mt-2">
                                    Sudah punya akun? <span class="text-primary fw-bold">Login di sini</span>
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p class="text-muted small">&copy; 2026 Dadan Library System</p>
                </div>

            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>