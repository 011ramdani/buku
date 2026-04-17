<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Daftar Peminjaman Buku</h3>
            <div>
                <a href="<?= base_url('dashboard'); ?>" class="btn btn-warning btn-sm shadow-sm me-1">
                    Kembali ke Dashboard
                </a>
                <a href="<?= base_url('peminjaman/create'); ?>" class="btn btn-light btn-sm shadow-sm">
                    <strong>+ Tambah Peminjaman</strong>
                </a>
            </div>
        </div>
        <div class="card-body">

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-bordered table-striped mt-2 align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($peminjaman)) : ?>
                            <?php $i = 1; foreach ($peminjaman as $p) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $p['nama_anggota']; ?></td>
                                <td><?= $p['judul']; ?></td>
                                <td class="text-center"><?= $p['tanggal_pinjam']; ?></td>
                                <td class="text-center"><?= $p['tanggal_kembali']; ?></td>
                                <td class="text-center">
                                    <?php if($p['status'] == 'di pinjam') : ?>
                                        <span class="badge bg-warning text-dark">Di Pinjam</span>
                                    <?php else : ?>
                                        <span class="badge bg-success">Di Kembalikan</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($p['status'] == 'di pinjam') : ?>
                                        <form action="<?= base_url('peminjaman/update/' . $p['id_peminjaman']); ?>" method="post" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="id_anggota" value="<?= $p['id_anggota']; ?>">
                                            <input type="hidden" name="id_buku" value="<?= $p['id_buku']; ?>">
                                            <input type="hidden" name="tanggal_kembali" value="<?= $p['tanggal_kembali']; ?>">
                                            <input type="hidden" name="status" value="di kembalikan">
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Buku sudah dikembalikan? Stok akan bertambah otomatis.')">
                                                Kembalikan
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <a href="<?= base_url('peminjaman/edit/' . $p['id_peminjaman']); ?>" class="btn btn-sm btn-info text-white">
                                        Edit
                                    </a>
                                    
                                    <form action="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']); ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted italic">Belum ada data peminjaman buku.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>