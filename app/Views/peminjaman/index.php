<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0"><i class="fas fa-book-reader me-2"></i> Daftar Peminjaman Buku</h5>
            <div>
                <a href="<?= base_url('dashboard'); ?>" class="btn btn-warning btn-sm shadow-sm me-1">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="<?= base_url('peminjaman/create'); ?>" class="btn btn-light btn-sm shadow-sm">
                    <strong>+ Tambah</strong>
                </a>
            </div>
        </div>
        <div class="card-body">

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle border">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($peminjaman)) : ?>
                            <?php $i = 1; foreach ($peminjaman as $p) : ?>
                            <tr>
                                <td class="text-center fw-bold"><?= $i++; ?></td>
                                <td><?= $p['nama_anggota']; ?></td>
                                <td><strong><?= $p['judul']; ?></strong></td>
                                <td class="text-center small"><?= $p['tanggal_pinjam']; ?></td>
                                <td class="text-center small"><?= $p['tanggal_kembali']; ?></td>
                                <td class="text-center">
                                    <?php if($p['status'] == 'di pinjam') : ?>
                                        <span class="badge rounded-pill bg-warning text-dark">Di Pinjam</span>
                                    <?php else : ?>
                                        <span class="badge rounded-pill bg-success">Di Kembalikan</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <?php if ($p['status'] == 'di pinjam') : ?>
                                            <a href="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']) ?>" 
                                               class="btn btn-sm btn-success" 
                                               title="Kembalikan & Cek Denda"
                                               onclick="return confirm('Proses pengembalian buku? Stok akan bertambah & denda akan dihitung otomatis.')">
                                                <i class="fas fa-undo"></i>
                                            </a>
                                        <?php endif; ?>

                                        <a href="<?= base_url('peminjaman/edit/' . $p['id_peminjaman']); ?>" 
                                           class="btn btn-sm btn-info text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']); ?>" method="post" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted small italic">Belum ada data peminjaman buku.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>