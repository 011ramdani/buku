<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Dadan Library</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        body {
            /* Perpaduan Biru Laut (Deep Ocean) ke Biru Langit (Sky Blue) */
            background: linear-gradient(135deg, #0077b6 0%, #90e0ef 100%);
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.95); /* Putih bersih transparan dikit */
        }

        .login-header {
            background: transparent;
            border-bottom: none;
            padding-top: 40px;
        }

        .icon-box {
            width: 70px;
            height: 70px;
            background: #caf0f8; /* Biru muda pucat */
            color: #0077b6; /* Biru laut */
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 30px;
            transform: rotate(-10deg); /* Biar estetik dikit */
        }

        .form-label {
            color: #023e8a;
            font-weight: 600;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
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
            background: #0077b6; /* Warna Biru Laut */
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.4s;
        }

        .btn-login:hover {
            background: #023e8a; /* Biru lebih gelap saat dihover */
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0, 119, 182, 0.3);
        }

        .register-link {
            color: #0077b6;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link:hover {
            color: #023e8a;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card login-card shadow-lg" style="width: 420px;">
            
            <div class="card-header login-header text-center">
                <div class="icon-box shadow-sm">
                    <i class="bi bi-bookmarks-fill"></i>
                </div>
                <h3 class="fw-bold" style="color: #03045e;">DADAN 01</h3>
                <p class="text-muted small">Library Management System</p>
            </div>

            <div class="card-body px-4 pb-5">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger border-0 small shadow-sm mb-4">
                        <i class="bi bi-x-octagon-fill me-2"></i><?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('salahpw')): ?>
                    <div class="alert alert-warning border-0 small shadow-sm mb-4 text-dark">
                        <i class="bi bi-shield-exclamation-fill me-2"></i><?= session()->getFlashdata('salahpw') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/proses-login') ?>" method="post">

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

                    <button class="btn btn-primary btn-login w-100 mb-3 text-white">
                        Sign In <i class="bi bi-arrow-right-short ms-1"></i>
                    </button>

                </form>

                <div class="text-center">
                    <p class="text-muted small mb-0">Belum terdaftar sebagai petugas?</p>
                    <a href="<?= base_url('users/create') ?>" class="register-link small">
                        Buat Akun Baru
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>