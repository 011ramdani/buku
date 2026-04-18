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
            <a href="<?= base_url('anggota/create'); ?>" class="btn btn-primary shadow-sm">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah Anggota
            </a>
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
                            <th class="py-3">No. WhatsApp</th>
                            <th class="py-3">Alamat</th>
                            <th class="py-3 text-center" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($anggota as $a) : ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $no++; ?></td>
                            <td><span class="badge bg-light text-dark border"><?= $a['nis']; ?></span></td>
                            <td>
                                <div class="fw-bold"><?= $a['nama_anggota']; ?></div>
                            </td>
                            <td>
                                <a href="https://wa.me/<?= $a['no_hp']; ?>" target="_blank" class="text-decoration-none text-dark">
                                    <i class="bi bi-whatsapp text-success me-1"></i> <?= $a['no_hp']; ?>
                                </a>
                            </td>
                            <td>
                                <span class="text-truncate d-inline-block" style="max-width: 200px;" title="<?= $a['alamat']; ?>">
                                    <?= $a['alamat']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('anggota/edit/' . $a['id_anggota']); ?>" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= base_url('anggota/delete/' . $a['id_anggota']); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus anggota ini?')" title="Hapus Data">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($anggota)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                                <p class="mt-2 text-muted">Belum ada data anggota terdaftar.</p>
                                <a href="<?= base_url('anggota/create'); ?>" class="btn btn-sm btn-primary">Tambah Sekarang</a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        <small class="text-muted">Total Anggota: <strong><?= count($anggota); ?></strong> orang</small>
    </div>
</div>

<?= $this->endSection() ?>