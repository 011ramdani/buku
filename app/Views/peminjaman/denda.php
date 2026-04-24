<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0">Manajemen Denda & Dana</h4>
            <p class="text-muted small">Verifikasi denda Tunai atau bukti transfer DANA anggota</p>
        </div>
        
        <form action="" method="get" class="d-flex">
            <div class="input-group shadow-sm">
                <input type="text" name="keyword" class="form-control" placeholder="Cari nama..." value="<?= request()->getGet('keyword') ?>">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold" width="50">No</th>
                            <th class="py-3 text-uppercase small fw-bold">Detail Peminjam</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Total Denda</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Metode & Bukti</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Status</th>
                            <th class="py-3 text-uppercase small fw-bold text-center pe-4">Tindakan Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($denda)) : ?>   
                            <tr><td colspan="6" class="text-center py-5 text-muted">Data denda tidak ditemukan.</td></tr>
                        <?php endif; ?>
                        
                        <?php $no = 1; foreach ($denda as $d) : ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted"><?= $no++ ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= $d['nama_anggota'] ?></div>
                                <div class="text-muted small"><i class="bi bi-journal-text me-1"></i><?= $d['judul'] ?></div>
                            </td>
                            <td class="text-center fw-bold text-danger">
                                Rp <?= number_format($d['jumlah_denda'], 0, ',', '.') ?>
                            </td>
                            
                            <td class="text-center">
                                <?php if (!empty($d['bukti_bayar'])) : ?>
                                    <div class="d-flex flex-column align-items-center">
                                        <span class="badge bg-info text-dark mb-1"><i class="bi bi-phone"></i> DANA</span>
                                        <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalLihatDana<?= $d['id_denda'] ?>">
                                            <i class="bi bi-eye"></i> Lihat Dana
                                        </button>
                                    </div>

                                    <div class="modal fade" id="modalLihatDana<?= $d['id_denda'] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header border-0 pb-0">
                                                    <h6 class="modal-title fw-bold">Bukti Transfer DANA</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="<?= base_url('assets/uploads/bukti_dana/' . $d['bukti_bayar']) ?>" class="img-fluid rounded-3 shadow-sm border">
                                                    <p class="mt-2 mb-0 small text-muted">Pastikan nominal sesuai sebelum verifikasi.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <span class="badge bg-secondary opacity-50 px-3">Tunai / Belum Upload</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php if ($d['status'] == 'belum bayar') : ?>
                                    <span class="badge rounded-pill bg-danger px-3">Belum Lunas</span>
                                <?php else : ?>
                                    <span class="badge rounded-pill bg-success px-3">Lunas</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <?php if ($d['status'] == 'belum bayar') : ?>
                                        <a href="<?= base_url('peminjaman/konfirmasi_bayar/' . $d['id_denda']) ?>" 
                                           class="btn btn-sm btn-primary px-3" 
                                           onclick="return confirm('Konfirmasi terima denda Rp <?= number_format($d['jumlah_denda'], 0, ',', '.') ?>?')">
                                            <i class="bi bi-shield-check me-1"></i> Verifikasi
                                        </a>
                                    <?php else : ?>
                                        <button class="btn btn-sm btn-light disabled text-muted fw-bold border">
                                            <i class="bi bi-check-lg text-success"></i> Selesai
                                        </button>
                                    <?php endif; ?>

                                    <a href="<?= base_url('peminjaman/delete_denda/' . $d['id_denda']) ?>" 
                                       class="btn btn-sm btn-outline-danger ms-1" 
                                       onclick="return confirm('Hapus riwayat denda ini?')">
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

<style>
    .table td { padding-top: 12px; padding-bottom: 12px; }
    .badge { font-weight: 500; font-size: 0.75rem; }
</style>

<?= $this->endSection() ?>