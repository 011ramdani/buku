<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    /* Custom Styling untuk Koleksi Buku Dadan Library */
    .breadcrumb-item a { color: #6c757d; transition: 0.3s; }
    .breadcrumb-item a:hover { color: #0077b6; }
    
    .card-koleksi {
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }

    .search-box {
        border-radius: 12px;
        transition: 0.3s;
        border: 1px solid #e9ecef;
    }

    .search-box:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(0, 119, 182, 0.1);
        border-color: #0077b6;
    }

    .table thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 700;
        border-bottom: 2px solid #e9ecef;
        letter-spacing: 0.5px;
    }

    .book-cover {
        width: 55px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        transition: 0.4s;
    }

    .table tr:hover .book-cover {
        transform: scale(1.1) rotate(2deg);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .btn-action {
        border-radius: 10px;
        margin: 0 2px;
        transition: 0.3s;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .badge-stok {
        font-size: 0.75rem;
        padding: 5px 10px;
        border-radius: 8px;
    }
</style>

<div class="container-fluid px-4 mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4 py-2 px-3 bg-white shadow-sm rounded-pill" style="width: fit-content;">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a></li>
            <li class="breadcrumb-item active fw-bold">Koleksi Buku</li>
        </ol>
    </nav>

    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark mb-1">Koleksi Buku</h2>
            <p class="text-muted small">Kelola dan jelajahi ribuan literatur di <span class="text-primary fw-bold">Dadan Library</span>.</p>
        </div>
        
        <?php if (strtolower(session('role')) != 'anggota') : ?>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="<?= base_url('buku/create') ?>" class="btn btn-primary shadow-sm px-4 py-2 rounded-pill">
                <i class="bi bi-plus-lg me-2"></i>Tambah Buku Baru
            </a>
            <a href="<?= base_url('buku/print') ?>" target="_blank" class="btn btn-outline-dark shadow-sm px-4 py-2 rounded-pill ms-2">
                <i class="bi bi-printer-fill me-2"></i>Cetak Laporan
            </a>
        </div>
        <?php endif; ?>
    </div>

    <div class="row mb-4">
        <div class="col-md-5">
            <form method="get" action="">
                <div class="input-group search-box shadow-sm bg-white p-1">
                    <span class="input-group-text border-0 bg-transparent text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" class="form-control border-0 shadow-none" placeholder="Cari judul, penulis, atau ISBN..." value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                    <button class="btn btn-primary rounded-pill px-4" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-koleksi overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="small text-uppercase">
                        <tr>
                            <th class="ps-4 py-4">Informasi Buku</th>
                            <th class="py-4">Kategori & Identitas</th>
                            <th class="py-4 text-center">Status Stok</th>
                            <th class="py-4 text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($buku as $b): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center py-2">
                                    <div class="flex-shrink-0 me-3">
                                        <?php if (!empty($b['gambar']) && file_exists('assets/img/buku/' . $b['gambar'])) : ?>
                                            <img src="<?= base_url('assets/img/buku/' . $b['gambar']) ?>" alt="Sampul" class="book-cover shadow">
                                        <?php else : ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center border shadow-sm text-muted book-cover">
                                                <i class="bi bi-journal-x fs-2"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1"><?= $b['judul'] ?></h6>
                                        <p class="text-muted small mb-0"><i class="bi bi-person-fill me-1"></i> <?= $b['nama_penulis'] ?></p>
                                        <span class="badge bg-secondary-subtle text-secondary border mt-1" style="font-size: 0.7rem;">Terbit: <?= $b['tahun_terbit'] ?></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="mb-1"><code class="text-primary fw-bold" style="font-size: 0.85rem;"><?= $b['isbn'] ?></code></div>
                                <span class="badge bg-info-subtle text-info border-info-subtle px-3 py-2 rounded-pill"><?= $b['nama_kategori'] ?></span>
                            </td>
                            <td class="text-center">
                                <div class="h5 fw-bold mb-0"><?= $b['tersedia'] ?></div>
                                <div class="text-muted small">Tersedia dari <?= $b['jumlah'] ?></div>
                                <?php if($b['tersedia'] <= 0): ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle mt-1 px-3">STOK HABIS</span>
                                <?php else: ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle mt-1 px-3">READY</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center">
                                    <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>" class="btn btn-light btn-action text-info" title="Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <?php if (strtolower(session('role')) == 'anggota') : ?>
                                        <?php if ($b['tersedia'] > 0) : ?>
                                            <a href="<?= base_url('peminjaman/ajukan/' . $b['id_buku']) ?>" class="btn btn-primary btn-action fw-bold px-3" onclick="return confirm('Ajukan peminjaman buku ini?')" title="Pinjam">
                                                <i class="bi bi-hand-index-thumb-fill me-1"></i> Pinjam
                                            </a>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>" class="btn btn-light btn-action text-warning" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a href="<?= base_url('buku/delete/' . $b['id_buku']) ?>" class="btn btn-light btn-action text-danger" onclick="return confirm('Hapus buku ini?')" title="Hapus">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    <?php endif; ?>

                                    <a href="https://wa.me/<?= $b['no_admin'] ?? '#' ?>" target="_blank" class="btn btn-light btn-action text-success" title="Hubungi Admin">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if (empty($buku)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <img src="<?= base_url('assets/img/no-data.svg') ?>" style="width: 150px; opacity: 0.5;" class="mb-3">
                                <p class="text-muted fw-bold">Oops! Buku yang Anda cari tidak ditemukan.</p>
                                <a href="<?= base_url('buku') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-4">Lihat Semua Koleksi</a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>