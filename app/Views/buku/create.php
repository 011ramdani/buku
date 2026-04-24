<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Tambah Koleksi Buku</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item small"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item small"><a href="<?= base_url('buku') ?>" class="text-decoration-none">Buku</a></li>
                    <li class="breadcrumb-item small active">Tambah</li>
                </ol>
            </nav>
        </div>
        <a href="<?= base_url('buku') ?>" class="btn btn-light border shadow-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-bottom border-light">
            <div class="d-flex align-items-center">
                <i class="bi bi-journal-plus text-primary me-2 fs-5"></i>
                <h6 class="mb-0 fw-bold">Formulir Data Buku Baru</h6>
            </div>
        </div>
        <div class="card-body p-4">
            <form method="post" action="<?= base_url('buku/store') ?>">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-7 border-end-md">
                        <h6 class="text-primary fw-bold mb-3 small text-uppercase">Informasi Buku</h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Judul Buku</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-book text-muted"></i></span>
                                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul buku lengkap" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small">ISBN</label>
                                <input type="text" name="isbn" class="form-control" placeholder="Nomor ISBN">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" class="form-control" placeholder="Contoh: 2024">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Deskripsi / Sinopsis</label>
                            <textarea name="deskripsi" class="form-control" rows="5" placeholder="Tuliskan ringkasan buku..."></textarea>
                        </div>
                    </div>

                    <div class="col-md-5 ps-md-4">
                        <h6 class="text-primary fw-bold mb-3 small text-uppercase">Klasifikasi & Inventaris</h6>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Kategori</label>
                            <select name="id_kategori" class="form-select border-primary-subtle" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori as $k): ?>
                                    <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Penulis</label>
                            <select name="id_penulis" class="form-select" required>
                                <option value="">-- Pilih Penulis --</option>
                                <?php foreach ($penulis as $p): ?>
                                    <option value="<?= $p['id_penulis'] ?>"><?= $p['nama_penulis'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Penerbit</label>
                            <select name="id_penerbit" class="form-select" required>
                                <option value="">-- Pilih Penerbit --</option>
                                <?php foreach ($penerbit as $p): ?>
                                    <option value="<?= $p['id_penerbit'] ?>"><?= $p['nama_penerbit'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Lokasi Rak</label>
                            <select name="id_rak" class="form-select" required>
                                <option value="">-- Pilih Rak --</option>
                                <?php foreach ($rak as $r): ?>
                                    <option value="<?= $r['id_rak'] ?>">
                                        <?= $r['nama_rak'] ?> (<?= $r['lokasi'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold small">Total Stok</label>
                                <input type="number" name="jumlah" class="form-control text-center fw-bold" placeholder="0">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label fw-semibold small">Tersedia</label>
                                <input type="number" name="tersedia" class="form-control text-center fw-bold text-success bg-success-subtle border-success-subtle" placeholder="0">
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 border-light">

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-light px-4 rounded-pill">Reset</button>
                    <button type="submit" class="btn btn-primary px-5 rounded-pill shadow">
                        <i class="bi bi-cloud-check me-2"></i> Simpan Koleksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .form-label { color: #555; }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
    .input-group-text { border: 1px solid #dee2e6; }
    
    /* Responsive border */
    @media (min-width: 768px) {
        .border-end-md { border-right: 1px solid #f1f1f1 !important; }
    }
</style>

<?= $this->endSection() ?>