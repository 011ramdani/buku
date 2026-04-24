<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="bi bi-wallet2 text-primary fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Denda Saya</h5>
                            <p class="text-muted small mb-0">Riwayat keterlambatan pengembalian buku</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary small fw-bold">
                                <tr>
                                    <th class="ps-4 py-3">TOTAL DENDA</th>
                                    <th>STATUS</th>
                                    <th class="text-center">AKSI PEMBAYARAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($denda)) : ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <i class="bi bi-emoji-smile fs-1 text-muted d-block mb-2"></i>
                                            <p class="text-muted">Tidak ada denda. Tetap disiplin ya, Bang!</p>
                                        </td>
                                    </tr>
                                <?php else : foreach ($denda as $d) : ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-danger fs-5">
                                            Rp <?= number_format($d['jumlah_denda'], 0, ',', '.') ?>
                                        </td>
                                        <td>
                                            <?php if ($d['status'] == 'belum bayar' && empty($d['bukti_bayar'])) : ?>
                                                <span class="badge rounded-pill bg-danger px-3">Belum Lunas</span>
                                            <?php elseif ($d['status'] == 'belum bayar' && !empty($d['bukti_bayar'])) : ?>
                                                <span class="badge rounded-pill bg-warning text-dark px-3">Menunggu Verifikasi</span>
                                            <?php else : ?>
                                                <span class="badge rounded-pill bg-success px-3">Lunas</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($d['status'] == 'belum bayar') : ?>
                                                <button class="btn btn-sm btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalBayar<?= $d['id_denda'] ?>">
                                                    <i class="bi bi-upc-scan me-1"></i> <?= empty($d['bukti_bayar']) ? 'Bayar via DANA' : 'Ganti Bukti' ?>
                                                </button>
                                            <?php else : ?>
                                                <div class="text-success fw-bold">
                                                    <i class="bi bi-check-circle-fill me-1"></i> Terverifikasi
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="modalBayar<?= $d['id_denda'] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-sm modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg rounded-4">
                                                <div class="modal-header border-0 pb-0">
                                                    <h6 class="modal-title fw-bold">Pembayaran DANA</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <p class="small text-muted mb-3">Silakan scan QRIS di bawah ini</p>
                                                    <img src="<?= base_url('assets/img/qris.jpg') ?>" class="img-fluid rounded-3 mb-3 border p-2 bg-white">
                                                    
                                                    <form action="<?= base_url('pembayaran/upload_dana') ?>" method="post" enctype="multipart/form-data">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="id_denda" value="<?= $d['id_denda'] ?>">
                                                        <div class="text-start mb-3">
                                                            <label class="form-label small fw-bold">Upload Bukti Transfer</label>
                                                            <input type="file" name="bukti_bayar" class="form-control form-control-sm border-2" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2">Kirim Bukti Pembayaran</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .bg-primary.bg-opacity-10 { background-color: rgba(13, 110, 253, 0.1); }
</style>

<?= $this->endSection() ?>