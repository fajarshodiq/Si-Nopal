<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Akta Cerai</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Tabel Data Akta Cerai</h3>
                        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#addModal">+ Terbitkan Akta Cerai</button>
                    </div>
                    <div class="box-body">
                        <!-- Notifikasi Sukses dan Error -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Tabel Data Akta Cerai -->
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No Akta Cerai</th>
                                    <th>No Perkara</th>
                                    <th>No Seri</th>
                                    <th>Nama Penggugat</th>
                                    <th>Nama Tergugat</th>
                                    <th>Tanggal Pendaftaran</th>
                                    <th>Tanggal Terbit</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($akta_cerai as $a) : ?>
                                    <tr>
                                        <td><?= $a['no_akta_cerai']; ?></td>
                                        <td><?= $a['no_perkara']; ?></td>
                                        <td><?= $a['no_seri']; ?></td>
                                        <td><?= $a['nama_penggugat']; ?></td>
                                        <td><?= $a['nama_tergugat']; ?></td>
                                        <td><?= $a['tanggal_pendaftaran']; ?></td>
                                        <td><?= $a['tanggal_terbit']; ?></td>
                                        <td>
                                            <a href="#editModal<?= $a['id_akta_cerai']; ?>" class="label label-warning" data-toggle="modal">Edit</a>
                                            <a href="/admin/deleteAktaCerai/<?= $a['id_akta_cerai']; ?>" class="label label-danger" onclick="return confirm('Apakah anda yakin?');">Hapus</a>
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

<!-- Modal Terbitkan Akta Cerai -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/admin/saveaktacerai" method="post">
                <?= csrf_field(); ?> <!-- Tambahkan ini jika menggunakan CSRF -->
                <div class="modal-header">
                    <h3 class="modal-title" id="addModalLabel">Terbitkan Akta Cerai</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="no_perkara">No Perkara</label>
                        <select class="form-control" name="id_perkara" required>
                            <option value="">Pilih No Perkara</option>
                            <?php foreach ($no_perkara_options as $option): ?>
                                <option value="<?= $option['id_perkara']; ?>"> <!-- Gunakan id_perkara sebagai value -->
                                    <?= $option['no_perkara'] . ' - ' . $option['nama_penggugat']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_akta_cerai">No Akta Cerai</label>
                        <input type="text" class="form-control" name="no_akta_cerai" required>
                    </div>
                    <div class="form-group">
                        <label for="no_seri">No Seri</label>
                        <input type="text" class="form-control" name="no_seri" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_terbit">Tanggal Terbit</label>
                        <input type="text" class="form-control datepicker" name="tanggal_terbit" placeholder="YYYY-MM-DD" required>
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

<!-- Modal Edit Akta Cerai -->
<?php foreach ($akta_cerai as $a): ?>
    <div class="modal fade" id="editModal<?= $a['id_akta_cerai']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $a['id_akta_cerai']; ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="/admin/updateaktacerai/<?= $a['id_akta_cerai']; ?>" method="post">
                    <?= csrf_field(); ?> <!-- Tambahkan ini jika menggunakan CSRF -->
                    <div class="modal-header">
                        <h3 class="modal-title" id="editModalLabel<?= $a['id_akta_cerai']; ?>">Edit Akta Cerai</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="no_perkara">No Perkara</label>
                            <!-- Field no_perkara yang disabled -->
                            <select class="form-control" disabled>
                                <option value=""><?= $a['no_perkara'] . ' - ' . $a['nama_penggugat']; ?></option>
                            </select>
                            <!-- Field hidden yang menyimpan id_perkara untuk dikirimkan -->
                            <input type="hidden" name="id_perkara" value="<?= $a['id_perkara']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="no_akta_cerai">No Akta Cerai</label>
                            <input type="text" class="form-control" name="no_akta_cerai" value="<?= $a['no_akta_cerai']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="no_seri">No Seri</label>
                            <input type="text" class="form-control" name="no_seri" value="<?= $a['no_seri']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_terbit">Tanggal Terbit</label>
                            <input type="text" class="form-control datepicker" name="tanggal_terbit" value="<?= $a['tanggal_terbit']; ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<script>
    $(document).ready(function() {
        // Inisialisasi DataTables
        $('#example1').DataTable({
            responsive: true,
        });

        // Inisialisasi Datepicker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>

<?= $this->endSection(); ?>