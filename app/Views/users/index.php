<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.9);
        --primary-gradient: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }

    .container-fluid {
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    /* Card Styling */
    .custom-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        overflow: hidden;
    }

    /* Header Styling */
    .card-header-custom {
        background: white;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding: 1.5rem;
    }

    /* Table Styling */
    .table thead th {
        background-color: #fcfcfd;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #6c757d;
        border-top: none;
        padding: 1rem;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8faff !important;
        transform: translateY(-2px);
    }

    /* Profile Image Styling */
    .user-avatar {
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .status-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        border: 2px solid #fff;
        border-radius: 50%;
        background-color: #198754;
    }

    /* Badge Styling */
    .badge-role {
        padding: 0.6em 1em;
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* Button Styling */
    .action-btn {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        transition: all 0.2s;
        border: 1px solid transparent;
    }

    .btn-edit {
        background-color: #e0f2fe;
        color: #0369a1;
    }

    .btn-edit:hover {
        background-color: #0369a1;
        color: white;
    }

    .btn-delete {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background-color: #dc2626;
        color: white;
    }

    .btn-add {
        background: var(--primary-gradient);
        transition: transform 0.2s;
    }

    .btn-add:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-6">
            <h3 class="fw-bold text-dark mb-1">Manajemen Staff</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item small"><a href="<?= base_url('dashboard') ?>" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item small active">Users</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="<?= base_url('users/create') ?>" class="btn btn-primary btn-add rounded-pill px-4 py-2 border-0 shadow-sm">
                <i class="bi bi-plus-circle-fill me-2"></i> Tambah User Baru
            </a>
        </div>
    </div>

    <div class="card custom-card">
        <div class="card-header-custom d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                    <i class="bi bi-people-fill text-primary fs-5"></i>
                </div>
                <h5 class="mb-0 fw-bold text-dark">Daftar Pengguna Sistem</h5>
            </div>
            <span class="badge bg-light text-dark border fw-normal py-2 px-3 rounded-pill">
                Total: <b><?= count($users) ?></b> Staff
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" width="70">No</th>
                            <th>Informasi Profil</th>
                            <th>Username</th>
                            <th class="text-center">Akses Role</th>
                            <th class="text-center pe-4" width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($users as $u) : ?>
                        <tr>
                            <td class="ps-4">
                                <span class="text-muted fw-bold small"><?= str_pad($i++, 2, '0', STR_PAD_LEFT); ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3">
                                        <img src="<?= base_url('uploads/users/' . ($u['foto'] ?: 'default.png')) ?>" 
                                             class="user-avatar rounded-circle" 
                                             width="50" height="50" alt="avatar">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0"><?= $u['nama']; ?></div>
                                        <div class="text-muted small">
                                            <i class="bi bi-envelope me-1"></i><?= $u['email']; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code class="bg-light px-2 py-1 rounded text-primary small">@<?= $u['username']; ?></code>
                            </td>
                            <td class="text-center">
                                <?php if (strtolower($u['role']) == 'admin') : ?>
                                    <span class="badge badge-role rounded-pill bg-success-subtle text-success border border-success-subtle">
                                        <i class="bi bi-shield-check me-1"></i>Administrator
                                    </span>
                                <?php else : ?>
                                    <span class="badge badge-role rounded-pill bg-info-subtle text-info border border-info-subtle">
                                        <i class="bi bi-person-badge me-1"></i>Petugas Perpustakaan
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                   <a href="<?= base_url('users/edit/' . $u['id']) ?>" class="..."> ... </a>
                                       class="action-btn btn-edit" 
                                       title="Edit User">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="<?= base_url('users/delete/' . $u['id']) ?>" 
                                       class="action-btn btn-delete" 
                                       onclick="return confirm('Hapus user <?= $u['nama']; ?>?')" 
                                       title="Hapus User">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-light bg-opacity-50 py-3 border-0">
            <p class="mb-0 small text-center text-muted">
                Dadan Library System &copy; 2026 - Manajemen Data Keamanan
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>