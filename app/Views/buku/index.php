<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4 mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>" class="text-decoration-none"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Koleksi Buku</li>
        </ol>
    </nav>

    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h4 class="fw-bold text-dark mb-0">Manajemen Koleksi Buku</h4>
            <p class="text-muted small mb-0">Kelola data buku perpustakaan <strong>Maldin17App</strong>.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <div class="btn-group shadow-sm">
                <a href="<?= base_url('buku/create') ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Buku
                </a>
                <a href="<?= base_url('buku/print') ?>" target="_blank" class="btn btn-outline-secondary">
                    <i class="bi bi-printer me-1"></i> Cetak
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <form method="get" action="">
                <div class="input-group shadow-sm bg-white rounded">
                    <input type="text" name="keyword" class="form-control border-0" placeholder="Cari judul buku..." value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                    <button class="btn btn-white border-0" type="submit">
                        <i class="bi bi-search text-primary"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase">
                            <th class="ps-4 py-3">Buku & Sampul</th>
                            <th class="py-3">ISBN</th>
                            <th class="py-3">Kategori / Rak</th>
                            <th class="py-3 text-center">Stok</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($buku as $b): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center py-1">
                                    <div class="flex-shrink-0 me-3">
                                        <?php if (!empty($b['gambar']) && file_exists('assets/img/buku/' . $b['gambar'])) : ?>
                                            <img src="<?= base_url('assets/img/buku/' . $b['gambar']) ?>" alt="Sampul" class="rounded shadow-sm" style="width: 45px; height: 60px; object-fit: cover;">
                                        <?php else : ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center border shadow-sm" style="width: 45px; height: 60px;">
                                                <i class="bi bi-journal-bookmark text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0"><?= $b['judul'] ?></div>
                                        <small class="text-muted"><?= $b['nama_penulis'] ?> (<?= $b['tahun_terbit'] ?>)</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code class="text-primary small"><?= $b['isbn'] ?></code>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info px-2 mb-1"><?= $b['nama_kategori'] ?></span>
                                <div class="small text-muted"><i class="bi bi-archive small"></i> <?= $b['nama_rak'] ?></div>
                            </td>
                            <td class="text-center">
                                <div class="fw-bold"><?= $b['tersedia'] ?> <span class="text-muted fw-normal">/ <?= $b['jumlah'] ?></span></div>
                                <?php if($b['tersedia'] <= 0): ?>
                                    <span class="badge bg-danger p-1" style="font-size: 0.6rem;">KOSONG</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm border rounded overflow-hidden" role="group">
                                    <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>" class="btn btn-sm btn-white text-info" title="Detail"><i class="bi bi-eye"></i></a>
                                    <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>" class="btn btn-sm btn-white text-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                    <a href="<?= base_url('buku/delete/' . $b['id_buku']) ?>" class="btn btn-sm btn-white text-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')" title="Hapus"><i class="bi bi-trash"></i></a>
                                    <a href="<?= base_url('buku/wa/' . $b['id_buku']) ?>" target="_blank" class="btn btn-sm btn-white text-success" title="WA Admin"><i class="bi bi-whatsapp"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if (empty($buku)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-search text-muted fs-1 mb-3 d-block"></i>
                                <p class="text-muted">Oops! Buku yang kamu cari tidak ada.</p>
                                <a href="<?= base_url('buku') ?>" class="btn btn-sm btn-primary px-3">Tampilkan Semua</a>
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