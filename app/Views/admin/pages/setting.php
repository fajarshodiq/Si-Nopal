<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Setting SI NOPAL
        </h1>

        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-home"></i>Dashboard</a>
            </li>
            <li class="active">Setting</li>
        </ol>
    </section>
    <section id="maincontent" class="content">
        <div class="row">
            <form action="<?= base_url('admin/saveSetting') ?>" id="validasi" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <b>Latar Website</b>
                        </div>
                        <div class="box-body box-profile text-center">
                            <a href="#" class="progressive" style="cursor: default;">
                                <img src="<?= base_url($settings['latar_login'] ?? 'gedung.jpeg'); ?>" class="img-responsive" style="max-width: 100%; height: auto;" alt="Latar Login">
                            </a>
                            <p class="text-muted text-center text-red">(Kosongkan, jika latar login tidak berubah)</p>
                            <div class="input-group">
                                <input type="text" class="form-control input-sm" id="file_path1" name="latar_login" placeholder="Path file..." readonly>
                                <input type="file" class="hidden" id="file1" name="latar_login" accept=".jpg,.jpeg,.png">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-flat btn-sm" id="file_browser1"><i class="fa fa-search"></i>&nbsp;</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <b>Pengaturan Dasar</b>
                        </div>
                        <div class="box-body">
                            <?php if (session()->getFlashdata('message')): ?>
                                <div class="alert alert-success">
                                    <?= session()->getFlashdata('message'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (session()->getFlashdata('error_message')): ?>
                                <div class="alert alert-danger">
                                    <?= session()->getFlashdata('error_message'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label class="col-sm-12 col-md-3" for="wa_gateway">WA Gateway</label>
                                <div class="col-sm-12 col-md-4">
                                    <input class="form-control input-sm" id="wa_gateway" name="wa_gateway" type="text" value="<?= $settings['wa_gateway'] ?? ''; ?>" required>
                                </div>
                                <label class="col-sm-12 col-md-5 pull-left">Link penyedia layanan WA Gateway</label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 col-md-3" for="wa_sender">WA Sender</label>
                                <div class="col-sm-12 col-md-4">
                                    <input class="form-control input-sm" id="wa_sender" name="wa_sender" type="text" value="<?= $settings['wa_sender'] ?? ''; ?>" required>
                                </div>
                                <label class="col-sm-12 col-md-5 pull-left">Nomor Pengirim WA (08xxxxxxxxxx)</label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 col-md-3" for="apikey">ApiKey</label>
                                <div class="col-sm-12 col-md-4">
                                    <input class="form-control input-sm" id="apikey" name="apikey" type="text" value="<?= $settings['apikey'] ?? ''; ?>" required>
                                </div>
                                <label class="col-sm-12 col-md-5 pull-left">ApiKey yang terdapat di WA Gateway</label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 col-md-3" for="penerbitan_akta_cerai">Penerbitan Akta Cerai Dalam</label>
                                <div class="col-sm-12 col-md-4">
                                    <select class="form-control input-sm" id="penerbitan_akta_cerai" name="penerbitan_akta_cerai" required>
                                        <option value="10" <?= ($settings['penerbitan_akta_cerai'] ?? '') == '10' ? 'selected' : ''; ?>>10 Hari</option>
                                        <option value="11" <?= ($settings['penerbitan_akta_cerai'] ?? '') == '11' ? 'selected' : ''; ?>>11 Hari</option>
                                        <option value="12" <?= ($settings['penerbitan_akta_cerai'] ?? '') == '12' ? 'selected' : ''; ?>>12 Hari</option>
                                        <option value="13" <?= ($settings['penerbitan_akta_cerai'] ?? '') == '13' ? 'selected' : ''; ?>>13 Hari</option>
                                        <option value="14" <?= ($settings['penerbitan_akta_cerai'] ?? '') == '14' ? 'selected' : ''; ?>>14 Hari</option>
                                        <option value="15" <?= ($settings['penerbitan_akta_cerai'] ?? '') == '15' ? 'selected' : ''; ?>>15 Hari</option>
                                    </select>
                                </div>
                                <label class="col-sm-12 col-md-5 pull-left">Penerbitan akta cerai setelah pemberitahuan putusan</label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 col-md-3" for="delivery">Link Delivery</label>
                                <div class="col-sm-12 col-md-4">
                                    <input class="form-control input-sm" id="delivery" name="delivery" type="text" value="<?= $settings['delivery'] ?? ''; ?>" required>
                                </div>
                                <label class="col-sm-12 col-md-5 pull-left">Link Untuk Delivery Akta Cerai</label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 col-md-3" for="notifikasi_reminder">Notifikasi Reminder Akta Cerai</label>
                                <div class="col-sm-12 col-md-4">
                                    <textarea class="form-control input-sm" id="notifikasi_reminder" name="notifikasi_reminder" required><?= $settings['notifikasi_reminder'] ?? ''; ?></textarea>
                                </div>
                                <label class="col-sm-12 col-md-5 pull-left">Notifikasi Untuk Pengingat</label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12 col-md-3" for="notifikasi_penerbitan_akta_cerai">Notifikasi Penerbitan Akta Cerai</label>
                                <div class="col-sm-12 col-md-4">
                                    <textarea class="form-control input-sm" id="notifikasi_penerbitan_akta_cerai" name="notifikasi_penerbitan_akta_cerai" required><?= $settings['notifikasi_penerbitan_akta_cerai'] ?? ''; ?></textarea>
                                </div>
                                <label class="col-sm-12 col-md-5 pull-left">Notifikasi Setelah Penerbitan Akta Cerai</label>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 col-md-4 offset-md-3">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        $('#file_browser1').click(function() {
            $('#file1').click();
        });

        $('#file1').change(function() {
            var filePath = $(this).val().split('\\').pop(); // Mendapatkan nama file
            $('#file_path1').val(filePath); // Menampilkan nama file di input
        });
    });
</script>

<?= $this->endSection(); ?>