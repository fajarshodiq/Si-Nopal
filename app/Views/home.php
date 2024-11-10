<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url('bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('bower_components/font-awesome/css/font-awesome.min.css'); ?>">
    <!-- AdminLTE style -->
    <link rel="stylesheet" href="<?= base_url('dist/css/AdminLTE.min.css'); ?>">
    <style>
        /* Ensure html and body take up full height */
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        /* Styles for body and overlay */
        body {
            background: url('<?= $bg; ?>') no-repeat center center fixed;
            background-size: cover;
        }

        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 0;
        }

        .login-box {
            position: relative;
            z-index: 1;
            width: 90%;
            max-width: 600px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            /* Set padding */
            margin: 20px auto;
            /* Center the login box */
            flex-shrink: 0;
            /* Prevent shrinking */
        }

        .navbar {
            margin-bottom: 20px;
        }

        .login-logo {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }

        .login-description {
            margin-top: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
            margin-bottom: 20px;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        /* Footer styles */
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
            margin-top: auto;
            /* Push footer to the bottom */
            position: relative;
            /* Ensure footer is positioned relative to the page */
            z-index: 1;
            /* Bring footer above the overlay */
        }

        /* Box styles */
        .box {
            margin-bottom: 20px;
            /* Ensure space below box */
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-box {
                padding: 15px;
                /* Less padding on smaller screens */
            }
        }

        /* Alert styles */
        #alertBox {
            display: none;
            /* Initially hidden */
        }
    </style>
</head>

<body>
    <div class="background-overlay"></div>
    <!-- Navbar -->
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">SI NOPAL</a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Cek Akta Cerai</a></li>
                    <li><a href="/validasi">Validasi Akta Cerai</a></li>
                    <li><a href="<?= $delivery; ?>">Pengajuan Delivery</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Login Box -->
    <div class="login-box">
        <div class="login-logo">
            <img src="/image/sinopal.png" alt="Logo Sinopal" style="width: 300px; height: auto; margin: 0px 5px 0 5px;"><br>
            <b>Cek Status Penerbitan Akta Cerai</b>
        </div>
        <form id="checkForm">
            <div class="form-group">
                <div style="display: flex; justify-content: center;">
                    <label for="nopendaftaran">Nomor Perkara :</label>
                </div>
                <textarea class="form-control" id="nopendaftaran" rows="4" required placeholder="000/Pdt.G/2024/PA.Tgm"></textarea>
                <p class="login-description"><b>Keterangan :</b> Silahkan Ketik Nomor Perkara</p>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-flat">Cek</button>
        </form>

        <!-- Box Hasil Pengecekan -->
        <div class="row" id="resultBox" style="display: none; margin-top: 20px;">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><b>Hasil Pengecekan</b></h3>
                    </div>
                    <div class="box-body">
                        <div id="loading">
                            <div class="overlay">
                                <i class="fa fa-6x fa-refresh fa-spin"></i>
                            </div>
                        </div>
                        <div id="alertBox" class="alert alert-dismissible" style="display: none;">
                            <h5 id="alertTitle"><i class="fa"></i></h5>
                            <p id="alertMessage"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="text-muted" style="margin: 0; color: #343a40;">&copy; 2024 Si NOPAL. All rights reserved.</p>
        </div>
    </footer>

    <!-- jQuery 3 -->
    <script src="<?= base_url('bower_components/jquery/dist/jquery.min.js'); ?>"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?= base_url('bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>

    <!-- Script pengecekan -->
    <script>
        $(document).ready(function() {
            $('#checkForm').on('submit', function(event) {
                event.preventDefault();
                const nomorPendaftaran = $('#nopendaftaran').val();
                $('#resultBox').show();
                $('#loading').show();

                setTimeout(function() {
                    $.ajax({
                        url: '<?= base_url('home/check_status'); ?>',
                        type: 'POST',
                        data: {
                            nopendaftaran: nomorPendaftaran
                        },
                        success: function(response) {
                            $('#loading').hide();

                            let alertClass;
                            let alertTitle;
                            let alertMessage;

                            switch (response.status) {
                                case 'sudah_terbit':
                                    alertClass = 'alert alert-success';
                                    alertTitle = '<i class="fa fa-check-circle"></i> Akta Cerai Sudah Terbit';
                                    alertMessage = "Akta cerai Anda telah terbit. Silakan ambil di kantor Pengadilan Agama Tanggamus atau ajukan permohonan delivery akta cerai";
                                    break;
                                case 'belum_terbit':
                                    alertClass = 'alert alert-warning';
                                    alertTitle = '<i class="fa fa-info-circle"></i> Akta Cerai Belum Terbit';
                                    alertMessage = "Silahkan cek kembali nanti untuk status penerbitan akta cerai Anda.";
                                    break;
                                case 'tidak_terdaftar':
                                    alertClass = 'alert alert-danger';
                                    alertTitle = '<i class="fa fa-ban"></i> TIDAK TERDAFTAR!';
                                    alertMessage = "Silahkan datang ke kantor untuk informasi lebih lanjut.";
                                    break;
                            }

                            $('#alertBox').removeClass().addClass(alertClass).show();
                            $('#alertTitle').html(alertTitle);
                            $('#alertMessage').text(alertMessage);
                        },
                        error: function() {
                            $('#loading').hide();
                            $('#alertBox').removeClass().addClass('alert alert-danger').show();
                            $('#alertTitle').html('<i class="fa fa-exclamation-circle"></i> Error');
                            $('#alertMessage').text('Terjadi kesalahan, silakan coba lagi.');
                        }
                    });
                }, 1000);
            });

            $('#nopendaftaran').on('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    $('#checkForm').submit();
                }
            });
        });
    </script>

</body>

</html>