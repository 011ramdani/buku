<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4 mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 bg-light rounded-3 shadow-sm border-start border-primary border-5">
                <h2 class="fw-bold mb-1">Dashboard Dadan Library</h2>
                <p class="text-muted mb-0">Selamat datang kembali, <b><?= session()->get('nama'); ?></b>!</p>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4 text-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="bi bi-book text-primary fs-2"></i>
                    </div>
                    <h5 class="card-title text-muted mb-1">Total Buku</h5>
                    <h3 class="fw-bold mb-0"><?= $total_buku; ?></h3>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-3">
                    <a href="<?= base_url('buku'); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        <?= (strtolower(session()->get('role')) == 'anggota') ? 'Lihat Koleksi' : 'Detail'; ?>
                    </a>
                </div>
            </div>
        </div>

        <?php if (strtolower(session()->get('role')) !== 'anggota') : ?>
            
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="bi bi-people text-success fs-2"></i>
                        </div>
                        <h5 class="card-title text-muted mb-1">Total Anggota</h5>
                        <h3 class="fw-bold mb-0"><?= $total_anggota; ?></h3>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center pb-3">
                        <a href="<?= base_url('anggota'); ?>" class="btn btn-sm btn-outline-success rounded-pill px-3">Detail</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="bi bi-arrow-repeat text-warning fs-2"></i>
                        </div>
                        <h5 class="card-title text-muted mb-1">Sirkulasi Aktif</h5>
                        <h3 class="fw-bold mb-0"><?= $sirkulasi_aktif; ?></h3>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center pb-3">
                        <a href="<?= base_url('peminjaman'); ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3">Detail</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                            <i class="bi bi-person-badge text-danger fs-2"></i>
                        </div>
                        <h5 class="card-title text-muted mb-1">Total Pengguna</h5>
                        <h3 class="fw-bold mb-0"><?= count($users); ?></h3>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center pb-3">
                        <a href="<?= base_url('users'); ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3">Detail</a>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>