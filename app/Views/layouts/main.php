<!doctype html>
<html lang="id">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Dadan Library' ?></title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        body {
            background-color: #f4f7f6;
            margin: 0;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            background-color: #212529;
            color: white;
            padding-top: 10px;
            overflow-y: auto;
            border-right: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s;
        }

        /* Konten Utama */
        .content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* Profile Image di Sidebar */
        .profile-img {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #0d6efd;
            margin-bottom: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        /* Nav Pills Styling */
        .nav-pills .nav-link {
            color: #adb5bd;
            border-radius: 10px;
            margin-bottom: 8px;
            padding: 12px 15px;
            transition: 0.2s;
            font-weight: 500;
        }

        .nav-pills .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
        }

        .nav-pills .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        /* Responsive Mobile */
        @media (max-width: 992px) {
            .sidebar { 
                width: 100%; 
                height: auto; 
                position: relative; 
                padding-bottom: 15px;
            }
            .content { 
                margin-left: 0; 
                padding: 20px;
            }
        }

        /* Custom Scrollbar Sidebar */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.1);
        }
    </style>
</head>

<body>
    <aside class="sidebar shadow">
        <div class="px-3">
            <?php include(APPPATH . 'Views/layouts/menu.php'); ?>
        </div>
    </aside>

    <main class="content">
        <div class="container-fluid">
            
            <?php if (session()->getFlashdata('success')) : ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '<?= session()->getFlashdata('success') ?>',
                        showConfirmButton: false,
                        timer: 2000
                    });
                </script>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Waduh!',
                        text: '<?= session()->getFlashdata('error') ?>',
                    });
                </script>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
            
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>