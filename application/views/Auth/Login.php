<div class="row mb-3">
  <div class="col-sm-12">
    <form id="form-login" method="post">
      <div class="login-box">
        <div class="card card-outline card-primary">
          <div class="card-header text-center">
            <b class="h1"><i class="fa-brands fa-shopify text-danger"></i> <span class="text-danger">Toko</span><span class="text-primary">ku</span></b>
          </div>
          <div class="card-body">
            <p class="login-box-msg">Selamat Datang</p>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="username" name="username" placeholder="Username..." onchange="cekuser(this.value)" style="width: 85%;">
              <div class="input-group-append" style="width: 15%;">
                <div class="input-group-text">
                  <span class="fa-regular fa-address-card"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password..." style="width: 85%;">
              <div class="input-group-append" style="width: 15%;">
                <div class="input-group-text bg-danger" id="group_eye">
                  <span class="fa-solid fa-eye-slash" title="Tampilkan" id="e_close" type="button" onclick="cek_eye(0)"></span>
                  <span class="fa-solid fa-eye" id="e_open" title="Sembunyikan" type="button" onclick="cek_eye(1)"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3 forPengelola">
              <select name="cabang" id="cabang" class="form-control select2_all" data-placeholder="Pilih Cabang..." style="width: 85%;"></select>
              <div class="input-group-append" style="width: 15%;">
                <div class="input-group-text">
                  <span class="fa-solid fa-network-wired"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3 forPengelola">
              <select name="absen" id="absen" class="form-control select2_all" data-placeholder="Pilih Absensi..." style="width: 85%;">
                <option value="">Pilih Absensi...</option>
                <option value="1">Hadir</option>
                <option value="2">Izin</option>
                <option value="3">Sakit</option>
              </select>
              <div class="input-group-append" style="width: 15%;">
                <div class="input-group-text">
                  <span class="fa-solid fa-book-open"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-8" style="margin-bottom: 5px;">
                <a type="button" class="btn btn-danger btn-block btn-flat" href="<?= site_url('Auth/regist'); ?>">Belum punya akun</a>
              </div>
              <div class="col-sm-4">
                <button type="button" class="btn btn-primary btn-block btn-flat" onclick="masuk()">Masuk</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    <br>
    <button type="button" class="btn btn-success btn-sm btn-flat float-right" onclick="aktif_akun()"><i class="fa fa-paper-plane"></i> Aktifasi Akun</button>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#e_open").hide();
    $("#forPengelola").hide();
  });

  function aktif_akun() {
    Swal.fire({
      text: "Username yang di daftarkan : ",
      icon: 'info',
      input: 'text',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Minta Aktifasi',
      cancelButtonText: 'Batal',
    }).then(function(username) {
      $.ajax({
        url: "<?= site_url('Auth/cekua'); ?>",
        data: {
          username: username.value
        },
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $.ajax({
              url: "<?= site_url('Auth/cekuseraktifasi'); ?>",
              data: {
                username: username.value
              },
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                if (data.status == 1) {
                  var username = data.username;
                  $.ajax({
                    url: "<?= site_url('Auth/cekpengajuan/') ?>" + username,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                      if (data.status == 1) {
                        $.ajax({
                          url: "<?= site_url('Auth/minta/'); ?>" + username,
                          type: "POST",
                          dataType: "JSON",
                          success: function(data) {
                            if (data.status == 1) {
                              Swal.fire({
                                icon: 'success',
                                title: 'AKTIFASI',
                                text: 'Berhasil diajukan, mohon tunggu untuk diaktifasi',
                              });
                            } else {
                              Swal.fire({
                                icon: 'error',
                                title: 'AKTIFASI',
                                text: 'Gagal diajukan',
                              });
                            }
                          }
                        });
                      } else {
                        Swal.fire({
                          icon: 'error',
                          title: 'USERNAME',
                          text: 'Sedang proses aktifasi, mohon ditunggu',
                        });
                      }
                    }
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'AKUN',
                    text: 'Tidak ditemukan',
                  });
                }
              }
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'AKUN',
              text: 'Sudah aktif, silahkan login',
            });
          }
        }
      });
    })
  }

  function cekuser(param) {
    $.ajax({
      url: "<?= site_url('Auth/cekuser/'); ?>" + param,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        if (data.status == 1) {
          Swal.fire({
            icon: 'error',
            title: 'USER ' + param,
            text: 'Belum terdaftar',
          });
        } else {
          $.ajax({
            url: "<?= site_url('Auth/cekatifuser/'); ?>" + param,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              if (data.status == 1) {
                Swal.fire({
                  icon: 'error',
                  title: 'USER ' + param,
                  text: 'Belum diaktifasi, silahkan minta aktifasi',
                });
              } else {
                $("#forPengelola").show();
                $.ajax({
                  url: "<?= site_url('Auth/cekcabang/'); ?>" + param,
                  type: "POST",
                  dataType: "JSON",
                  success: function(data) {
                    var opt = data;
                    var op_cabang = $("#cabang");
                    op_cabang.empty();
                    $(opt).each(function() {
                      var option = $("<option/>");
                      option.html(this.nama_cabang);
                      option.val(this.kode_cabang);
                      op_cabang.append(option);
                    });
                  }
                });
              }
            }
          });
        }
      }
    });
  }

  function masuk() {
    var username = $("#username").val();
    var password = $("#password").val();
    var cabang = $("#cabang").val();
    if (username == '' && password == '' && cabang == '' || cabang == null) {
      Swal.fire({
        icon: 'error',
        title: 'DATA MASUK',
        text: 'Belum lengkap, silahkan lengkapi data terlebih dahulu',
      });
    } else {
      $.ajax({
        url: "<?= site_url('Auth/cekpass_log'); ?>",
        type: "POST",
        data: ($('#form-login').serialize()),
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            let timerInterval
            Swal.fire({
              title: 'PROSES MASUK',
              html: 'Mohon tunggu <b></b> beberapa detik.',
              timer: 1000,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                  b.textContent = Swal.getTimerLeft()
                }, 100)
              },
              willClose: () => {
                clearInterval(timerInterval)
              }
            }).then((result) => {
              if (result.dismiss === Swal.DismissReason.timer) {
                location.href = "<?= site_url('Home'); ?>";
              }
            })
          } else {
            Swal.fire({
              icon: 'error',
              title: 'DATA USER',
              text: 'Ada yang salah',
            });
          }
        }
      });
    }
  }
</script>