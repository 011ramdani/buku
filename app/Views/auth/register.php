<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0077b6 0%, #90e0ef 100%);
            height: 100vh;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .register-card {
            border: none; border-radius: 20px;
            background: rgba(255, 255, 255, 0.95);
            width: 400px;
        }
        .btn-register {
            background: #0077b6; border: none; border-radius: 10px;
            font-weight: bold; padding: 12px;
        }
    </style>
</head>
<body>
    <div class="card register-card shadow-lg">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h4 class="fw-bold" style="color: #03045e;">Daftar Anggota</h4>
                <p class="text-muted small">Buat akun untuk akses perpustakaan</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger small"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('auth/save_register') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="mb-3">
                    <label class="small fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama asli" required>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username login" required>
                </div>
                <div class="mb-4">
                    <label class="small fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-register w-100 text-white">
                    Daftar Akun <i class="bi bi-check-circle ms-1"></i>
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="<?= base_url('login') ?>" class="small text-decoration-none fw-bold" style="color: #0077b6;">
                    Sudah punya akun? Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>