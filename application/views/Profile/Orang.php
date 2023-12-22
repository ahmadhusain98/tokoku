<style>
  .dataTables_filter {
    display: none;
  }
</style>
<?php
if ($orang->is_active == 1) {
  $status = 'Aktif';
} else {
  $status = '';
}
if ($orang->on_off == 1) {
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
              <img id="preview_img" class="profile-user-img img-fluid img-circle <?= $on_off; ?>" src="<?= base_url('assets/user/') . $orang->gambar; ?>" alt="User profile picture">
            </div>
            <h3 class="profile-username text-center"><?= strtoupper($orang->nama); ?></h3>
            <p class="text-muted text-center"><?= $orang->tingkatan; ?></p>
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
                <b>Bergabung</b> <a class="float-right"><?= date("d M Y", strtotime($orang->is_create)); ?></a>
              </li>
            </ul>
            <a href="<?= site_url('Profile/chat/') . $orang->id_user; ?>" type="button" class="btn btn-sm bg-danger btn-flat btn-block">
              Pesan
            </a>
            <?php if ($this->db->query("SELECT * FROM follow WHERE id_user_dari = '$user->id_user' AND id_user_ke = '$orang->id_user'")->num_rows() > 0) { ?>
              <button type="button" class="btn btn-sm bg-dark btn-flat btn-block" onclick="unfollow('<?= $orang->id_user; ?>', '<?= $orang->nama; ?>')">
                Unfollow
              </button>
            <?php } else if ($this->db->query("SELECT * FROM follow WHERE id_user_ke = '$user->id_user' AND id_user_dari = '$orang->id_user'")->num_rows() > 0) { ?>
              <button type="button" class="btn btn-sm bg-secondary btn-flat btn-block" onclick="follow('<?= $orang->id_user; ?>', '<?= $orang->nama; ?>')">
                Follow Back
              </button>
            <?php } else { ?>
              <button type="button" class="btn btn-sm btn-flat btn-block btn-primary" onclick="follow('<?= $orang->id_user; ?>', '<?= $orang->nama; ?>')">Follow</button>
            <?php } ?>
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
            <p class="text-muted"><?= date("d M Y", strtotime($orang->is_create)); ?></p>
            <hr>
            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
            <p class="text-muted"><?= $orang->alamat; ?></p>
            <hr>
            <strong><i class="fa-solid fa-mobile-screen mr-1"></i> Nomor Hp/Telp</strong>
            <p class="text-muted"><?= $orang->nohp; ?></p>
            <hr>
            <strong><i class="fa-solid fa-power-off mr-1"></i> Status Akun</strong>
            <p class="text-muted"><?= $status; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <a class="btn btn-flat btn-danger float-right" href="<?= site_url('Peoples'); ?>" type="button" title="Kembali"><i class="fa-solid fa-backward"></i></a>
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
              <li class="nav-item"><a class="nav-link" href="#foll" data-toggle="tab">Follow</a></li>
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
                      <div class="col-9">
                        <div class="h4 text-primary font-weight-bold">Aktifitas Ketika di dalam Sistem</div>
                      </div>
                      <div class="col-3">
                        <input type="date" class="form-control float-right" name="tgl" id="tgl" value="<?= date('Y-m-d'); ?>" onchange="lihat_aktifitas(this.value, '<?= $orang->username; ?>')">
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
                              <?php foreach ($aktifitas as $au) { ?>
                                <table width="100%">
                                  <tr>
                                    <td width="14%" class="text-left"><span class="badge bg-success"><?= date("d m Y", strtotime($au->waktu)); ?></span></td>
                                    <td width="20%" class="text-left"><?= $au->menu; ?></td>
                                    <td width="46%" class="text-left"><?= $au->kegiatan; ?></td>
                                    <td width="20%" class="text-right">Jam : <?= date("H:i", strtotime($au->waktu)); ?></td>
                                  </tr>
                                </table>
                                <hr>
                              <?php } ?>
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
              <div class="tab-pane" id="foll">
                <div class="row">
                  <div class="col-6">
                    <div class="table-responsive">
                      <div class="h4">Followers</div>
                      <?php $followers = $this->db->query("SELECT * FROM follow WHERE id_user_ke = '$orang->id_user'")->result(); ?>
                      <table class="table table-striped table-bordered" style="width: 100%;">
                        <thead>
                          <tr>
                            <th width="33%">Profile</th>
                            <th width="34%">Username</th>
                            <th width="33%">Kontak</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($followers as $fr) : ?>
                            <?php
                            $sql = $this->db->query("SELECT * FROM user WHERE id_user = '$fr->id_user_dari'")->row();
                            if ($sql->on_off > 0) {
                              $color = "bg-success";
                            } else {
                              $color = "bg-dark";
                            }
                            ?>
                            <tr>
                              <td class="text-center">
                                <img src="<?= base_url('assets/user/') . $sql->gambar; ?>" style="width: 50px; height: 50px;" class="rounded">
                              </td>
                              <td>
                                <a href="<?= site_url('Profile/orang/') . $sql->id_user; ?>" type="button" class="badge <?= $color; ?>" title="Kunjungi"><i class="fa-regular fa-eye"></i></a> <?= $sql->username; ?>
                              </td>
                              <td><?= $sql->nohp; ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="table-responsive">
                      <div class="h4">Following</div>
                      <?php $followers = $this->db->query("SELECT * FROM follow WHERE id_user_dari = '$orang->id_user'")->result(); ?>
                      <table class="table table-striped table-bordered" style="width: 100%;">
                        <thead>
                          <tr>
                            <th width="33%">Profile</th>
                            <th width="34%">Username</th>
                            <th width="33%">Kontak</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($followers as $fr) : ?>
                            <?php
                            $sql = $this->db->query("SELECT * FROM user WHERE id_user = '$fr->id_user_ke'")->row();
                            if ($sql->on_off > 0) {
                              $color = "bg-success";
                            } else {
                              $color = "bg-dark";
                            }
                            ?>
                            <tr>
                              <td class="text-center">
                                <img src="<?= base_url('assets/user/') . $sql->gambar; ?>" style="width: 50px; height: 50px;" class="rounded">
                              </td>
                              <td>
                                <a href="<?= site_url('Profile/orang/') . $sql->id_user; ?>" type="button" class="badge <?= $color; ?>" title="Kunjungi"><i class="fa-regular fa-eye"></i></a> <?= $sql->username; ?>
                              </td>
                              <td><?= $sql->nohp; ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function follow(id_user_ke, nama_ke) {
    Swal.fire({
      title: 'IKUTI',
      text: "Yakin ingin mengikuti " + nama_ke + " ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Ikuti',
      cancelButtonText: 'Tidak',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Peoples/follow/'); ?>" + id_user_ke,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                title: 'FOLLOW',
                text: 'Berhasil mengikuti ' + nama_ke,
              }).then((result) => {
                location.href = "<?= site_url('Peoples'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'FOLLOW',
                text: 'Berhasil mengikuti ' + nama_ke,
              });
            }
          }
        });
      }
    })
  }

  function unfollow(id_user_ke, nama_ke) {
    Swal.fire({
      title: 'IKUTI',
      text: "Yakin ingin berhenti mengikuti " + nama_ke + " ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, berhenti mengikuti',
      cancelButtonText: 'Tidak',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Peoples/unfollow/'); ?>" + id_user_ke,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                title: 'UNFOLLOW',
                text: 'Berhasil berhenti mengikuti ' + nama_ke,
              }).then((result) => {
                location.href = "<?= site_url('Profile/orang/'); ?>" + id_user_ke;
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'UNFOLLOW',
                text: 'Berhasil berhenti mengikuti ' + nama_ke,
              });
            }
          }
        });
      }
    })
  }

  function lihat_aktifitas(params, username) {
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("cekaktif_user").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "<?php echo base_url(); ?>Profile/aktifitas_orang/" + params + "?username=" + username, true);
    xhttp.send();
  }
</script>