<section class="content">
  <div class="row">
    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?= $jum_anggota; ?></h3>
          <p>Jumlah Anggota</p>
        </div>
        <div class="icon">
          <i class="fa fa-users"></i>
        </div>
        <?php if ($user->id_role == 1) : ?>
          <a href="<?= site_url("Master/anggota"); ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3>53<sup style="font-size: 20px">%</sup></h3>
          <p>Bounce Rate</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <?php if ($user->id_role == 1) : ?>
          <a href="<?= site_url("Master/anggota"); ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>44</h3>
          <p>User Registrations</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <?php if ($user->id_role == 1) : ?>
          <a href="<?= site_url("Master/anggota"); ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        <?php endif; ?>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>65</h3>
          <p>Unique Visitors</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <?php if ($user->id_role == 1) : ?>
          <a href="<?= site_url("Master/anggota"); ?>" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- cek pertama -->
<div class="modal" tabindex="-1" id="modal1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header" style="border-top: 3px solid #0069d9;">
        <h5 class="modal-title"><b><span class="text-danger">Lengkapi</span> <span class="text-primary">Data Diri</span></b></h5>
      </div>
      <form method="POST" id="form-upuser">
        <div class="modal-body">
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="username" name="username" readonly value="<?= $user->username; ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-regular fa-address-card"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap..." value="<?= $user->nama; ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-id-card-clip"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="number" class="form-control" id="nohp" name="nohp" placeholder="Nomor Hp..." value="<?= $user->nohp; ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-phone"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat..." value="<?= $user->alamat; ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-location-crosshairs"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm btn-flat" data-dismiss="modal" onclick="sessi()">Isi Nanti</button>
          <button type="button" class="btn btn-primary btn-sm btn-flat" onclick="update_user()">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function sessi() {
    $.ajax({
      url: "<?= site_url('Home/set_session') ?>",
      type: "POST",
      dataType: "JSON",
    });
  }

  function update_user() {
    $("#modal1").modal("hide");
    var username = $("#username").val();
    $.ajax({
      url: "<?= site_url('Home/update_user'); ?>",
      type: "POST",
      data: ($('#form-upuser').serialize()),
      dataType: "JSON",
      success: function(data) {
        if (data.status == 1) {
          $("#modal1").modal("hide");
          Swal.fire({
            icon: 'success',
            title: 'USER ' + username.toUpperCase(),
            text: 'Berhasil diperbaharui',
          }).then((result) => {
            location.href = "<?= site_url('Home'); ?>";
          });
        }
      }
    });
  }
</script>