<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; foreach($peminjaman as $p) : ?>
        <tr>
            <td><?= $i++; ?></td>
            <td><?= $p['nama_peminjam']; ?></td>
            <td><?= $p['judul_buku']; ?></td>
            <td><?= $p['tanggal_pinjam']; ?></td>
            <td><?= $p['tanggal_kembali']; ?></td>
            <td>
                <span class="badge <?= ($p['status'] == 'peminjaman') ? 'bg-warning' : 'bg-success'; ?>">
                    <?= $p['status']; ?>
                </span>
            </td>
            <td>
                <a href="/peminjaman/kembalikan/<?= $p['id_peminjaman']; ?>" class="btn btn-sm btn-primary">Kembalikan</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2 class="mb-3">Daftar Peminjaman Buku</h2>
            
            <a href="/peminjaman/create" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Tambah Peminjaman
            </a>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
            <?php endif; ?>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($peminjaman as $p) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $p['nama_anggota']; ?></td>
                        <td><?= $p['judul']; ?></td>
                        <td><?= $p['tanggal_pinjam']; ?></td>
                        <td><?= $p['tanggal_kembali']; ?></td>
                        <td>
                            <span class="badge <?= ($p['status'] == 'di pinjam') ? 'bg-warning text-dark' : 'bg-success'; ?>">
                                <?= $p['status']; ?>
                            </span>
                        </td>
                        <td>
                            <a href="/peminjaman/edit/<?= $p['id_peminjaman']; ?>" class="btn btn-sm btn-info text-white">Edit</a>
                            
                            <form action="/peminjaman/delete/<?= $p['id_peminjaman']; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah yakin ingin menghapus data ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if (empty($peminjaman)) : ?>
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data peminjaman.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    </tbody>
</table>