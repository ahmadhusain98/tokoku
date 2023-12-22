<div class="row">
  <div class="col-sm-12">
    <form id="form-regist" method="post">
      <div class="login-box">
        <div class="card card-outline card-primary">
          <div class="card-header text-center">
            <b class="h1"><i class="fa-brands fa-shopify text-danger"></i> <span class="text-danger">Toko</span><span class="text-primary">ku</span></b>
          </div>
          <div class="card-body">
            <p class="login-box-msg">Ayo Bergabung</p>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="username" name="username" placeholder="Username..." onchange="cekusername(this.value)" style="width: 85%;">
              <div class="input-group-append" style="width: 15%;">
                <div class="input-group-text">
                  <span class="fa-regular fa-address-card"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <select name="jk" id="jk" class="form-control select2_all" data-placeholder="Pilih Gender..." style="width: 85%;">
                <option value="">Pilih Gender...</option>
                <option value="P">Pria</option>
                <option value="W">Wanita</option>
              </select>
              <div class="input-group-append" style="width: 15%;">
                <div class="input-group-text">
                  <i class="fa-solid fa-mars-and-venus"></i>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password..." style="width: 85%;">
              <div class="input-group-append" style="width: 15%;">
                <div class="input-group-text bg-danger" id="rgroup_eye">
                  <span class="fa-solid fa-eye-slash" title="Tampilkan" id="re_close" type="button" onclick="cek_eye(0)"></span>
                  <span class="fa-solid fa-eye" id="re_open" title="Sembunyikan" type="button" onclick="cek_eye(1)"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-8" style="margin-bottom: 5px;">
                <a type="button" class="btn btn-danger btn-block btn-flat" href="<?= site_url('Auth'); ?>">Sudah punya akun</a>
              </div>
              <div class="col-sm-4">
                <button type="button" class="btn btn-primary btn-block btn-flat" onclick="daftar()">Daftar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  $(document).ready(function() {
    $("#re_open").hide();
  });

  function cekusername(param) {
    $.ajax({
      url: "<?= site_url('Auth/cekusername_reg/'); ?>" + param,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        if (data.status == 1) {
          Swal.fire({
            icon: 'error',
            title: 'USERNAME',
            text: 'Sudah digunakan',
          }).then((result) => {
            $("#username").val('');
            $("#password").val('');
          });
        }
      }
    });
  }

  function daftar() {
    var username = $("#username").val();
    var jk = $("#jk").val();
    var password = $("#password").val();
    if (username != '' && password != '' && jk != '') {
      $.ajax({
        url: "<?= site_url('Auth/register'); ?>",
        type: "POST",
        data: ($('#form-regist').serialize()),
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            Swal.fire({
              icon: 'success',
              title: 'USER ' + username.toUpperCase(),
              text: 'Berhasil didaftarkan, silahkan minta aktifasi di menu login untuk mengaktifkan akun',
            }).then((result) => {
              location.href = "<?= site_url('Auth'); ?>";
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'USER ' + username.toUpperCase(),
              text: 'Gagal didaftarkan',
            });
          }
        }
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'DATA DIRI',
        text: 'Belum lengkap',
      })
    }
  }
</script>