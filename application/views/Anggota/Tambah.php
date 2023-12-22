<section class="content">
  <form method="POST" id="form-tambah">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?= $judul; ?></h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="h4">DATA DIRI <a class="btn btn-flat btn-danger float-right" href="<?= site_url('Master/anggota'); ?>" type="button" title="Kembali"><i class="fa-solid fa-backward"></i></a></div>
        <br>
        <div class="row">
          <div class="col-4 text-center">
            <div class="mb-3">
              <img id="preview_img" src="#" alt="Preview Foto" style="width: 100%;" class="rounded img-thumbnail" />
              <span class="help-block"></span>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Unggah</span>
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="filefoto" name="filefoto" accept=".jpg,.jpeg,.png">
                <label class="custom-file-label">Pilih Foto</label>
              </div>
            </div>
          </div>
          <div class="col-8">
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="username" name="username" placeholder="Username..." onchange="cekusername(this.value)">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa-regular fa-address-card"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password...">
              <div class="input-group-append">
                <div class="input-group-text bg-danger" id="group_eye">
                  <span class="fa-solid fa-eye-slash" title="Tampilkan" id="e_close" type="button" onclick="cek_eye(0)"></span>
                  <span class="fa-solid fa-eye" id="e_open" title="Sembunyikan" type="button" onclick="cek_eye(1)"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap...">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa-solid fa-id-card-clip"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <select id="id_role" name="id_role" class="form-control select2_all" data-placeholder="Pilih Tingkatan...">
                <option value="">Pilih Tingkatan...</option>
                <?php foreach ($role as $r) : ?>
                  <option value="<?= $r->id_role; ?>"><?= $r->tingkatan; ?></option>
                <?php endforeach; ?>
              </select>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa-solid fa-network-wired"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="number" class="form-control" id="nohp" name="nohp" placeholder="Nomor Hp...">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa-solid fa-phone"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat..."></textarea>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa-solid fa-location-crosshairs"></span>
                </div>
              </div>
            </div>
            <button type="button" class="btn btn-sm btn-flat float-right btn-primary" title="Tambahkan Anggota" id="btnsave" onclick="simpan()"><i class="fa-solid fa-user-plus"></i></button>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>

<script>
  // first load
  $(document).ready(function() {
    $("#preview_img").attr('src', "<?= base_url('assets/user/default.png'); ?>");
    $("#e_open").hide();
  });

  // lihat password
  let btn = document.querySelector('#cek');
  let input = document.querySelector('#password');

  btn.addEventListener('click', () => {
    if (input.type === "password") {
      input.type = "text"
      $("#show_reg").prop("checked", true);
      $("#show_log").prop("checked", true);
    } else {
      input.type = "password"
      $("#show_reg").prop("checked", false);
      $("#show_log").prop("checked", false);
    }
  })

  // when photo has been change
  $("#filefoto").change(function() {
    readURL(this);
  });

  // preview image
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#div_preview_foto').css("display", "block");
        $('#preview_img').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    } else {
      $('#div_preview_foto').css("display", "none");
      $('#preview_img').attr('src', '');
    }
  }

  // cek username
  function cekusername(param) {
    $.ajax({
      url: "<?= site_url('Auth/cekusername_reg/'); ?>" + param,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        if (data.status == 1) {
          Swal.fire({
            icon: 'error',
            html: '<span class="text-danger h4 font-weight-bold">TAMBAH ANGGOTA</span><br><b>' + param.toUpperCase() + '</b><br><br>Username sudah digunakan!',
          }).then((result) => {
            $("#username").val('');
            $("#password").val('');
          });
        }
      }
    });
  }

  // simpan
  function simpan() {
    var username = $("#username").val();
    var password = $("#password").val();
    var nama = $("#nama").val();
    var nohp = $("#nohp").val();
    var alamat = $("#alamat").val();
    if (username != '' && password != '' && nama != '' && nohp != '' && alamat != '') {
      var form = $('#form-tambah')[0];
      var data = new FormData(form);
      $.ajax({
        url: "<?= site_url('Master/tambah_anggota_aksi'); ?>",
        type: "POST",
        enctype: 'multipart/form-data',
        data: data,
        dataType: "JSON",
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function(data) {
          if (data.status == 1) {
            Swal.fire({
              icon: 'success',
              html: '<span class="text-success h4 font-weight-bold">TAMBAH ANGGOTA</span><br><b>' + username.toUpperCase() + '</b><br><br>Berhasil ditambahkan, silahkan melakukan aktifasi akun!',
            }).then((result) => {
              location.href = "<?= site_url('Master/anggota'); ?>";
            });
          } else {
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">TAMBAH ANGGOTA</span><br><b>' + username.toUpperCase() + '</b><br><br>Gagal ditambahkan!',
            });
          }
        }
      });
    } else {
      Swal.fire({
        icon: 'error',
        html: '<span class="text-warning h4 font-weight-bold">TAMBAH ANGGOTA</span><br><br>Data diri belum lengkap!',
      })
    }
  }
</script>