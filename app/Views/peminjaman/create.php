<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="mb-3">
                <a href="<?= base_url('peminjaman'); ?>" class="text-decoration-none text-muted small fw-bold">
                    <i class="bi bi-chevron-left"></i> KEMBALI KE DAFTAR
                </a>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-success py-3 px-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-journal-plus fs-3 text-white me-3"></i>
                        <div>
                            <h5 class="card-title mb-0 text-white fw-bold">Form Peminjaman Baru</h5>
                            <small class="text-white-50">Pastikan stok buku tersedia sebelum memproses</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="<?= base_url('peminjaman/store'); ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-bold small text-uppercase tracking-wide text-secondary">
                                    <i class="bi bi-person-fill me-1"></i> Nama Anggota (Peminjam)
                                </label>
                                <select name="id_anggota" class="form-select form-select-lg border-2 shadow-sm custom-input" required>
                                    <option value="" selected disabled>-- Pilih Nama Anggota --</option>
                                    <?php foreach($anggota as $a) : ?>
                                        <option value="<?= $a['id_anggota']; ?>">
                                            <?= $a['nama_anggota']; ?> — NIS: <?= $a['nis']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold small text-uppercase tracking-wide text-secondary">
                                    <i class="bi bi-book-half me-1"></i> Judul Buku yang Dipinjam
                                </label>
                                <select name="id_buku" class="form-select form-select-lg border-2 shadow-sm custom-input" required>
                                    <option value="" selected disabled>-- Cari Judul Buku --</option>
                                    <?php foreach($buku as $b) : ?>
                                        <option value="<?= $b['id_buku']; ?>" <?= ($b['tersedia'] <= 0) ? 'disabled' : '' ?>>
                                            <?= $b['judul']; ?> (Stok: <?= $b['tersedia']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if(empty($buku)): ?>
                                    <div class="form-text text-danger"><i class="bi bi-exclamation-circle"></i> Stok buku sedang kosong</div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase tracking-wide text-secondary">Tanggal Pinjam</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-2 border-end-0"><i class="bi bi-calendar-event"></i></span>
                                    <input type="date" name="tanggal_pinjam" class="form-control form-control-lg border-2 border-start-0 bg-light shadow-sm" value="<?= date('Y-m-d'); ?>" readonly>
                                </div>
                                <div class="form-text mt-1 text-italic small">*Otomatis diset hari ini</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase tracking-wide text-secondary">Tanggal Harus Kembali</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-2 border-end-0 text-primary"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" name="tanggal_kembali" class="form-control form-control-lg border-2 border-start-0 shadow-sm custom-input" required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 border-light">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-light px-4 py-2 border-0 fw-bold text-muted me-md-2">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow btn-simpan">
                                <i class="bi bi-check-circle-fill me-2"></i> SIMPAN TRANSAKSI
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <p class="text-center text-muted mt-4 small">&copy; 2026 Dadan Library — Management System</p>
        </div>
    </div>
</div>

<style>
    /* Custom Styling agar lebih estetik */
    .rounded-4 { border-radius: 1.25rem !important; }
    
    .tracking-wide { letter-spacing: 0.05em; }
    
    .custom-input {
        border-color: #e9ecef;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }

    .custom-input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
    }

    .btn-simpan {
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }

    .btn-simpan:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(13, 110, 253, 0.3);
    }

    .form-select-lg {
        font-size: 1rem;
        padding-top: 0.8rem;
        padding-bottom: 0.8rem;
    }

    .input-group-text {
        border-radius: 0.75rem 0 0 0.75rem;
        border-color: #e9ecef;
    }

    .input-group .form-control {
        border-radius: 0 0.75rem 0.75rem 0;
    }
</style>

<?= $this->endSection() ?>