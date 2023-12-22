<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $judul; ?></title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('tema'); ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('tema'); ?>/dist/css/adminlte.min.css">

  <!-- Styles -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <!-- Or for RTL support -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

  <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png'); ?>">

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

  <!-- sweetalert -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- animate -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body class="hold-transition login-page position-relative">

  <!-- responsive -->
  <style>
    /* For mobile phones: */
    [class*="col-"] {
      width: 100%;
    }

    @media only screen and (min-width: 768px) {

      /* For desktop: */
      .col-1 {
        width: 8.33%;
      }

      .col-2 {
        width: 16.66%;
      }

      .col-3 {
        width: 25%;
      }

      .col-4 {
        width: 33.33%;
      }

      .col-5 {
        width: 41.66%;
      }

      .col-6 {
        width: 50%;
      }

      .col-7 {
        width: 58.33%;
      }

      .col-8 {
        width: 66.66%;
      }

      .col-9 {
        width: 75%;
      }

      .col-10 {
        width: 83.33%;
      }

      .col-11 {
        width: 91.66%;
      }

      .col-12 {
        width: 100%;
      }
    }

    .btn-circle {
      width: 30px;
      height: 30px;
      padding: 6px 0px;
      border-radius: 15px;
      text-align: center;
      font-size: 12px;
      line-height: 1.42857;
    }
  </style>

  <style>
    .select2-selection__rendered {
      line-height: 31px !important;
    }

    .select2-container .select2-selection--single {
      height: 37px !important;
    }

    .select2-selection__arrow {
      height: 37px !important;
    }
  </style>

  <?= $content; ?>

  <script>
    $(".select2_all").select2({
      placeholder: $(this).data('placeholder'),
    });

    function cek_eye() {
      var input = document.getElementById('password');
      if (input.type === "password") {
        input.type = "text";
        $("#e_close").hide();
        $("#e_open").show();
        $("#group_eye").removeClass("bg-danger");
        $("#group_eye").addClass("bg-primary");
        $("#re_close").hide();
        $("#re_open").show();
        $("#rgroup_eye").removeClass("bg-danger");
        $("#rgroup_eye").addClass("bg-primary");
      } else {
        input.type = "password";
        $("#e_close").show();
        $("#e_open").hide();
        $("#group_eye").removeClass("bg-primary");
        $("#group_eye").addClass("bg-danger");
        $("#re_close").show();
        $("#re_open").hide();
        $("#rgroup_eye").removeClass("bg-primary");
        $("#rgroup_eye").addClass("bg-danger");
      }
    }
  </script>

  <!-- jQuery -->
  <script src="<?= base_url('tema'); ?>/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= base_url('tema'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('tema'); ?>/dist/js/adminlte.min.js"></script>
</body>

</html>