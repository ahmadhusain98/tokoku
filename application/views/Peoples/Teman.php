<section class="content">
  <div id="body-card">
    <div class="row">
      <?php if ($orang) : ?>
        <?php foreach ($orang as $o) : ?>
          <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card d-flex flex-fill">
              <div class="card-header text-muted border-bottom-0">
                <?= strtoupper($o->tingkatan); ?>
              </div>
              <div class="card-body pt-0">
                <div class="row">
                  <div class="col-7">
                    <h2 class="lead"><b><?= $o->nama; ?></b></h2>
                    <p class="text-muted text-sm"><b>Tentang: </b>
                      <br>
                      <?php
                      $followers = $this->db->query("SELECT * FROM follow WHERE id_user_ke = '$o->id_user'")->num_rows();
                      $following = $this->db->query("SELECT * FROM follow WHERE id_user_dari = '$o->id_user'")->num_rows();
                      echo "Followers : " . $followers . "<br>";
                      echo "Following : " . $following . "<br>";
                      $cabang = $this->db->query("SELECT * FROM cabang WHERE id_cabang IN (SELECT id_cabang FROM akses_cabang WHERE id_user = '$o->id_user')")->result();
                      echo "<br>Cabang : ";
                      foreach ($cabang as $c) :
                        echo $c->nama_cabang . ', ';
                      endforeach;
                      ?>
                    </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Alamat: <?= $o->alamat; ?></li>
                      <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Kontak: <?= $o->nohp; ?></li>
                    </ul>
                  </div>
                  <div class="col-5 text-center">
                    <?php if ($o->on_off == 1) {
                      $cekborder = "style='border: 3px solid green;'";
                    } else {
                      $cekborder = "style='border: 3px solid black;'";
                    } ?>
                    <img src="<?= base_url('assets/user/') . $o->gambar; ?>" alt="user-avatar" class="img-circle img-fluid" <?= $cekborder; ?>>
                    <?php if ($o->on_off == 1) {
                      echo "Online";
                    } else {
                      echo "Offline";
                    } ?>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="text-right">
                  <a href="<?= site_url('Profile/chat/') . $o->id_user; ?>" type="button" class="btn btn-sm bg-danger btn-flat">
                    Pesan
                  </a>
                  <?php if ($this->db->query("SELECT * FROM follow WHERE id_user_ke = '$o->id_user' AND id_user_dari = '$user->id_user'")->num_rows() > 0) { ?>
                    <button type="button" class="btn btn-sm bg-dark btn-flat" onclick="unfollow('<?= $o->id_user; ?>', '<?= $o->nama; ?>')">
                      Unfollow
                    </button>
                  <?php } else if ($this->db->query("SELECT * FROM follow WHERE id_user_dari = '$o->id_user' AND id_user_ke = '$user->id_user'")->num_rows() > 0) { ?>
                    <button type="button" class="btn btn-sm bg-secondary btn-flat" onclick="follow('<?= $o->id_user; ?>', '<?= $o->nama; ?>')">
                      Follow Back
                    </button>
                  <?php } else { ?>
                    <button type="button" class="btn btn-sm bg-teal btn-flat" onclick="follow('<?= $o->id_user; ?>', '<?= $o->nama; ?>')">
                      Follow
                    </button>
                  <?php } ?>
                  <a href="<?= site_url('Profile/orang/') . $o->id_user; ?>" class="btn btn-sm btn-primary btn-flat" type="button">
                    Profile
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="col-sm-12">
          <div class="h4 text-center mb-4 font-weight-bold text-danger">Tidak Ada Daftar Teman</div>
          <div class="h5 text-center">
            <a type="button" class="btn btn-primary btn-flat" href="<?= site_url('Peoples'); ?>">Cari Teman</a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<script>
  function cari(par) {
    var params = par.toLowerCase();
    if (params != '' || params != null || params != 'null') {
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("body-card").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "<?php echo base_url(); ?>Peoples/isi_teman/" + params, true);
      xhttp.send();
    } else {
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("body-card").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "<?php echo base_url(); ?>Peoples/isi_kosong_teman/", true);
      xhttp.send();
    }
  }

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
                location.href = "<?= site_url('Peoples/teman'); ?>";
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
                location.href = "<?= site_url('Peoples/teman'); ?>";
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
</script>