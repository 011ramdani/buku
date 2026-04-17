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
    </tbody>
</table>