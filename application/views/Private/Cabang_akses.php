<section class="content">
  <form id="form-akses" method="POST">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          <?= $judul; ?> Untuk <span class="text-danger font-weight-bold badge bg-danger"><?= strtoupper($data_user->username); ?></span>
          <input type="hidden" id="id_user" value="<?= $data_user->id_user; ?>">
          <input type="hidden" id="nama_user" value="<?= $data_user->nama; ?>">
          <input type="hidden" id="username" value="<?= $data_user->username; ?>">
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col">
            <div class="card shadow" style="border-top: 5px solid blue; border-bottom: 5px solid red;">
              <div class="card-body">
                <div class="table-responsive">
                  <div class="h4">Akses Cabang <a class="btn btn-flat btn-danger float-right" href="<?= site_url('Privatex/cabang'); ?>" type="button" title="Kembali"><i class="fa-solid fa-backward"></i></a></div>
                  <br>
                  <table id="table-standar" class="table table-striped table-bordered">
                    <thead>
                      <tr class="text-center">
                        <th width="5%">Pilih</th>
                        <th width="10%">Kode</th>
                        <th width="35%">Nama</th>
                        <th width="30%">Kontak</th>
                        <th width="20%">Alamat</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1;
                      foreach ($cabang as $c) : ?>
                        <tr>
                          <?php
                          if ($this->db->query("SELECT * FROM akses_cabang WHERE id_cabang IN (SELECT id_cabang FROM cabang WHERE id_cabang = '$c->id_cabang') AND id_user = '$data_user->id_user'")->num_rows() > 0) {
                            $cek = "checked";
                          } else {
                            $cek = "";
                          }
                          ?>
                          <td>
                            <input type="hidden" id="ph<?= $no; ?>">
                            <input type="checkbox" <?= $cek; ?> id="pilih<?= $no; ?>" name="pilih" class="form-control" onclick="pilih_cabang('<?= $c->id_cabang; ?>', '<?= $c->nama_cabang; ?>', '<?= $no; ?>')">
                          </td>
                          <td><?= $c->kode_cabang; ?></td>
                          <td><?= $c->nama_cabang; ?></td>
                          <td><?= $c->kontak_cabang; ?></td>
                          <td><?= $c->alamat_cabang; ?></td>
                        </tr>
                      <?php $no++;
                      endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" id="status">
  </form>
</section>

<script>
  function pilih_cabang(id, nama, param) {
    var nama_user1 = $("#nama_user").val();
    if (nama_user1 == '') {
      var nama_user = $("#username").val();
    } else {
      var nama_user = nama_user1;
    }
    var id_user = $("#id_user").val();
    var par = "?id_user=" + id_user;
    if (document.getElementById("pilih" + param).checked == true) {
      var cekph = 1;
    } else {
      var cekph = 0;
    }
    if (cekph < 1) {
      Swal.fire({
        html: '<span class="text-warning h4 font-weight-bold">AKSES CABANG</span><br><b>' + nama.toUpperCase() + '</b><br><br>Tidak bisa diakses oleh ' + nama_user.toUpperCase() + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Hapus Akses',
        cancelButtonText: 'Tutup',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= site_url('Privatex/del_cabang/'); ?>" + id + par,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              if (data == 1) {
                Swal.fire({
                  icon: 'success',
                  html: '<span class="text-success h4 font-weight-bold">AKSES CABANG</span><br><b>' + nama.toUpperCase() + '</b><br><br>Akses berhasil dibatalkan kepada ' + nama_user.toUpperCase() + '!',
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  html: '<span class="text-danger h4 font-weight-bold">AKSES CABANG</span><br><b>' + nama.toUpperCase() + '</b><br><br>Akses gagal dibatalkan kepada ' + nama_user.toUpperCase() + '!',
                });
              }
            }
          });
        } else {
          document.getElementById("pilih" + param).checked = true;
        }
      })
    } else {
      Swal.fire({
        html: '<span class="text-warning h4 font-weight-bold">AKSES CABANG</span><br><b>' + nama.toUpperCase() + '</b><br><br>Bisa diakses oleh ' + nama_user.toUpperCase() + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Beri Akses',
        cancelButtonText: 'Tutup',
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "<?= site_url('Privatex/add_cabang/'); ?>" + id + par,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
              if (data == 1) {
                Swal.fire({
                  icon: 'success',
                  html: '<span class="text-success h4 font-weight-bold">AKSES CABANG</span><br><b>' + nama.toUpperCase() + '</b><br><br>Berhasil diberikan kepada ' + nama_user.toUpperCase() + '!',
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  html: '<span class="text-danger h4 font-weight-bold">AKSES CABANG</span><br><b>' + nama.toUpperCase() + '</b><br><br>Gagal diberikan kepada ' + nama_user.toUpperCase() + '!',
                });
              }
            }
          });
        } else {
          document.getElementById("pilih" + param).checked = false;
        }
      })
    }
  }
</script>