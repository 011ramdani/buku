<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0">Sirkulasi Peminjaman</h4>
            <p class="text-muted small">Kelola data peminjaman buku perpustakaan</p>
        </div>
        <a href="<?= base_url('peminjaman/create') ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Transaksi
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3" width="50">No</th>
                            <th class="py-3">Peminjam</th>
                            <th class="py-3">Buku</th>
                            <th class="py-3">Batas Kembali</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($peminjaman as $p) : ?>
                        <?php 
                            $st = strtolower(trim($p['status'] ?? '')); 
                        ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted"><?= $no++ ?></td>
                            <td>
                                <div class="fw-bold"><?= $p['nama_anggota'] ?></div>
                                <small class="text-muted">ID: <?= $p['id_anggota'] ?></small>
                            </td>
                            <td><?= $p['judul'] ?></td>
                            <td><?= date('d M Y', strtotime($p['tanggal_kembali'])) ?></td>
                            <td class="text-center">
                                <?php if ($st == 'di pinjam') : ?>
                                    <span class="badge rounded-pill bg-warning text-dark px-3">Dipinjam</span>
                                <?php elseif ($st == 'di kembalikan') : ?>
                                    <span class="badge rounded-pill bg-success px-3">Dikembalikan</span>
                                <?php elseif ($st == 'menunggu verifikasi' || $st == '') : ?>
                                    <span class="badge rounded-pill bg-info text-dark px-3">Verifikasi</span>
                                <?php else : ?>
                                    <span class="badge rounded-pill bg-secondary px-3"><?= $p['status'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group">
                                    <?php if ($st == 'menunggu verifikasi' || $st == '') : ?>
                                        <a href="<?= base_url('peminjaman/setujui/' . $p['id_peminjaman']) ?>" class="btn btn-sm btn-success" title="Setujui">
                                            <i class="bi bi-check-lg"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($st == 'di pinjam') : ?>
                                        <a href="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']) ?>" class="btn btn-sm btn-outline-success" title="Kembalikan" onclick="return confirm('Kembalikan buku?')">
                                            <i class="bi bi-arrow-return-left"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($st != 'di kembalikan') : ?>
                                        <a href="<?= base_url('peminjaman/edit/' . $p['id_peminjaman']) ?>" class="btn btn-sm btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']) ?>" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Hapus transaksi?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>