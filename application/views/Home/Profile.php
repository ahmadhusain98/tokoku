<style>
  .dataTables_filter {
    display: none;
  }
</style>
<?php
if ($user->is_active == 1) {
  $status = 'Aktif';
} else {
  $status = '';
}
if ($user->on_off == 1) {
  $on_off = 'border-success';
} else {
  $on_off = '';
}
?>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img id="preview_img" class="profile-user-img img-fluid img-circle <?= $on_off; ?>" src="<?= base_url('assets/user/') . $user->gambar; ?>" alt="User profile picture">
            </div>
            <h3 class="profile-username text-center"><?= strtoupper($user->nama); ?></h3>
            <p class="text-muted text-center"><?= $user->tingkatan; ?></p>
            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Pengikut</b> <a class="float-right">
                  <?php if ($folling > 0) {
                    echo $folling;
                  } else {
                    echo 0;
                  } ?>
                </a>
              </li>
              <li class="list-group-item">
                <b>Mengikuti</b> <a class="float-right">
                  <?php if ($followers > 0) {
                    echo $followers;
                  } else {
                    echo 0;
                  } ?>
                </a>
              </li>
              <li class="list-group-item">
                <b>Bergabung</b> <a class="float-right"><?= date("d M Y", strtotime($user->is_create)); ?></a>
              </li>
            </ul>
          </div>
        </div>
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Tentang Aku</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <strong><i class="fa-regular fa-calendar-days mr-1"></i> Berjabung Sejak</strong>
            <p class="text-muted"><?= date("d M Y", strtotime($user->is_create)); ?></p>
            <hr>
            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
            <p class="text-muted"><?= $user->alamat; ?></p>
            <hr>
            <strong><i class="fa-solid fa-mobile-screen mr-1"></i> Nomor Hp/Telp</strong>
            <p class="text-muted"><?= $user->nohp; ?></p>
            <hr>
            <strong><i class="fa-solid fa-power-off mr-1"></i> Status Akun</strong>
            <p class="text-muted"><?= $status; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
              <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Change Password</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <div class="row">
                  <div class="col">
                    <div class="table-responsive">
                      <div class="h4 text-primary font-weight-bold">Keluar / Masuk Sistem</div>
                      <table class="table table-bordered table-striped">
                        <thead>
                          <tr class="text-center">
                            <th>Tanggal Masuk</th>
                            <th>Jam Masuk</th>
                            <th>Tanggal Keluar</th>
                            <th>Jam Keluar</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $hari = date("D", strtotime($in_out->tgl_masuk));
                          $hari2 = date("D", strtotime($in_out->tgl_keluar));

                          switch ($hari) {
                            case 'Sun':
                              $hari_masuk = "Minggu";
                              break;

                            case 'Mon':
                              $hari_masuk = "Senin";
                              break;

                            case 'Tue':
                              $hari_masuk = "Selasa";
                              break;

                            case 'Wed':
                              $hari_masuk = "Rabu";
                              break;

                            case 'Thu':
                              $hari_masuk = "Kamis";
                              break;

                            case 'Fri':
                              $hari_masuk = "Jumat";
                              break;

                            case 'Sat':
                              $hari_masuk = "Sabtu";
                              break;

                            default:
                              $hari_masuk = "Tidak di ketahui";
                              break;
                          }

                          switch ($hari2) {
                            case 'Sun':
                              $hari_keluar = "Minggu";
                              break;

                            case 'Mon':
                              $hari_keluar = "Senin";
                              break;

                            case 'Tue':
                              $hari_keluar = "Selasa";
                              break;

                            case 'Wed':
                              $hari_keluar = "Rabu";
                              break;

                            case 'Thu':
                              $hari_keluar = "Kamis";
                              break;

                            case 'Fri':
                              $hari_keluar = "Jumat";
                              break;

                            case 'Sat':
                              $hari_keluar = "Sabtu";
                              break;

                            default:
                              $hari_keluar = "Tidak di ketahui";
                              break;
                          }
                          ?>
                          <tr>
                            <td><?= $hari_masuk . ", " . date('d M Y', strtotime($in_out->tgl_masuk)); ?></td>
                            <td><?= date("H:i:s", strtotime($in_out->jam_masuk)); ?></td>
                            <td><?= $hari_keluar . ", " . date('d M Y', strtotime($in_out->tgl_masuk)); ?></td>
                            <td><?= date("H:i:s", strtotime($in_out->jam_keluar)); ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col">
                    <div class="row">
                      <div class="col-sm-9" style="margin-bottom: 5px;">
                        <div class="h4 text-primary font-weight-bold">Aktifitas Ketika di dalam Sistem</div>
                      </div>
                      <div class="col-sm-3">
                        <input type="date" class="form-control float-right" name="tgl" id="tgl" value="<?= date('Y-m-d'); ?>" onchange="lihat_aktifitas(this.value)">
                      </div>
                    </div>
                    <div id="cekaktif_user">
                      <?php if ($aktifitas) : ?>
                        <br>
                        <span class="badge bg-danger float-right shadow">Banyaknya aktifitas : <?= $jum_aktif; ?></span>
                        <br>
                        <div class="card shadow">
                          <div class="card-body">
                            <div class="table-responsive">
                              <table width="100%">
                                <?php foreach ($aktifitas as $au) { ?>
                                  <tr>
                                    <td width="14%" class="text-left"><span class="badge bg-success"><?= date("d m Y", strtotime($au->waktu)); ?></span></td>
                                    <td width="20%" class="text-left"><?= $au->menu; ?></td>
                                    <td width="46%" class="text-left"><?= $au->kegiatan; ?></td>
                                    <td width="20%" class="text-right">Jam : <?= date("H:i", strtotime($au->waktu)); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="4">
                                      <hr>
                                    </td>
                                  </tr>
                                <?php } ?>
                              </table>
                            </div>
                          </div>
                        </div>
                      <?php else : ?>
                        <br>
                        <div class="row">
                          <div class="col">
                            <span class="badge bg-danger float-right shadow">Banyaknya aktifitas : 0</span>
                            <br>
                            <div class="card shadow">
                              <div class="card-body">
                                <span class="text-center">Tidak ada aktifitas</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="settings">
                <form class="form-horizontal" id="form-profile" method="POST">
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Profile</label>
                    <div class="col-sm-10">
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="filefoto" aria-describedby="inputGroupFileAddon01" name="filefoto">
                          <label class="custom-file-label" for="inputGroupFile01">Cari Gambar</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= $user->username; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Tingkatan</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="id_role" name="id_role" placeholder="Tingkatan" value="<?= $user->tingkatan; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputName2" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?= $user->nama; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputExperience" class="col-sm-2 col-form-label">Nomor Hp/Telp</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nohp" name="nohp" placeholder="Nomor Hp/Telp" value="<?= $user->nohp; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputSkills" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat"><?= $user->alamat; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="button" class="btn btn-danger btn-flat float-right" onclick="simpan_profile('<?= $user->id_user; ?>')">Perbarui Data Diri&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-hard-drive"></i></button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane" id="password">
                <form method="post" id="form-password">
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Password Baru</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password1" name="password1" placeholder="Password Baru">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Ulangi</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password2" name="password2" placeholder="Ulangi">
                    </div>
                  </div>
                  <div class="form-check mb-3" id="cek">
                    <div class="row">
                      <div class="col-sm-2"></div>
                      <div class="col-sm-10">
                        <div class="row">
                          <div class="col-sm-11">
                            <label class="form-check-label float-right" for="exampleCheck1">Lihat password</label>
                          </div>
                          <div class="col-sm-1">
                            <input type="checkbox" class="form-control float-right" id="show_log">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <button class="btn btn-flat btn-success float-right" type="button" id="btnpassword" onclick="c_pas()">Simpan Password Baru <i class="fa-solid fa-key"></i></button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function simpan_profile(id) {
    Swal.fire({
      title: 'PERBARUI',
      text: "Yakin ingin memperbarui data diri ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, perbarui data diri',
      cancelButtonText: 'Tidak, perbarui data diri',
    }).then((result) => {
      if (result.isConfirmed) {
        var form = $('#form-profile')[0];
        var data = new FormData(form);
        $.ajax({
          url: "<?= site_url('Profile/perbarui/'); ?>" + id,
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
                title: 'PERBARUI DATA',
                text: 'Berhasil memperbarui',
              }).then((result) => {
                location.href = "<?= site_url('Profile'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'PERBARUI DATA',
                text: 'Berhasil memperbarui',
              });
            }
          }
        });
      }
    })
  }

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

  // aktifitas
  function lihat_aktifitas(params) {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("cekaktif_user").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "<?php echo base_url(); ?>Profile/aktifitas_user/" + params, true);
    xhttp.send();
  }

  let btn = document.querySelector('#cek');
  let input = document.querySelector('#password1');
  let input2 = document.querySelector('#password2');

  btn.addEventListener('click', () => {
    if (input.type === "password" || input2.type === "password") {
      input.type = "text"
      input2.type = "text"
      document.getElementById('show_log').checked = true;
    } else {
      input.type = "password"
      input2.type = "password"
      document.getElementById('show_log').checked = false;
    }
  })

  function c_pas() {
    var pass1 = $("#password1").val();
    var pass2 = $("#password2").val();
    if (pass1 == '') {
      Swal.fire({
        icon: 'error',
        title: 'PASSWORD BARU',
        text: 'Tidak boleh kosong!',
      });
      return;
    }
    if (pass2 == '') {
      Swal.fire({
        icon: 'error',
        title: 'ULANGI',
        text: 'Tidak boleh kosong!',
      });
      return;
    }
    if (pass1 != pass2) {
      Swal.fire({
        icon: 'error',
        title: 'PASSWORD BARU DAN ULANG',
        text: 'Tidak sama!',
      });
    } else {
      $.ajax({
        url: "<?= site_url('Profile/ubah_password/') ?>" + pass1,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            Swal.fire({
              icon: 'success',
              html: '<span class="text-success h4 font-weight-bold">UBAH PASSWORD</span><br><br>Berhasil dilakukan',
            }).then((result) => {
              location.href = "<?= site_url('Profile'); ?>";
            });
          } else {
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">UBAH PASSWORD</span><br><br>Gagal dilakukan',
            });
          }
        }
      });
    }
  }
</script>