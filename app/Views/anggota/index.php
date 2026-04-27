<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4 mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>" class="text-decoration-none"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daftar Anggota</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0">Manajemen Anggota</h4>
            <p class="text-muted small mb-0">Kelola data seluruh anggota perpustakaan di sini.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('dashboard'); ?>" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
            <?php if (session()->get('role') != 'anggota') : ?>
                <a href="<?= base_url('anggota/create'); ?>" class="btn btn-primary shadow-sm">
                    <i class="bi bi-person-plus-fill me-2"></i>Tambah Anggota
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3" width="60">No</th>
                            <th class="py-3">NIS</th>
                            <th class="py-3">Nama Lengkap</th>
                            <th class="py-3">Username</th> 
                            <th class="py-3">No. WhatsApp</th>
                            <?php if (session()->get('role') != 'anggota') : ?>
                                <th class="py-3 text-center" width="180">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($anggota as $a) : ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $no++; ?></td>
                            <td><span class="badge bg-light text-dark border"><?= $a['nis']; ?></span></td>
                            <td><div class="fw-bold text-primary"><?= $a['nama_anggota']; ?></div></td>
                            <td><span class="text-muted"><i class="bi bi-at"></i><?= $a['username']; ?></span></td>
                            <td>
                                <a href="https://wa.me/<?= $a['no_wa']; ?>" target="_blank" class="text-decoration-none text-dark">
                                    <i class="bi bi-whatsapp text-success me-1"></i> <?= $a['no_wa']; ?>
                                </a>
                            </td>
                            
                            <?php if (session()->get('role') != 'anggota') : ?>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalProfil<?= $a['id_anggota']; ?>" 
                                                title="Lihat Profil">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>

                                        <a href="<?= base_url('anggota/edit/' . $a['id_anggota']); ?>" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('anggota/delete/' . $a['id_anggota']); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus anggota ini?')" title="Hapus Data">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>

                                <div class="modal fade" id="modalProfil<?= $a['id_anggota']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                                            <div class="modal-header bg-primary text-white border-0" style="border-radius: 20px 20px 0 0;">
                                                <h5 class="modal-title fw-bold"><i class="bi bi-person-circle me-2"></i>Profil Anggota</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center p-4">
                                                <div class="mb-3">
                                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($a['nama_anggota']) ?>&background=0D6EFD&color=fff&size=128" 
                                                         class="rounded-circle shadow-sm border border-4 border-light" width="100">
                                                </div>
                                                <h4 class="fw-bold mb-1"><?= $a['nama_anggota']; ?></h4>
                                                <span class="badge bg-soft-primary text-primary border border-primary px-3 mb-3">ANGGOTA AKTIF</span>
                                                
                                                <hr class="my-4 opacity-50">
                                                
                                                <div class="text-start">
                                                    <div class="row mb-2">
                                                        <div class="col-4 text-muted small">NIS</div>
                                                        <div class="col-8 fw-bold">: <?= $a['nis']; ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-4 text-muted small">Username</div>
                                                        <div class="col-8">: @<?= $a['username']; ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-4 text-muted small">WhatsApp</div>
                                                        <div class="col-8">: <?= $a['no_wa']; ?></div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-4 text-muted small">Alamat</div>
                                                        <div class="col-8">: <?= $a['alamat']; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                                <a href="https://wa.me/<?= $a['no_wa']; ?>" target="_blank" class="btn btn-success rounded-pill px-4">
                                                    <i class="bi bi-whatsapp me-2"></i>Hubungi
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <small class="text-muted">Total Anggota: <strong><?= count($anggota); ?></strong> orang</small>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .btn-group .btn { border-radius: 8px; margin: 0 2px; }
</style>

<?= $this->endSection() ?>