<div class="sidebar-dadan d-flex flex-column flex-shrink-0 p-3 text-white bg-dark shadow" style="min-height: 100vh;">
    
    <a href="<?= base_url('/') ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="bi bi-book-half me-2 fs-4 text-primary"></i>
        <span class="fs-4 fw-bold">Dadan Library</span>
    </a>
    <hr class="border-secondary">

    <div class="text-center mb-4">
        <div class="position-relative d-inline-block">
            <?php 
                $foto = session()->get('foto') ?: 'default.png'; 
                // Arahkan semua ke folder uploads/users/ karena tadi kita simpan di sana
                $pathFoto = base_url('uploads/users/' . $foto);
            ?>
            <img src="<?= $pathFoto ?>" 
                 alt="Profile" 
                 width="75" height="75" 
                 class="rounded-circle border border-3 border-primary mb-2 shadow-sm object-fit-cover"
                 onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode(session('nama')) ?>&background=0D6EFD&color=fff'">
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

        <li>
<li class="nav-item">
    <a href="<?= base_url('buku') ?>" class="nav-link <?= url_is('buku*') ? 'active' : '' ?>">
        <i class="bi bi-book me-2"></i> Koleksi Buku
    </a>
</li>
        </li>

        <?php $role = strtolower(session()->get('role') ?? ''); ?>
        
        <?php if ($role == 'admin' || $role == 'petugas') : ?>
            <hr class="border-secondary my-2">
            <small class="text-muted text-uppercase ms-3" style="font-size: 0.6rem;">Manajemen Data</small>
            
            <li>
                <a href="<?= base_url('/users') ?>" class="nav-link text-white <?= (uri_string() == 'users') ? 'active' : '' ?>">
                    <i class="bi bi-people me-2"></i> Data Users
                </a>
            </li>

            <li>
                <a href="<?= base_url('/anggota') ?>" class="nav-link text-white <?= (uri_string() == 'anggota') ? 'active' : '' ?>">
                    <i class="bi bi-person-badge me-2"></i> Data Anggota
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
        <?php endif; ?>
    </ul>

    <hr class="border-secondary">

    <ul class="nav nav-pills flex-column">
        <li>
            <?php 
                if ($role == 'anggota') {
                    $linkSetting = base_url('profile'); 
                } else {
                    $linkSetting = base_url('users/edit/' . session()->get('id_user'));
                }
            ?>
            <a href="<?= $linkSetting ?>" class="nav-link text-white small">
                <i class="bi bi-gear me-2"></i> Setting
            </a>
        </li>
        <li>
            <a href="<?= base_url('/logout') ?>" class="nav-link text-danger fw-bold small" onclick="return confirm('Keluar dari sistem?')">
                <i class="bi bi-box-arrow-right me-2"></i> Keluar
            </a>
        </li>
    </ul>
</div>