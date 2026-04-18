<!doctype html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Dadan </title>

    <!-- Bootstrap CSS Lokal -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

   <style>
    body {
        /* Geser konten ke kanan biar nggak tumpang tindih */
        padding-left: 250px; 
        /* Pastikan warna background body sama dengan konten (Putih/Abu sangat muda) */
        background-color: #ffffff !important; 
        margin: 0;
    }

    .sidebar-simpel {
        width: 250px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        background-color: #212529; /* Warna gelap sidebar */
        border: none !important;
        box-shadow: none !important; /* Hapus bayangan kalau bikin garis baru */
    }

    /* Ini bagian buat mastiin gak ada gap atau sela warna */
    .container-fluid, .main-content {
        background-color: #ffffff !important;
        min-height: 100vh;
    }

    .nav-pills .nav-link {
        color: #adb5bd;
        border-radius: 8px;
        margin-bottom: 5px;
        transition: 0.3s;
    }

    .nav-pills .nav-link.active {
        background-color: #0d6efd !important;
        color: white;
    }

    .nav-pills .nav-link:hover {
        background-color: rgba(255,255,255,0.1);
        color: white;
    }
</style>
</head>

<body>
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <?php include(APPPATH . 'Views/layouts/menu.php'); ?>
    </div>

    <!-- Konten Utama -->
    <div class="content">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Bootstrap JS Lokal -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>