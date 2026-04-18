<div class="sidebar-dadan d-flex flex-column flex-shrink-0 p-3 text-white bg-dark shadow">
    
    <a href="<?= base_url('/') ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="bi bi-book-half me-2 fs-4 text-primary"></i>
        <span class="fs-4 fw-bold">Dadan Library</span>
    </a>
    <hr class="border-secondary">

    <div class="text-center mb-4">
        <div class="position-relative d-inline-block">
            <img src="<?= base_url('uploads/users/' . session()->get('foto')) ?>" 
                 alt="Profile" 
                 width="75" height="75" 
                 class="rounded-circle border border-3 border-primary mb-2 shadow-sm object-fit-cover">
        </div>
        <h6 class="mb-0 text-white small"><?= session('nama'); ?></h6>
        <div class="badge bg-primary text-uppercase mt-1" style="font-size: 0.6rem;">
            <?= session('role'); ?>
        </div>
    </div>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= base_url('/') ?>" class="nav-link text-white <?= (uri_string() == '' || uri_string() == 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
        </li>

        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
        <li>
            <a href="<?= base_url('/users') ?>" class="nav-link text-white <?= (uri_string() == 'users') ? 'active' : '' ?>">
                <i class="bi bi-people me-2"></i> Users
            </a>
        </li>
        <?php endif; ?>

        <li>
            <a href="<?= base_url('/buku') ?>" class="nav-link text-white <?= (uri_string() == 'buku') ? 'active' : '' ?>">
                <i class="bi bi-journals me-2"></i> Koleksi Buku
            </a>
        </li>
        
        <li>
            <a href="<?= base_url('peminjaman') ?>" class="nav-link text-white <?= (uri_string() == 'peminjaman') ? 'active' : '' ?>">
                <i class="bi bi-arrow-left-right me-2"></i> Peminjaman
            </a>
        </li>

        <li>
            <a href="<?= base_url('peminjaman/list_denda') ?>" class="nav-link text-white <?= (uri_string() == 'peminjaman/list_denda') ? 'active' : '' ?>">
                <i class="bi bi-cash-stack me-2 text-warning"></i> Data Denda
            </a>
        </li>
    </ul>

    <hr class="border-secondary">

    <ul class="nav nav-pills flex-column">
        <li>
            <a href="<?= base_url('users/edit/' . session('id')) ?>" class="nav-link text-white small">
                <i class="bi bi-gear me-2"></i> Setting
            </a>
        </li>
        <li>
            <a href="<?= base_url('/logout') ?>" class="nav-link text-danger fw-bold small" onclick="return confirm('Keluar sistem?')">
                <i class="bi bi-box-arrow-right me-2"></i> Keluar
            </a>
        </li>
    </ul>
</div>

<style>
    body {
        /* Memberi jarak di kiri badan halaman agar konten tidak tertutup sidebar */
        padding-left: 250px; 
    }

    .sidebar-dadan {
        width: 250px;
        height: 100vh;
        position: fixed; /* Mengunci menu di kiri */
        top: 0;
        left: 0;
        z-index: 1000;
        overflow-y: auto;
    }

    .nav-pills .nav-link {
        border-radius: 8px;
        margin-bottom: 4px;
        transition: 0.2s;
        font-size: 0.9rem;
    }

    .nav-pills .nav-link:hover {
        background-color: rgba(13, 110, 253, 0.15);
    }

    .nav-pills .nav-link.active {
        background-color: #0d6efd !important;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .object-fit-cover {
        object-fit: cover;
    }

    /* Memperbaiki tampilan saat dibuka di HP */
    @media (max-width: 768px) {
        body { padding-left: 0; }
        .sidebar-dadan { position: relative; width: 100%; height: auto; }
    }
</style>