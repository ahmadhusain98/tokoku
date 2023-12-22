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
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('tema'); ?>/dist/css/adminlte.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('tema'); ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('tema'); ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url('tema'); ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Styles -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <!-- Or for RTL support -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

  <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png'); ?>">

  <!-- Scripts -->
  <script src="<?= base_url('tema'); ?>/plugins/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets'); ?>/js/jquery-3.5.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

  <!-- sweetalert -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- animate -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<?php
function hitung($date)
{
  $day = date("d", strtotime($date));
  $month = date("m", strtotime($date));
  $year = date("Y", strtotime($date));

  $days    = (int)((mktime(0, 0, 0, $month, $day, $year) - time()) / 86400);

  return $days;
}

$aktif = $this->db->get_where("cabang", ["kode_cabang" => $this->session->userdata("cabang")])->row();

$aktif_hingga = hitung($aktif->tgl_berakhir);
?>

<body class="hold-transition sidebar-mini">

  <!-- responsive -->
  <style>
    /* For mobile phones: */
    [class*="col-"] {
      width: 100%;
    }

    .card-flat {
      border-radius: 0px;
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

  <style>
    .border-primary {
      border: 1px solid #007bff;
    }

    .border-danger {
      border: 1px solid #c82333;
    }
  </style>

  <?php
  if ($this->session->userdata("username") == false) {
    redirect("Auth");
  }
  $unit = $this->session->userdata("cabang");
  $cbg  = $this->db->query("SELECT * FROM cabang WHERE kode_cabang = '$unit'")->row();
  ?>

  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
            <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="text-danger"><?= strtoupper($cbg->nama_cabang); ?></b> -->
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search" onkeyup="cari(this.value)">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>
        <li>
          <?php if ($user->id_role > 1) : ?>
            <?php $jum_keranjang = $this->db->query("SELECT SUM(qty) as qty FROM order_pesanan WHERE username = '" . $this->session->userdata('username') . "' AND status_order = 0")->row(); ?>
          <?php else : ?>
            <?php $jum_keranjang = $this->db->query("SELECT SUM(qty) as qty FROM order_pesanan WHERE status_order = 0 GROUP BY username")->row(); ?>
          <?php endif; ?>
          <a href="<?= site_url('Orderan'); ?>" class="nav-link" title="Keranjang" type="button" id="keranjang">
            <i class="fa-solid fa-cart-shopping"></i>
            <?php if ($jum_keranjang) : ?>
              <?php if ($jum_keranjang->qty >= 0) : ?>
                <sup style="font-size: 8px;" class="right badge badge-warning"><?= $jum_keranjang->qty; ?></sup>
              <?php endif; ?>
            <?php endif; ?>
          </a>
        </li>
        <!-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">1</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <?php foreach ($teman as $t) : ?>
              <a href="#" class="dropdown-item">
                <div class="media">
                  <img src="<?= base_url('assets/user/') . $t->gambar; ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                  <div class="media-body">
                    <h3 class="dropdown-item-title">
                      <?= strtoupper($t->nama); ?>
                      <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                    </h3>
                    <p class="text-sm">Call me whenever you can...</p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                  </div>
                </div>
              </a>
              <div class="dropdown-divider"></div>
            <?php endforeach; ?>
            <a href="#" class="dropdown-item dropdown-footer">Lihat Semua Pesan</a>
          </div>
        </li> -->
        <!-- Notifications Dropdown Menu -->





        <li class="nav-item dropdown" title="Pesan">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <?php if ($jumpesan > 0) : ?>
              <span class="badge badge-warning navbar-badge"><?= $jumpesan; ?></span>
            <?php endif; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <?php if ($jumpesan > 0) : ?>
              <span class="dropdown-item dropdown-header"><?= $jumpesan; ?> Pesan Baru</span>
            <?php else : ?>
              <span class="dropdown-item dropdown-header">Tidak Ada Pesan</span>
            <?php endif; ?>
            <?php foreach ($pesan as $p) : ?>
              <?php $pesannya =  $p->isi; ?>
              <div class="dropdown-divider"></div>
              <?php
              if ($p->isi == 'Meminta Aktifasi') {
                $href = "'Privatex/akun'";
              } else {
                $href = "'Home'";
              }
              ?>
              <a href="#" class="dropdown-item" type="button" onclick="hapus_pesan('<?= $p->isi; ?>', <?= $href; ?>)">
                <?= mb_strimwidth($pesannya, 0, 25, '...'); ?>
                <?php
                $tglmasuk = new DateTime($p->tgl);
                $tgl_pesan = strftime('%d %b %Y', $tglmasuk->getTimestamp());
                $jumkonten = $this->db->query("SELECT * FROM pesan WHERE isi = '$p->isi' AND status = 0")->num_rows();
                ?>
                <sup style="font-size: 8px;" class="right badge badge-danger"><?= $jumkonten; ?></sup>
                <span class="float-right text-muted text-sm"><?= $tgl_pesan; ?></span>
              </a>
            <?php endforeach; ?>
            <div class="dropdown-divider"></div>
            <?php if ($jumpesan > 0) : ?>
              <a href="#" class="dropdown-item dropdown-footer">Lihat Semua Pesan</a>
            <?php endif; ?>
          </div>
        </li>





        <!-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" title="Pengaturan">
            <i class="fas fa-th-large"></i>
          </a>
        </li> -->
        <li class="nav-item">
          <a href="#" class="nav-link" type="button" role="button" title="Keluar" onclick="keluar('<?= $user->username; ?>')">
            <i class="fa-solid fa-power-off text-danger"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= site_url('Home'); ?>" class="brand-link">
        <i class="fa-brands fa-shopify fa-2x brand-image text-danger img-circle elevation-3" style="opacity: .8"></i>
        <span class="brand-text font-weight-light"><b><span class="text-danger">Toko</span><span class="text-primary">ku</span></b><button type="button" disabled class="btn border-white text-white float-right fw-bold"><?= strtoupper($unit); ?></button></span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?= base_url('assets/user/') . $user->gambar; ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <?php if ($user->nama != '' || $user->nama != null) : ?>
              <a href="<?= site_url('Profile'); ?>" class="d-block"><?= mb_strimwidth(strtoupper($user->nama), 0, 18, '...'); ?></a>
            <?php else : ?>
              <a href="<?= site_url('Profile'); ?>" class="d-block">ANONYMOUS</a>
            <?php endif; ?>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Cari Menu" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <?php
            $menu = $this->db->query("SELECT m.* FROM akses_menu am JOIN menu m ON m.id = am.id_menu WHERE am.id_role = '" . $this->session->userdata('id_role') . "' GROUP BY am.id_menu")->result();
            ?>
            <?php
            foreach ($menu as $m) :
              $sub_menu = $this->db->get_where("sub_menu", ["id_menu" => $m->id]);
              $cek_sub_menu = $this->db->query("SELECT * FROM sub_menu WHERE url LIKE '%$m->url%'")->num_rows();
              if ($cek_sub_menu > 0) {
                $url_baru = '#';
                $url_link = $m->url;
              } else {
                $url_link = $m->url;
                $url_baru = $m->url;
              }
            ?>
              <?php if ($this->uri->segment(1) == $url_link) {
                $active = 'active';
              } else {
                $active = '';
              } ?>
              <li class="nav-item">
                <a href="<?= site_url($url_baru); ?>" class="nav-link <?= $active; ?>">
                  <?= $m->icon; ?>
                  <p>
                    <?= $m->nama_menu; ?>
                    <?php if ($sub_menu->num_rows() > 0) : ?>
                      <i class="fas fa-angle-left right"></i>
                    <?php endif; ?>
                  </p>
                </a>
                <?php if ($sub_menu->num_rows() > 0) : ?>
                  <ul class="nav nav-treeview">
                    <?php foreach ($sub_menu->result() as $sm) : ?>
                      <li class="nav-item">
                        <a href="<?= site_url($sm->url); ?>" class="nav-link">
                          <?= $sm->icon; ?>
                          <p>
                            <?= $sm->nama_menu; ?>
                          </p>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </nav>
        <!-- /.sidebar -->
      </div>
    </aside>

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <?php if ($this->uri->segment(1) != 'Profile' && $this->uri->segment(2) != 'Chat') : ?>
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>
                  <?php
                  $uri = strtoupper($this->uri->segment(1));
                  if ($uri == "PRIVATEX") {
                    $uri2 = "PRIVATE";
                  } else {
                    $uri2 = str_replace("_", " ", $uri);
                  }
                  echo $uri2;
                  ?>
                </h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#"><?= str_replace("_", " ", $uri2); ?></a></li>
                  <li class="breadcrumb-item active"><?= strtoupper(str_replace("_", " ", $this->uri->segment(2))); ?></li>
                </ol>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </section>

      <!-- Main content -->
      <?= $content; ?>

    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        Masa Aktif Cabang: <b><?= ($aktif_hingga <= 7) ? '<span style="color: red; font-weight: bold;">' . $aktif_hingga . '</span>' : $aktif_hingga ?> Hari</b>
      </div>
      <strong>Copyright &copy; <span class="text-danger">Toko</span><span class="text-primary">ku</span>.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark"></aside>
    <!-- End Control Sidebar -->
  </div>

  <!-- select2 master -->
  <script>
    $(".select2_all").select2({
      allowClear: true,
      placeholder: $(this).data('placeholder'),
    });
    // header
    initailizeSelect2_cabang();
    initailizeSelect2_role();
    initailizeSelect2_satuan('');
    initailizeSelect2_kategori('');
    initailizeSelect2_supplier('');
    initailizeSelect2_gudang('');
    initailizeSelect2_ppn();
    initailizeSelect2_barang('');
    initailizeSelect2_barang_jual('', '');
    initailizeSelect2_po('');
    initailizeSelect2_penerimaan('');
    initailizeSelect2_pembeli();

    // detail
    function initailizeSelect2_cabang() {
      $('.select2_cabang').select2({
        allowClear: true,
        placeholder: $(this).data('placeholder'),
        multiple: false,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?= site_url('Select2_master/data_cabang'); ?>",
          type: "POST",
          dataType: 'JSON',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_role() {
      $('.select2_role').select2({
        allowClear: true,
        placeholder: $(this).data('placeholder'),
        multiple: false,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?= site_url('Select2_master/data_role'); ?>",
          type: "POST",
          dataType: 'JSON',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_satuan(cabang) {
      $('.select2_satuan').select2({
        allowClear: true,
        placeholder: $(this).data('placeholder'),
        multiple: false,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?= site_url('Select2_master/data_satuan/'); ?>" + cabang,
          type: "POST",
          dataType: 'JSON',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_kategori(cabang) {
      $('.select2_kategori').select2({
        allowClear: true,
        placeholder: $(this).data('placeholder'),
        multiple: false,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?= site_url('Select2_master/data_kategori/'); ?>" + cabang,
          type: "POST",
          dataType: 'JSON',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_supplier(cabang) {
      $('.select2_supplier').select2({
        allowClear: true,
        placeholder: $(this).data('placeholder'),
        multiple: false,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?= site_url('Select2_master/data_supplier/'); ?>" + cabang,
          type: "POST",
          dataType: 'JSON',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_gudang(cabang) {
      $('.select2_gudang').select2({
        allowClear: true,
        placeholder: $(this).data('placeholder'),
        multiple: false,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?= site_url('Select2_master/data_gudang/'); ?>" + cabang,
          type: "POST",
          dataType: 'JSON',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_ppn() {
      $('.select2_ppn').select2({
        allowClear: false,
        placeholder: $(this).data('placeholder'),
        multiple: false,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?= site_url('Select2_master/data_ppn/'); ?>",
          type: "POST",
          dataType: 'JSON',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_barang(cabang) {
      $('.select2_barang').select2({
        allowClear: true,
        placeholder: $(this).data('placeholder'),
        multiple: false,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?= site_url('Select2_master/data_barang/'); ?>" + cabang,
          type: "POST",
          dataType: 'JSON',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_po(cabang) {
      $('.select2_po').select2({
        allowClear: true,
        placeholder: $(this).data('placeholder'),
        multiple: false,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?= site_url('Select2_master/data_po/'); ?>" + cabang,
          type: "POST",
          dataType: 'JSON',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_penerimaan(cabang) {
      $('.select2_penerimaan').select2({
        allowClear: true,
        placeholder: $(this).data('placeholder'),
        multiple: false,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?= site_url('Select2_master/data_penerimaan/'); ?>" + cabang,
          type: "POST",
          dataType: 'JSON',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_pembeli() {
      $('.select2_pembeli').select2({
        allowClear: false,
        placeholder: $(this).data('placeholder'),
        multiple: false,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?= site_url('Select2_master/data_pembeli/'); ?>",
          type: "POST",
          dataType: 'JSON',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }

    function initailizeSelect2_barang_jual(cabang, gudang) {
      $('.select2_barang_jual').select2({
        allowClear: true,
        placeholder: $(this).data('placeholder'),
        multiple: false,
        dropdownAutoWidth: true,
        language: {
          inputTooShort: function() {
            return 'Ketikan Nomor minimal 2 huruf';
          }
        },
        ajax: {
          url: "<?= site_url('Select2_master/data_barang_jual/'); ?>" + cabang + "?gudang=" + gudang,
          type: "POST",
          dataType: 'JSON',
          delay: 100,
          data: function(params) {
            return {
              searchTerm: params.term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        }
      });
    }
  </script>

  <!-- Bootstrap 4 -->
  <script src="<?= base_url('tema'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="<?= base_url('tema'); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?= base_url('tema'); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url('tema'); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url('tema'); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="<?= base_url('tema'); ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="<?= base_url('tema'); ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="<?= base_url('tema'); ?>/plugins/jszip/jszip.min.js"></script>
  <script src="<?= base_url('tema'); ?>/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="<?= base_url('tema'); ?>/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="<?= base_url('tema'); ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="<?= base_url('tema'); ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="<?= base_url('tema'); ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <!-- Bootstrap 4 -->
  <script src="<?= base_url('tema'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= base_url('tema'); ?>/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?= base_url('tema'); ?>/dist/js/demo.js"></script>

  <script>
    function formatRupiah(val) {
      var sign = 1;
      if (val < 0) {
        sign = -1;
        val = -val;
      }
      let num = val.toString().includes('.') ? val.toString().split('.')[0] : val.toString();
      let len = num.toString().length;
      let result = '';
      let count = 1;
      for (let i = len - 1; i >= 0; i--) {
        result = num.toString()[i] + result;
        if (count % 3 === 0 && count !== 0 && i !== 0) {
          result = ',' + result;
        }
        count++;
      }
      if (val.toString().includes('.')) {
        result = result + '.' + val.toString().split('.')[1];
      }
      return sign < 0 ? '-' + result : result;
    }

    <?php if (($user->nama == null || $user->nohp == null || $user->alamat == null || $user->nama == "" || $user->nohp == "" || $user->alamat == "") && $this->session->userdata("info") == 0) : ?>
      $("#modal1").modal("show");
    <?php else : ?>
      $("#modal1").modal("hide");
    <?php endif; ?>

    function keluar(param) {
      Swal.fire({
        title: 'KELUAR',
        text: "Yakin ingin meninggalkan sistem ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, keluar sistem',
        cancelButtonText: 'Tetap di sistem'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= site_url('Auth/keluar/'); ?>" + param,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              if (data.status == 1) {
                Swal.fire({
                  icon: 'success',
                  title: 'KELUAR',
                  text: 'Berhasil dilakukan',
                }).then((result) => {
                  location.href = "<?= site_url('Auth'); ?>";
                })
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'KELUAR',
                  text: 'Gagal diaktifkan',
                })
              }
            }
          });
        }
      })
    }

    function hapus_pesan(isi, url) {
      $.ajax({
        url: "<?= site_url('Home/hapus_pesan/'); ?>" + isi + "?url=" + url,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            location.href = "<?= site_url('"+data.url+"'); ?>";
          } else {
            location.href = "<?= site_url('"+data.url+"'); ?>";
          }
        }
      });
    }

    function cek_eye() {
      var input = document.getElementById('password');
      if (input.type === "password") {
        input.type = "text";
        $("#e_close").hide();
        $("#e_open").show();
        $("#group_eye").removeClass("bg-danger");
        $("#group_eye").addClass("bg-primary");
      } else {
        input.type = "password";
        $("#e_close").show();
        $("#e_open").hide();
        $("#group_eye").removeClass("bg-primary");
        $("#group_eye").addClass("bg-danger");
      }
    }
  </script>

  <!-- datatable -->
  <script>
    // ============================================================== DEFAULT
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "scrollCollapse": false,
        "paging": true,
        "oLanguage": {
          "sEmptyTable": "<div class='text-center'>Data Kosong</div>",
          "sInfoEmpty": "",
          "sInfoFiltered": " - Dipilih dari _END_ data",
          "sSearch": "Cari : ",
          "sInfo": "Data (_START_ - _END_)",
          "sLengthMenu": "_MENU_ Baris",
          "sLoadingRecords": "Loading...",
          "sProcessing": "Tunggu Sebentar... Loading...",
          "sZeroRecords": "Tida ada data",
          "oPaginate": {
            "sPrevious": "Sebelumnya",
            "sNext": "Berikutnya"
          },
        },
        "aLengthMenu": [
          [5, 15, 20, -1],
          [5, 15, 20, "Semua"]
        ],
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

      $("#example2").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "scrollCollapse": false,
        "paging": true,
        "oLanguage": {
          "sEmptyTable": "<div class='text-center'>Data Kosong</div>",
          "sInfoEmpty": "",
          "sInfoFiltered": " - Dipilih dari _END_ data",
          "sSearch": "Cari : ",
          "sInfo": "Data (_START_ - _END_)",
          "sLengthMenu": "_MENU_ Baris",
          "sLoadingRecords": "Loading...",
          "sProcessing": "Tunggu Sebentar... Loading...",
          "sZeroRecords": "Tida ada data",
          "oPaginate": {
            "sPrevious": "Sebelumnya",
            "sNext": "Berikutnya"
          },
        },
        "aLengthMenu": [
          [5, 15, 20, -1],
          [5, 15, 20, "Semua"]
        ],
      }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

      $("#table-standar").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "scrollCollapse": false,
        "paging": true,
        "oLanguage": {
          "sEmptyTable": "<div class='text-center'>Data Kosong</div>",
          "sInfoEmpty": "",
          "sInfoFiltered": " - Dipilih dari _END_ data",
          "sSearch": "Cari : ",
          "sInfo": "Data (_START_ - _END_)",
          "sLengthMenu": "_MENU_ Baris",
          "sLoadingRecords": "Loading...",
          "sProcessing": "Tunggu Sebentar... Loading...",
          "sZeroRecords": "Tida ada data",
          "oPaginate": {
            "sPrevious": "Sebelumnya",
            "sNext": "Berikutnya"
          },
        },
        "aLengthMenu": [
          [5, 15, 20, -1],
          [5, 15, 20, "Semua"]
        ],
      });
    });

    // =============================================================== CUSTOM
    // initial
    var table_po;
    var table_terima;
    var table_retur;
    var table_jual;

    table_po = $('#example1-po').DataTable({
      destroy: true,
      "processing": true,
      "responsive": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= site_url('Pembelian/po_list/1') ?>",
        "type": "POST"
      },
      "scrollCollapse": false,
      "paging": true,
      "oLanguage": {
        "sEmptyTable": "<div class='text-center'>Data Kosong</div>",
        "sInfoEmpty": "",
        "sInfoFiltered": " - Dipilih dari _TOTAL_ data",
        "sSearch": "Cari : ",
        "sInfo": " Jumlah _TOTAL_ Data (_START_ - _END_)",
        "sLengthMenu": "_MENU_ Baris",
        "sZeroRecords": "<div class='text-center'>Data Kosong</div>",
        "oPaginate": {
          "sPrevious": "Sebelumnya",
          "sNext": "Berikutnya"
        }
      },
      "aLengthMenu": [
        [5, 15, 20, -1],
        [5, 15, 20, "Semua"]
      ],
      "columnDefs": [{
        "targets": [-1],
        "orderable": false,
      }, ],
    });

    table_terima = $('#example1-terima').DataTable({
      destroy: true,
      "processing": true,
      "responsive": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= site_url('Pembelian/terima_list/1') ?>",
        "type": "POST"
      },
      "scrollCollapse": false,
      "paging": true,
      "oLanguage": {
        "sEmptyTable": "<div class='text-center'>Data Kosong</div>",
        "sInfoEmpty": "",
        "sInfoFiltered": " - Dipilih dari _TOTAL_ data",
        "sSearch": "Cari : ",
        "sInfo": " Jumlah _TOTAL_ Data (_START_ - _END_)",
        "sLengthMenu": "_MENU_ Baris",
        "sZeroRecords": "<div class='text-center'>Data Kosong</div>",
        "oPaginate": {
          "sPrevious": "Sebelumnya",
          "sNext": "Berikutnya"
        }
      },
      "aLengthMenu": [
        [5, 15, 20, -1],
        [5, 15, 20, "Semua"]
      ],
      "columnDefs": [{
        "targets": [-1],
        "orderable": false,
      }, ],
    });

    table_retur = $('#example1-retur').DataTable({
      destroy: true,
      "processing": true,
      "responsive": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= site_url('Pembelian/retur_list/1') ?>",
        "type": "POST"
      },
      "scrollCollapse": false,
      "paging": true,
      "oLanguage": {
        "sEmptyTable": "<div class='text-center'>Data Kosong</div>",
        "sInfoEmpty": "",
        "sInfoFiltered": " - Dipilih dari _TOTAL_ data",
        "sSearch": "Cari : ",
        "sInfo": " Jumlah _TOTAL_ Data (_START_ - _END_)",
        "sLengthMenu": "_MENU_ Baris",
        "sZeroRecords": "<div class='text-center'>Data Kosong</div>",
        "oPaginate": {
          "sPrevious": "Sebelumnya",
          "sNext": "Berikutnya"
        }
      },
      "aLengthMenu": [
        [5, 15, 20, -1],
        [5, 15, 20, "Semua"]
      ],
      "columnDefs": [{
        "targets": [-1],
        "orderable": false,
      }, ],
    });

    table_jual = $('#example1-jual').DataTable({
      destroy: true,
      "processing": true,
      "responsive": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?= site_url('Penjualan_barang/jual_list/1') ?>",
        "type": "POST"
      },
      "scrollCollapse": false,
      "paging": true,
      "oLanguage": {
        "sEmptyTable": "<div class='text-center'>Data Kosong</div>",
        "sInfoEmpty": "",
        "sInfoFiltered": " - Dipilih dari _TOTAL_ data",
        "sSearch": "Cari : ",
        "sInfo": " Jumlah _TOTAL_ Data (_START_ - _END_)",
        "sLengthMenu": "_MENU_ Baris",
        "sZeroRecords": "<div class='text-center'>Data Kosong</div>",
        "oPaginate": {
          "sPrevious": "Sebelumnya",
          "sNext": "Berikutnya"
        }
      },
      "aLengthMenu": [
        [5, 15, 20, -1],
        [5, 15, 20, "Semua"]
      ],
      "columnDefs": [{
        "targets": [-1],
        "orderable": false,
      }, ],
    });
  </script>
</body>

</html>