<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* CUSTOM STYLE - DADAN LIBRARY PRO THEME */
    :root {
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.3);
        --primary-gradient: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);
    }

    .dashboard-wrapper {
        background: #f8fafc; /* Warna solid bersih sesuai request */
        min-height: 100vh;
        padding-bottom: 50px;
    }

    /* Glassmorphism Welcome Banner */
    .welcome-banner {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-left: 6px solid #0077b6 !important;
        border-radius: 20px;
        transition: transform 0.3s ease;
    }
    .welcome-banner:hover {
        transform: translateY(-5px);
    }

    /* Stat Cards Styling */
    .stat-card {
        border: none;
        border-radius: 24px;
        background: white;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 4px;
        background: var(--primary-gradient);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    /* Icon Styling */
    .icon-box {
        width: 65px; height: 65px;
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.7rem;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .stat-card:hover .icon-box {
        transform: scale(1.1) rotate(5deg);
    }

    /* Table & Activity Log */
    .log-card {
        border: none;
        border-radius: 24px;
        background: white;
        overflow: hidden;
    }

    .table thead th {
        background-color: #f1f5f9;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #64748b;
        border-top: none;
    }

    .btn-pill {
        border-radius: 50px;
        padding: 6px 20px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .badge-soft {
        padding: 8px 15px;
        border-radius: 50px;
        font-weight: 600;
    }
</style>

<div class="dashboard-wrapper">
    <div class="container-fluid px-4 pt-4">
        
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                    <div><?= session()->getFlashdata('success'); ?></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-banner p-4 shadow-sm">
                    <div class="row align-items-center">
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="icon-box bg-primary text-white shadow-sm mb-0 me-4">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <div>
                                <h2 class="fw-extrabold mb-1 text-dark">Hello, <?= session()->get('nama'); ?>! 👋</h2>
                                <p class="text-muted mb-0">Selamat datang di panel kendali <b>Dadan Library</b>. Semangat berkarya hari ini!</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div class="text-muted small">Akses Terakhir: <span class="fw-bold text-dark"><?= date('H:i'); ?> WIB</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-book-half"></i>
                        </div>
                        <h6 class="text-muted fw-bold small text-uppercase">Total Koleksi</h6>
                        <h2 class="fw-bold text-dark mb-3"><?= number_format($total_buku); ?></h2>
                        <a href="<?= base_url('buku'); ?>" class="btn btn-sm btn-pill btn-outline-primary w-100">
                            <?= (strtolower(session()->get('role')) == 'anggota') ? 'Cari Buku' : 'Kelola Database'; ?>
                        </a>
                    </div>
                </div>
            </div>

            <?php if (strtolower(session()->get('role')) !== 'anggota') : ?>
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="icon-box bg-success bg-opacity-10 text-success">
                                <i class="bi bi-people"></i>
                            </div>
                            <h6 class="text-muted fw-bold small text-uppercase">Anggota Aktif</h6>
                            <h2 class="fw-bold text-dark mb-3"><?= $total_anggota; ?></h2>
                            <a href="<?= base_url('anggota'); ?>" class="btn btn-sm btn-pill btn-outline-success w-100">Cek Member</a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>
                            <h6 class="text-muted fw-bold small text-uppercase">Sirkulasi Pinjam</h6>
                            <h2 class="fw-bold text-dark mb-3"><?= $sirkulasi_aktif; ?></h2>
                            <a href="<?= base_url('peminjaman'); ?>" class="btn btn-sm btn-pill btn-outline-warning w-100">Monitor Stok</a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="icon-box bg-danger bg-opacity-10 text-danger">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h6 class="text-muted fw-bold small text-uppercase">Tim Petugas</h6>
                            <h2 class="fw-bold text-dark mb-3"><?= count($users); ?></h2>
                            <a href="<?= base_url('users'); ?>" class="btn btn-sm btn-pill btn-outline-danger w-100">Hak Akses</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card log-card shadow-sm">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                            <span class="p-2 bg-primary bg-opacity-10 rounded-3 me-3">
                                <i class="bi bi-lightning-charge text-primary"></i>
                            </span>
                            Log Aktivitas <?= (strtolower(session()->get('role')) == 'anggota') ? 'Saya' : 'Terbaru'; ?>
                        </h5>
                        <?php if (!empty($logs)) : ?>
                            <a href="<?= base_url('home/clearAllLogs'); ?>" class="btn btn-sm btn-danger btn-pill" onclick="return confirm('Hapus semua jejak aktivitas?')">
                                <i class="bi bi-trash3 me-1"></i> Bersihkan
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th class="ps-3">Timestamp</th>
                                        <th>Keterangan Aktivitas</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($logs)) : ?>
                                        <?php foreach ($logs as $l) : ?>
                                            <tr>
                                                <td class="ps-3 small text-secondary">
                                                    <i class="bi bi-calendar3 me-1"></i> <?= date('d M Y', strtotime($l['created_at'])); ?><br>
                                                    <i class="bi bi-clock me-1"></i> <?= date('H:i', strtotime($l['created_at'])); ?>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-dark"><?= $l['pesan']; ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($l['status_verifikasi'] == 'pending') : ?>
                                                        <span class="badge bg-warning bg-opacity-10 text-warning badge-soft">
                                                            <i class="bi bi-hourglass-split me-1"></i> Pending
                                                        </span>
                                                    <?php else : ?>
                                                        <span class="badge bg-success bg-opacity-10 text-success badge-soft">
                                                            <i class="bi bi-check-circle me-1"></i> Verified
                                                        </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (strtolower(session()->get('role')) !== 'anggota') : ?>
                                                        <div class="d-flex justify-content-center gap-2">
                                                            <?php if ($l['status_verifikasi'] == 'pending') : ?>
                                                                <a href="<?= base_url('peminjaman'); ?>" class="btn btn-sm btn-primary btn-pill shadow-sm">
                                                                    Proses
                                                                </a>
                                                            <?php endif; ?>
                                                            <a href="<?= base_url('home/deleteLog/' . $l['id_log']); ?>" class="btn btn-sm btn-outline-danger rounded-circle p-2 border-0" onclick="return confirm('Hapus log ini?')">
                                                                <i class="bi bi-x-circle"></i>
                                                            </a>
                                                        </div>
                                                    <?php else : ?>
                                                        <span class="text-muted small">No Action</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-5">
                                                <div class="mb-3">
                                                    <i class="bi bi-folder2-open fs-1 opacity-25"></i>
                                                </div>
                                                <p>Belum ada rekaman aktivitas yang masuk.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>