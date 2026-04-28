<style>
    /* 1. Variabel Warna & Font */
    :root {
        --side-bg: #0f172a;      /* Deep Navy */
        --item-active: #38bdf8;  /* Sky Blue */
        --text-muted: #94a3b8;
        --glass: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    .sidebar-dadan {
        background-color: var(--side-bg);
        min-height: 100vh;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; /* Font modern */
        box-shadow: 4px 0 24px rgba(0,0,0,0.3);
    }

    /* 2. Logo Brand Area */
    .brand-box {
        padding: 1.5rem 0.5rem;
        background: linear-gradient(to right, rgba(56, 189, 248, 0.1), transparent);
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }

    .logo-icon {
        background: linear-gradient(135deg, #38bdf8, #0ea5e9);
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(14, 165, 233, 0.25);
    }

    /* 3. Profile Section Glassmorphism */
    .profile-card-modern {
        background: var(--glass);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 20px 15px;
        margin-bottom: 2rem;
        backdrop-filter: blur(10px);
    }

    .img-wrapper {
        position: relative;
        display: inline-block;
    }

    .img-wrapper img {
        border: 3px solid #1e293b;
        outline: 2px solid var(--item-active);
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .img-wrapper:hover img {
        transform: rotate(5deg) scale(1.1);
    }

    /* 4. Navigation Links */
    .nav-pills .nav-link {
        color: var(--text-muted) !important;
        border-radius: 14px;
        padding: 12px 18px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .nav-pills .nav-link i {
        font-size: 1.25rem;
        transition: 0.3s;
    }

    /* Hover State */
    .nav-pills .nav-link:hover {
        background: rgba(255, 255, 255, 0.05);
        color: #fff !important;
        padding-left: 24px; /* Efek bergeser */
    }

    .nav-pills .nav-link:hover i {
        color: var(--item-active);
        transform: scale(1.2);
    }

    /* Active State */
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #38bdf8, #0284c7) !important;
        color: #fff !important;
        box-shadow: 0 10px 20px rgba(14, 165, 233, 0.25);
    }

    .nav-pills .nav-link.active i {
        color: #fff !important;
    }

    /* 5. Menu Headers */
    .menu-header-modern {
        font-size: 0.65rem;
        font-weight: 800;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 25px 0 12px 18px;
        display: block;
    }

    /* 6. Special Backup Button */
    .btn-backup {
        background: rgba(16, 185, 129, 0.1) !important;
        color: #10b981 !important;
        border: 1px dashed rgba(16, 185, 129, 0.3) !important;
    }

    .btn-backup:hover {
        background: #10b981 !important;
        color: #fff !important;
    }
</style>

<div class="sidebar-dadan d-flex flex-column flex-shrink-0 p-3 text-white">
    
   <div class="brand-box">
    <a href="<?= base_url('/') ?>" class="d-flex align-items-center text-white text-decoration-none px-2">
        <div class="logo-icon me-3">
            <div class="bg-white bg-opacity-25 p-2 rounded-3">
                <i class="bi bi-book-half text-white fs-4"></i>
            </div>
        </div>
        <div>
            <h5 class="mb-0 fw-bold tracking-tight text-white">
                Dadan<span style="color: #0d6efd;">Library</span> 
            </h5>
            <small class="text-white-50" style="font-size: 0.7rem; letter-spacing: 1px;">Digital Management</small>
        </div>
    </a>
</div>

    <div class="profile-card-modern text-center">
        <div class="img-wrapper mb-3">
            <?php 
                $foto = session()->get('foto') ?: 'default.png'; 
                $pathFoto = base_url('uploads/users/' . $foto);
            ?>
            <img src="<?= $pathFoto ?>" 
                 alt="Profile" 
                 width="72" height="72" 
                 class="rounded-circle object-fit-cover shadow-lg"
                 onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode(session('nama')) ?>&background=38bdf8&color=fff'">
        </div>
        <h6 class="mb-1 text-white fw-bold lh-sm"><?= session('nama'); ?></h6>
        <div class="badge rounded-pill bg-info bg-opacity-10 text-info px-3 py-2 border border-info border-opacity-20" style="font-size: 0.6rem;">
            <i class="bi bi-patch-check-fill me-1"></i><?= strtoupper(session('role')); ?>
        </div>
    </div>

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= base_url('/') ?>" class="nav-link <?= (uri_string() == '' || uri_string() == 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?= base_url('buku') ?>" class="nav-link <?= (url_is('buku*')) ? 'active' : '' ?>">
                <i class="bi bi-journal-bookmark-fill"></i> <span>Koleksi Buku</span>
            </a>
        </li>

        <?php $role = strtolower(session()->get('role') ?? ''); ?>
        
        <?php if ($role == 'anggota') : ?>
            <li class="nav-item">
                <a href="<?= base_url('peminjaman/denda_anggota') ?>" class="nav-link <?= (uri_string() == 'peminjaman/denda_anggota') ? 'active' : '' ?>">
                    <i class="bi bi-wallet2"></i> <span>Denda Saya</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($role == 'admin' || $role == 'petugas') : ?>
            <span class="menu-header-modern">Management System</span>
            
            <li class="nav-item">
                <a href="<?= base_url('/users') ?>" class="nav-link <?= (uri_string() == 'users') ? 'active' : '' ?>">
                    <i class="bi bi-people-fill"></i> <span>Data Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?= base_url('/anggota') ?>" class="nav-link <?= (uri_string() == 'anggota') ? 'active' : '' ?>">
                    <i class="bi bi-person-vcard-fill"></i> <span>Data Anggota</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?= base_url('peminjaman') ?>" class="nav-link <?= (uri_string() == 'peminjaman') ? 'active' : '' ?>">
                    <i class="bi bi-arrow-left-right"></i> <span>Peminjaman</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="<?= base_url('peminjaman/list_denda') ?>" class="nav-link <?= (uri_string() == 'peminjaman/list_denda') ? 'active' : '' ?>">
                    <i class="bi bi-cash-stack"></i> <span>Data Denda</span>
                </a>
            </li>

            <li class="nav-item mt-2">
                <a href="<?= base_url('/backup') ?>" class="nav-link btn-backup">
                    <i class="bi bi-cloud-arrow-down-fill"></i> <span>Backup Database</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>

    <hr class="border-secondary opacity-10 my-4">
    
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <?php $linkSetting = ($role == 'anggota') ? base_url('profile') : base_url('users/edit/' . session()->get('id_users')); ?>
            <a href="<?= $linkSetting ?>" class="nav-link small opacity-75">
                <i class="bi bi-gear-wide-connected"></i> <span>Pengaturan</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url('/logout') ?>" class="nav-link text-danger fw-bold small mt-1" onclick="return confirm('Yakin ingin keluar?')">
                <i class="bi bi-box-arrow-right"></i> <span>Keluar Sistem</span>
            </a>
        </li>
    </ul>
</div>