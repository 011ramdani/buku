<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0">Manajemen Users</h4>
            <p class="text-muted small">Kelola data petugas dan administrator sistem</p>
        </div>
        <a href="<?= base_url('users/create') ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah User
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0"> <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold" width="50">No</th>
                            <th class="py-3 text-uppercase small fw-bold">User</th>
                            <th class="py-3 text-uppercase small fw-bold">Username</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Role</th>
                            <th class="py-3 text-uppercase small fw-bold text-center pe-4" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($users as $u) : ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted"><?= $i++; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="<?= base_url('uploads/users/' . $u['foto']) ?>" 
                                         class="rounded-circle border me-3 object-fit-cover" 
                                         width="40" height="40">
                                    <div>
                                        <div class="fw-bold"><?= $u['nama']; ?></div>
                                        <div class="text-muted small"><?= $u['email']; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><code class="text-primary"><?= $u['username']; ?></code></td>
                            <td class="text-center">
                                <span class="badge <?= $u['role'] == 'Admin' ? 'bg-primary' : 'bg-info text-white' ?> rounded-pill px-3">
                                    <?= $u['role']; ?>
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group shadow-sm">
                                    <a href="<?= base_url('users/edit/' . $u['id']) ?>" class="btn btn-sm btn-outline-info">
    <i class="bi bi-pencil-square"></i>
</a>
                                    <a href="<?= base_url('users/delete/' . $u['id']) ?>" 
                                       class="btn btn-sm btn-outline-danger" 
                                       onclick="return confirm('Hapus user ini?')" title="Hapus">
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
    /* Tambahan dikit biar foto di tabel nggak gepeng */
    .object-fit-cover {
        object-fit: cover;
    }
    .table thead th {
        border-bottom: 1px solid #eee;
    }
</style>

<?= $this->endSection() ?>