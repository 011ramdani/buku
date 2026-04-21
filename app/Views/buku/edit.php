<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4 mt-4 mb-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard'); ?>" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('buku'); ?>" class="text-decoration-none">Koleksi Buku</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Buku</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Data Buku</h5>
                </div>
                <div class="card-body p-4">
                    <form action="<?= base_url('buku/update/' . $buku['id_buku']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label class="form-label fw-semibold">Judul Buku</label>
                                        <input type="text" name="judul" class="form-control rounded-3" value="<?= $buku['judul'] ?>" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">ISBN</label>
                                        <input type="text" name="isbn" class="form-control rounded-3" value="<?= $buku['isbn'] ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Kategori</label>
                                        <select name="id_kategori" class="form-select rounded-3">
                                            <?php foreach ($kategori as $k): ?>
                                                <option value="<?= $k['id_kategori'] ?>" <?= $buku['id_kategori'] == $k['id_kategori'] ? 'selected' : '' ?>>
                                                    <?= $k['nama_kategori'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Penulis</label>
                                        <select name="id_penulis" class="form-select rounded-3">
                                            <?php foreach ($penulis as $p): ?>
                                                <option value="<?= $p['id_penulis'] ?>" <?= $buku['id_penulis'] == $p['id_penulis'] ? 'selected' : '' ?>>
                                                    <?= $p['nama_penulis'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Penerbit</label>
                                        <select name="id_penerbit" class="form-select rounded-3">
                                            <?php foreach ($penerbit as $p): ?>
                                                <option value="<?= $p['id_penerbit'] ?>" <?= $buku['id_penerbit'] == $p['id_penerbit'] ? 'selected' : '' ?>>
                                                    <?= $p['nama_penerbit'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Lokasi Rak</label>
                                        <select name="id_rak" class="form-select rounded-3">
                                            <?php foreach ($rak as $r): ?>
                                                <option value="<?= $r['id_rak'] ?>" 
                                                    <?= (isset($current_rak['id_rak']) && $current_rak['id_rak'] == $r['id_rak']) ? 'selected' : '' ?>>
                                                    <?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Tahun Terbit</label>
                                        <input type="number" name="tahun_terbit" class="form-control rounded-3" value="<?= $buku['tahun_terbit'] ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Total Stok</label>
                                        <input type="number" name="jumlah" class="form-control rounded-3" value="<?= $buku['jumlah'] ?>">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-semibold">Tersedia</label>
                                        <input type="number" name="tersedia" class="form-control rounded-3" value="<?= $buku['tersedia'] ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Deskripsi Buku</label>
                                    <textarea name="deskripsi" class="form-control rounded-3" rows="4"><?= $buku['deskripsi'] ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-4 border-start ps-4">
                                <label class="form-label fw-semibold d-block">Sampul Buku</label>
                                <div class="mb-3">
                                    <?php 
                                        // Cek apakah file gambar ada, jika tidak pakai default
                                        $gambarPath = 'assets/img/buku/' . ($buku['cover'] ?? 'default.jpg');
                                        $displayImg = (file_exists($gambarPath)) ? base_url($gambarPath) : base_url('assets/img/buku/default.jpg');
                                    ?>
                                    <img src="<?= $displayImg ?>" 
                                         class="img-thumbnail img-preview mb-2 shadow-sm" 
                                         style="width: 100%; max-width: 200px; height: 280px; object-fit: cover; border-radius: 10px;">
                                    
                                    <div class="input-group">
                                        <input type="file" class="form-control form-control-sm" name="gambar" id="gambar" onchange="previewImg()">
                                    </div>
                                    <small class="text-muted mt-2 d-block">Format: JPG, PNG, WEBP. Maks 2MB.</small>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                                <i class="bi bi-save me-1"></i> Update Data
                            </button>
                            <a href="<?= base_url('buku') ?>" class="btn btn-light px-4 py-2 rounded-pill">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImg() {
    const gambar = document.querySelector('#gambar');
    const imgPreview = document.querySelector('.img-preview');

    const fileGambar = new FileReader();
    fileGambar.readAsDataURL(gambar.files[0]);

    fileGambar.onload = function(e) {
        imgPreview.src = e.target.result;
    }
}
</script>

<?= $this->endSection() ?>