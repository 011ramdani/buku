<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Perbaikan: Gambar latar buram dihapus, diganti dengan warna solid yang bersih */
    .dashboard-wrapper {
        background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
        min-height: 100vh;
        padding-bottom: 50px;
    }

    .welcome-banner {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border-left: 6px solid #0077b6 !important;
        border-radius: 15px;
    }

    .stat-card {
        border: none;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        transition: all 0.3s ease;
    }

    .icon-circle {
        width: 60px; height: 60px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto; border-radius: 15px; font-size: 1.8rem;
    }

    .log-card {
        border: none;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.9);
    }
</style>

<div class="dashboard-wrapper">
    <div class="container-fluid px-4 pt-4">
        
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-banner p-4 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="bi bi-stars text-warning fs-1"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1 text-dark">Dashboard Dadan Library</h2>
                            <p class="text-muted mb-0">Halo, <b><?= session()->get('nama'); ?></b>! Senang melihatmu kembali hari ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card stat-card shadow-sm h-100">
                    <div class="card-body p-4 text-center">
                        <div class="icon-circle bg-primary bg-opacity-10 text-primary mb-3">
                            <i class="bi bi-journal-bookmark-fill"></i>
                        </div>
                        <h6 class="text-uppercase fw-semibold text-muted small">Total Koleksi Buku</h6>
                        <h3 class="fw-bold text-dark mb-0"><?= $total_buku; ?></h3>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center pb-4">
                        <a href="<?= base_url('buku'); ?>" class="btn btn-sm btn-primary rounded-pill px-4">
                            <?= (strtolower(session()->get('role')) == 'anggota') ? 'Cari Buku' : 'Kelola'; ?>
                        </a>
                    </div>
                </div>
            </div>

            <?php if (strtolower(session()->get('role')) !== 'anggota') : ?>
                <div class="col-md-3">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <div class="icon-circle bg-success bg-opacity-10 text-success mb-3">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <h6 class="text-uppercase fw-semibold text-muted small">Anggota Terdaftar</h6>
                            <h3 class="fw-bold text-dark mb-0"><?= $total_anggota; ?></h3>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center pb-4">
                            <a href="<?= base_url('anggota'); ?>" class="btn btn-sm btn-success rounded-pill px-4">Data Anggota</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <div class="icon-circle bg-warning bg-opacity-10 text-warning mb-3">
                                <i class="bi bi-arrow-left-right"></i>
                            </div>
                            <h6 class="text-uppercase fw-semibold text-muted small">Sirkulasi Aktif</h6>
                            <h3 class="fw-bold mb-0 text-dark"><?= $sirkulasi_aktif; ?></h3>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center pb-4">
                            <a href="<?= base_url('peminjaman'); ?>" class="btn btn-sm btn-warning text-white rounded-pill px-4">Pantau</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-body p-4 text-center">
                            <div class="icon-circle bg-danger bg-opacity-10 text-danger mb-3">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                            <h6 class="text-uppercase fw-semibold text-muted small">Admin & Petugas</h6>
                            <h3 class="fw-bold text-dark mb-0"><?= count($users); ?></h3>
                        </div>
                        <div class="card-footer bg-transparent border-0 text-center pb-4">
                            <a href="<?= base_url('users'); ?>" class="btn btn-sm btn-danger rounded-pill px-4">Kelola Staff</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card log-card shadow-sm">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="bi bi-clock-history me-2 text-primary"></i>
                            Log Aktivitas <?= (strtolower(session()->get('role')) == 'anggota') ? 'Saya' : 'Terbaru'; ?>
                        </h5>
                        <?php if (!empty($logs)) : ?>
                            <a href="<?= base_url('home/clearAllLogs'); ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Abang yakin mau hapus SEMUA riwayat aktivitas?')">
                                <i class="bi bi-trash3 me-1"></i> Bersihkan Semua
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20%;">Waktu</th>
                                        <th>Aktivitas</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 150px;">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($logs)) : ?>
                                        <?php foreach ($logs as $l) : ?>
                                            <tr>
                                                <td class="small text-muted">
                                                    <?= date('d M Y, H:i', strtotime($l['created_at'])); ?>
                                                </td>
                                                <td class="fw-medium"><?= $l['pesan']; ?></td>
                                                <td class="text-center">
                                                    <?php if ($l['status_verifikasi'] == 'pending') : ?>
                                                        <span class="badge bg-warning text-dark px-3 rounded-pill">Menunggu</span>
                                                    <?php else : ?>
                                                        <span class="badge bg-success px-3 rounded-pill">Selesai</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        
                                                        <?php if (strtolower(session()->get('role')) !== 'anggota') : ?>
                                                            
                                                            <?php if ($l['status_verifikasi'] == 'pending') : ?>
                                                                <a href="<?= base_url('peminjaman'); ?>" class="btn btn-sm btn-primary rounded-pill px-3" title="Proses Sekarang">
                                                                    <i class="bi bi-check2-circle me-1"></i> Verifikasi
                                                                </a>
                                                            <?php endif; ?>

                                                            <a href="<?= base_url('home/deleteLog/' . $l['id_log']); ?>" class="text-danger p-2" title="Hapus Log" onclick="return confirm('Hapus aktivitas ini?')">
                                                                <i class="bi bi-trash"></i>
                                                            </a>

                                                        <?php else : ?>
                                                            <span class="text-muted small">-</span>
                                                        <?php endif; ?>

                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-5">
                                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                                Belum ada aktivitas tercatat.
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