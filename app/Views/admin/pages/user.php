<?= $this->extend('admin/layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            User
            <small>Ubah Data</small>
        </h1>

        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="#"><i class="fa fa-home"></i>Dashboard</a>
            </li>
            <li><a href="#">User</a></li>
            <li class="active">Ubah Data</li>
        </ol>
    </section>
    <section id="maincontent" class="content">
        <div class="row">
            <!-- Menampilkan pesan sukses -->
            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('message'); ?>
                </div>
            <?php endif; ?>

            <!-- Menampilkan pesan error -->
            <?php if (session()->getFlashdata('error_message')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error_message'); ?>
                </div>
            <?php endif; ?>

            <form id="validasi" action="<?= base_url('admin/updateUser') ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="penduduk" src="https://demosid.opendesa.id/assets/images/pengguna/kuser.png" alt="Foto Pengguna">
                            <br>
                            <p class="text-center text-bold">Foto Pengguna</p>
                            <p class="text-muted text-center text-red">(Kosongkan, jika foto tidak berubah)</p>
                            <br>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="file_path" name="foto" placeholder="Masukkan path foto">
                                <input type="file" class="hidden" id="file" name="foto" accept=".gif,.jpg,.jpeg,.png">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-flat" id="file_browser"><i class="fa fa-search"></i> Browse</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <b>Data User</b>
                        </div>
                        <div class="box-body">
                            <input type="hidden" name="id" value="<?= esc($user['id']); ?>">

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="nama">Nama Lengkap</label>
                                <div class="col-sm-8">
                                    <input id="nama" name="nama" class="form-control input-sm required" type="text" placeholder="Nama Lengkap" value="<?= esc($user['nama']); ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="username">Username</label>
                                <div class="col-sm-8">
                                    <input id="username" name="username" class="form-control input-sm required" type="text" placeholder="Username" value="<?= esc($user['username']); ?>" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="old_password">Password Lama</label>
                                <div class="col-sm-8">
                                    <input id="old_password" name="old_password" class="form-control input-sm" type="password" placeholder="Masukkan Password Lama" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="password">Kata Sandi Baru</label>
                                <div class="col-sm-8">
                                    <input id="password" name="password" class="form-control input-sm" type="password" placeholder="Ubah Password" autocomplete="off">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="reset" class="btn btn-social btn-danger btn-sm"><i class="fa fa-times"></i> Batal</button>
                            <button type="submit" class="btn btn-social btn-info btn-sm pull-right"><i class="fa fa-check"></i> Simpan</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="sidcsrf" value="<?= csrf_hash(); ?>">
            </form>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>