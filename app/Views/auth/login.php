<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register | Dadan Library</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0077b6 0%, #90e0ef 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.95);
            transition: all 0.3s ease;
        }

        .login-header {
            background: transparent;
            border-bottom: none;
            padding-top: 30px;
        }

        .icon-box {
            width: 65px;
            height: 65px;
            background: #caf0f8;
            color: #0077b6;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 28px;
            transform: rotate(-10deg);
        }

        .form-label {
            color: #023e8a;
            font-weight: 600;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 12px;
            border: 1px solid #ade8f4;
            background-color: #f8fdff;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(0, 180, 216, 0.15);
            border-color: #00b4d8;
        }

        .input-group-text {
            border-radius: 10px 0 0 10px !important;
            background-color: #f8fdff;
            border: 1px solid #ade8f4;
            color: #0077b6;
        }

        .btn-login {
            background: #0077b6;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.4s;
        }

        .btn-login:hover {
            background: #023e8a;
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0, 119, 182, 0.3);
        }

        .register-link {
            color: #0077b6;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .register-link:hover {
            color: #023e8a;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center">
        <div class="card login-card shadow-lg" style="width: 420px;">
            
            <div id="box-login">
                <div class="card-header login-header text-center">
                    <div class="icon-box shadow-sm">
                        <i class="bi bi-bookmarks-fill"></i>
                    </div>
                    <h3 class="fw-bold" style="color: #03045e;">DADAN 01</h3>
                    <p class="text-muted small">Library Management System</p>
                </div>

                <div class="card-body px-4 pb-4">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger border-0 small shadow-sm mb-3">
                            <i class="bi bi-x-octagon-fill me-2"></i><?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success border-0 small shadow-sm mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/proses-login') ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label small">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" name="username" class="form-control border-start-0" placeholder="Username Anda" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                <input type="password" name="password" class="form-control border-start-0" placeholder="Password Anda" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-login w-100 mb-3 text-white">
                            Sign In <i class="bi bi-arrow-right-short ms-1"></i>
                        </button>
                    </form>

                    <div class="text-center">
                        <p class="text-muted small mb-0">Belum punya akun anggota?</p>
                        <a onclick="showRegister()" class="register-link small">Daftar Akun Baru</a>
                    </div>
                    <a href="<?= base_url('restore') ?>" class="btn btn-outline-danger btn-sm">
<i class="bi bi-database"></i> Restore DB
</a>
                </div>
            </div>

            <div id="box-register" style="display: none;">
                <div class="card-header login-header text-center">
                    <div class="icon-box shadow-sm" style="background: #e9edc9; color: #606c38;">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <h3 class="fw-bold" style="color: #03045e;">JOIN US</h3>
                    <p class="text-muted small">Daftar Anggota Baru</p>
                </div>

                <div class="card-body px-4 pb-4">
                    <form action="<?= base_url('auth/save_register') ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-2">
                            <label class="form-label small">NIS</label>
                            <input type="number" name="nis" class="form-control" placeholder="Masukkan NIS" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama asli Anda" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Buat username" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Buat password" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-login w-100 mb-3 text-white" style="background: #606c38;">
                            Daftar Sekarang <i class="bi bi-check-circle ms-1"></i>
                        </button>

                        
                    </form>

                    <div class="text-center">
                        <p class="text-muted small mb-0">Sudah punya akun?</p>
                        <a onclick="showLogin()" class="register-link small">Kembali ke Login</a>
                    </div>
                </div>
            </div>

        </div> </div> <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    
    <script>
        function showRegister() {
            document.getElementById('box-login').style.display = 'none';
            document.getElementById('box-register').style.display = 'block';
        }

        function showLogin() {
            document.getElementById('box-register').style.display = 'none';
            document.getElementById('box-login').style.display = 'block';
        }
    </script>
</body>
</html>