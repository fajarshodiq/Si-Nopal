<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Perkara</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Tabel Data Perkara</h3>
                        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#addModal">+ Tambah Data</button>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No Perkara</th>
                                    <th>Nama Penggugat</th>
                                    <th>Nama Tergugat</th>
                                    <th>Tgl.Pemb.Putusan</th>
                                    <th>Alamat</th>
                                    <th>Status Akta Cerai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($perkara as $p) : ?>
                                    <tr>
                                        <td class="no-perkara"><?= $p['no_perkara']; ?></td>
                                        <td class="nama-penggugat"><?= $p['nama_penggugat']; ?></td>
                                        <td class="nama-tergugat"><?= $p['nama_tergugat']; ?></td>
                                        <td class="tanggal-pendaftaran"><?= $p['tanggal_pendaftaran']; ?></td>
                                        <td class="alamat"><?= $p['alamat']; ?></td>
                                        <td>
                                            <p class="label label-<?= $p['status_akta']['label']; ?>">
                                                <?= $p['status_akta']['text']; ?>
                                            </p>
                                        </td>
                                        <td>
                                            <a href="#" class="label label-warning btn-edit" data-toggle="modal" data-target="#editModal"
                                                data-id-perkara="<?= $p['id_perkara']; ?>"
                                                data-no-perkara="<?= $p['no_perkara']; ?>"
                                                data-nama-penggugat="<?= $p['nama_penggugat']; ?>"
                                                data-nama-tergugat="<?= $p['nama_tergugat']; ?>"
                                                data-tanggal-pendaftaran="<?= $p['tanggal_pendaftaran']; ?>"
                                                data-alamat="<?= $p['alamat']; ?>"
                                                data-email="<?= $p['email']; ?>"
                                                data-whatsapp="<?= $p['no_whatsapp']; ?>">Edit</a>
                                            <a href="/admin/delete/<?= $p['id_perkara']; ?>" class="label label-danger" onclick="return confirm('Apakah anda yakin?');">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/admin/save" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Perkara</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="no_perkara">No Perkara</label>
                        <input type="text" class="form-control" name="no_perkara">
                    </div>
                    <div class="form-group">
                        <label for="nama_penggugat">Nama Penggugat</label>
                        <input type="text" class="form-control" name="nama_penggugat" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_tergugat">Nama Tergugat</label>
                        <input type="text" class="form-control" name="nama_tergugat" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_pendaftaran">Tanggal PBT</label>
                        <input type="date" class="form-control" name="tanggal_pendaftaran" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label for="no_whatsapp">No WhatsApp</label>
                        <input type="text" class="form-control" name="no_whatsapp"> <!-- Ubah nama dari "whatsapp" menjadi "no_whatsapp" -->
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editForm" action="<?= base_url('/admin/update'); ?>" method="post">
                <?= csrf_field(); ?> <!-- Tambahkan CSRF jika diperlukan -->
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Perkara</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_perkara" id="edit_id_perkara" value="<?= $p['id_perkara']; ?>">
                    <div class="form-group">
                        <label for="edit_nama_penggugat">Nama Penggugat</label>
                        <input type="text" class="form-control" id="edit_nama_penggugat" name="nama_penggugat" value="<?= $p['nama_penggugat']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_nama_tergugat">Nama Tergugat</label>
                        <input type="text" class="form-control" id="edit_nama_tergugat" name="nama_tergugat" value="<?= $p['nama_tergugat']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tanggal_pendaftaran">Tanggal PBT</label>
                        <input type="date" class="form-control" id="edit_tanggal_pendaftaran" name="tanggal_pendaftaran" value="<?= $p['tanggal_pendaftaran']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_alamat">Alamat</label>
                        <textarea class="form-control" id="edit_alamat" name="alamat" required><?= $p['alamat']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" value="<?= $p['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_whatsapp">No WhatsApp</label>
                        <input type="text" class="form-control" id="edit_whatsapp" name="no_whatsapp" value="<?= $p['no_whatsapp']; ?>" required pattern="[0-9]{10,15}" title="Harap masukkan nomor WhatsApp yang valid (10-15 digit)">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script untuk mengisi data di modal edit
    $(document).on('click', '.btn-edit', function() {
        $('#edit_id_perkara').val($(this).data('id-perkara'));
        $('#edit_nama_penggugat').val($(this).data('nama-penggugat'));
        $('#edit_nama_tergugat').val($(this).data('nama-tergugat'));
        $('#edit_tanggal_pendaftaran').val($(this).data('tanggal-pendaftaran'));
        $('#edit_alamat').val($(this).data('alamat'));
        $('#edit_email').val($(this).data('email'));
        $('#edit_whatsapp').val($(this).data('whatsapp'));

        // Update action URL form dengan id_perkara
        var idPerkara = $(this).data('id-perkara');
        $('#editForm').attr('action', '<?= base_url('/admin/update'); ?>/' + idPerkara);
    });
</script>



<script>
    // Script untuk mengisi data di modal edit
    $(document).on('click', '.btn-edit', function() {
        $('#edit_id_perkara').val($(this).data('id-perkara'));
        $('#edit_nama_penggugat').val($(this).data('nama-penggugat'));
        $('#edit_nama_tergugat').val($(this).data('nama-tergugat'));
        $('#edit_tanggal_pendaftaran').val($(this).data('tanggal-pendaftaran'));
        $('#edit_alamat').val($(this).data('alamat'));
        $('#edit_email').val($(this).data('email'));
        $('#edit_whatsapp').val($(this).data('whatsapp'));
    });
</script>

<script>
    $(document).ready(function() {
        $('#example1').DataTable({
            responsive: true,
            "order": [
                [4, "desc"]
            ] // Urutkan berdasarkan kolom ke-5 (tanggal_pendaftaran) secara DESC
        });
    });
</script>


<?= $this->endSection(); ?>