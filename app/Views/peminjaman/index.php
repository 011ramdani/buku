<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container mt-4">
    <div class="card shadow border-0" style="border-radius: 12px;">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0"><i class="fas fa-book-reader me-2"></i> Verifikasi Peminjaman Buku</h5>
            <div>
                <a href="<?= base_url('dashboard'); ?>" class="btn btn-warning btn-sm shadow-sm me-1">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
               <a href="<?= base_url('peminjaman/create'); ?>" class="btn btn-primary mb-3">
    <i class="bi bi-plus-lg"></i> Tambah Peminjaman
</a>
            </div>
        </div>
        <div class="card-body">

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light border-bottom">
                        <tr class="text-center small text-uppercase text-muted">
                            <th width="50">No</th>
                            <th class="text-start">Peminjam</th>
                            <th class="text-start">Judul Buku</th>
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
                                <td class="text-center fw-bold"><?= $i++; ?></td>
                                <td>
                                    <div class="fw-bold"><?= $p['nama_anggota']; ?></div>
                                    <small class="text-muted">ID: <?= $p['id_anggota']; ?></small>
                                </td>
                                <td>
                                    <div class="text-primary fw-bold"><?= $p['judul']; ?></div>
                                </td>
                               <td class="text-center small">
    <?php 
        // Kita cek satu-satu kemungkinan nama kolomnya
        $tgl_pinjam = $p['tanggal_pinjam'] ?? $p['tgl_pinjam'] ?? null;
        if ($tgl_pinjam && $tgl_pinjam != '0000-00-00') {
            echo date('d/m/Y', strtotime($tgl_pinjam));
        } else {
            echo '<span class="text-danger">Belum Set</span>';
        }
    ?>
</td>
<td class="text-center small">
    <?php 
        $tgl_kembali = $p['tanggal_kembali'] ?? $p['tgl_kembali'] ?? null;
        if ($tgl_kembali && $tgl_kembali != '0000-00-00') {
            echo date('d/m/Y', strtotime($tgl_kembali));
        } else {
            echo '<span class="text-muted">-</span>';
        }
    ?>
</td>
<td class="text-center">
    <?php if($p['status'] == 'diajukan') : ?>
        <span class="badge bg-info text-dark shadow-sm">Diajukan</span>
    <?php elseif($p['status'] == 'di pinjam') : ?>
        <span class="badge bg-warning text-dark shadow-sm">Di Pinjam</span>
    <?php elseif($p['status'] == 'di kembalikan') : ?>
        <span class="badge bg-success shadow-sm">Selesai</span>
    <?php else : ?>
        <span class="badge bg-secondary shadow-sm"><?= $p['status'] ?: 'Pending'; ?></span>
    <?php endif; ?>
</td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm">
                                        <?php if ($p['status'] == 'diajukan') : ?>
                                            <a href="<?= base_url('peminjaman/setujui/' . $p['id_peminjaman']) ?>" class="btn btn-sm btn-success" onclick="return confirm('ACC Pinjaman?')"><i class="fas fa-check"></i></a>
                                            <a href="<?= base_url('peminjaman/tolak/' . $p['id_peminjaman']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tolak?')"><i class="fas fa-times"></i></a>
                                        <?php endif; ?>

                                        <?php if ($p['status'] == 'di pinjam') : ?>
                                            <a href="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']) ?>" class="btn btn-sm btn-primary" onclick="return confirm('Buku kembali?')"><i class="fas fa-undo"></i></a>
                                        <?php endif; ?>

                                        <a href="<?= base_url('peminjaman/edit/' . $p['id_peminjaman']); ?>" class="btn btn-sm btn-light border"><i class="fas fa-edit text-info"></i></a>
                                        
                                       <a href="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']) ?>" 
   onclick="return confirm('Yakin mau hapus?')" 
   class="btn btn-danger btn-sm">
   <i class="fa fa-trash"></i>
</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="7" class="text-center py-5 text-muted">Data Kosong.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>