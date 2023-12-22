<section class="content">
  <form method="POST" id="form-edit">
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
        <div class="row">
          <div class="col">
            <div class="h4"><?= strtoupper($data_user->username); ?> <a class="btn btn-flat btn-danger float-right" href="<?= site_url('Master/anggota'); ?>" type="button" title="Kembali"><i class="fa-solid fa-backward"></i></a></div>
            <br>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="username" name="username" placeholder="Username..." value="<?= $data_user->username; ?>" readonly>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa-regular fa-address-card"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap..." value="<?= $data_user->nama; ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa-solid fa-id-card-clip"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="number" class="form-control" id="nohp" name="nohp" placeholder="Nomor Hp..." value="<?= $data_user->nohp; ?>">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa-solid fa-phone"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat..."><?= $data_user->alamat; ?></textarea>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fa-solid fa-location-crosshairs"></span>
                </div>
              </div>
            </div>
            <button type="button" class="btn btn-sm btn-flat float-right btn-warning" id="btnupdate" onclick="update('<?= $data_user->id_user; ?>')">Simpan Perubahan <i class="fa-solid fa-arrows-rotate"></i></button>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>

<script>
  function update(id) {
    var username = $("#username").val();
    var nama = $("#nama").val();
    var nohp = $("#nohp").val();
    var alamat = $("#alamat").val();
    if (nama != '' && nohp != '' && alamat != '') {
      Swal.fire({
        html: '<span class="text-warning h4 font-weight-bold">UBAH ANGGOTA</span><br><b>' + username.toUpperCase() + '</b><br><br>Ingin diubah?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, ubah anggota',
        cancelButtonText: 'Tidak'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= site_url('Master/edit_anggota_aksi/'); ?>" + id,
            type: "POST",
            data: ($('#form-edit').serialize()),
            dataType: "JSON",
            success: function(data) {
              if (data.status == 1) {
                Swal.fire({
                  icon: 'success',
                  html: '<span class="text-success h4 font-weight-bold">UBAH ANGGOTA</span><br><b>' + username.toUpperCase() + '</b><br><br>Berhasil diubah!',
                }).then((result) => {
                  location.href = "<?= site_url('Master/anggota'); ?>";
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  html: '<span class="text-danger h4 font-weight-bold">UBAH ANGGOTA</span><br><b>' + username.toUpperCase() + '</b><br><br>Gagal diubah!',
                });
              }
            }
          });
        } else {}
      });
    } else {
      Swal.fire({
        icon: 'error',
        html: '<span class="text-warning h4 font-weight-bold">TAMBAH ANGGOTA</span><br><br>Data diri belum lengkap!',
      })
    }
  }
</script>