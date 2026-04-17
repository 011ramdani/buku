<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h3 class="card-title">Detail Peminjaman</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">ID Pinjam</th>
                    <td>#LP-<?= $pinjam['id_peminjaman']; ?></td>
                </tr>
                <tr>
                    <th>Nama Peminjam</th>
                    <td><?= $pinjam['nama_anggota']; ?></td>
                </tr>
                <tr>
                    <th>Judul Buku</th>
                    <td><?= $pinjam['judul']; ?></td>
                </tr>
                <tr>
                    <th>Tanggal Pinjam</th>
                    <td><?= $pinjam['tanggal_pinjam']; ?></td>
                </tr>
                <tr>
                    <th>Deadline Kembali</th>
                    <td><?= $pinjam['tanggal_kembali']; ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge <?= ($pinjam['status'] == 'di pinjam') ? 'bg-warning text-dark' : 'bg-success'; ?>">
                            <?= $pinjam['status']; ?>
                        </span>
                    </td>
                </tr>
            </table>
            <a href="/peminjaman" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    </div>
</div>