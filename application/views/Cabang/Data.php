<?php
function hitung_exp($date)
{
  $day = date("d", strtotime($date));
  $month = date("m", strtotime($date));
  $year = date("Y", strtotime($date));

  $days    = (int)((mktime(0, 0, 0, $month, $day, $year) - time()) / 86400);

  return $days;
}
?>

<section class="content">
  <form method="POST" id="form-cabang">
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
          <div class="col-12">
            <div class="table-responsive">
              <button type="button" onclick="tambah()" title="Tambah Cabang" class="btn btn-flat btn-success float-right"><i class="fa-solid fa-plus"></i></button>
              <br>
              <br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr class="text-center">
                    <th>No</th>
                    <th>Kode Cabang</th>
                    <th>Nama Cabang</th>
                    <th>Kontak Cabang</th>
                    <th>Alamat Cabang</th>
                    <th>Penanggungjawab</th>
                    <th>Masa Aktif</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($cabang as $c) : ?>
                    <?php
                    if (hitung_exp($c->tgl_berakhir) == 0) {
                      $status = "The Last Day";
                      $class_status = "danger";
                    } else if (hitung_exp($c->tgl_berakhir) < 0) {
                      $status = "Tidak Aktif";
                      $class_status = "dark";
                    } else if (hitung_exp($c->tgl_berakhir) <= 7) {
                      $status = "Hampir Habis";
                      $class_status = "warning";
                    } else {
                      $status = "Aktif";
                      $class_status = "primary";
                    }
                    ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $c->kode_cabang; ?></td>
                      <td><?= $c->nama_cabang; ?></td>
                      <td><?= $c->kontak_cabang; ?></td>
                      <td><?= $c->alamat_cabang; ?></td>
                      <td><?= $c->penanggungjawab; ?></td>
                      <td><?= hitung_exp($c->tgl_berakhir); ?> Hari</td>
                      <td class="text-center"><span class="badge badge-<?= $class_status; ?>"><?= $status ?></span></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-flat btn-warning" title="Ubah Cabang" onclick="ubah_cabang('<?= $c->id_cabang; ?>', '<?= $c->kode_cabang; ?>', '<?= $c->nama_cabang; ?>', '<?= $c->kontak_cabang; ?>', '<?= $c->alamat_cabang; ?>', '<?= $c->penanggungjawab; ?>', '<?= $c->tgl_mulai; ?>', '<?= $c->tgl_berakhir; ?>')"><i class="fa-solid fa-eye-low-vision"></i></button>
                        <?php if ($this->db->query("SELECT id_cabang FROM akses_cabang WHERE id_cabang = '$c->id_cabang'")->num_rows() < 1) : ?>
                          <button type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus Cabang" onclick="hapus_cabang('<?= $c->id_cabang; ?>', '<?= $c->nama_cabang; ?>')"><i class="fa-solid fa-ban"></i></button>
                        <?php else : ?>
                          <button type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus Cabang" disabled><i class="fa-solid fa-ban"></i></button>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>

<div class="modal fade" id="modal_tambah">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content" style="border-top: solid 3px red; border-bottom: solid 3px #0069d9;">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Cabang Baru</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="form-modal-tambah">
        <div class="modal-body">
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="kode_cabang" name="kode_cabang" placeholder="Kode Cabang... (HARUS 3 HURUF)" maxlength="3" onchange="cek_kode_cabang(this.value)">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-code-fork"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="nama_cabang" name="nama_cabang" placeholder="Nama Cabang..." onchange="cek_nama_cabang(this.value)">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-regular fa-building"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="kontak_cabang" name="kontak_cabang" placeholder="Kontak Cabang...">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-regular fa-address-book"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="penanggungjawab" name="penanggungjawab" placeholder="Kepala Cabang...">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-calendar"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="date" class="form-control" id="tgl_berakhir" name="tgl_berakhir" value="<?= date('Y-m-d', strtotime('+2 Year')) ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-calendar"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <textarea name="alamat_cabang" id="alamat_cabang" class="form-control" placeholder="Alamat Cabang..."></textarea>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-location-crosshairs"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-flat float-right" id="btnsave" onclick="simpan()">Tambahkan Cabang</button>
          <button type="button" class="btn btn-warning btn-flat float-right" id="btnupdate" onclick="update()">Ubah Cabang</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function tambah() {
    $("#modal_tambah").modal("show");
    $(".modal-title").text("Tambah Cabang Baru");
    $("#btnupdate").hide();
    $("#btnsave").show();
    $("#kode_cabang").val('');
    $("#kode_cabang").attr("readonly", false);
    $("#nama_cabang").val('');
    $("#kontak_cabang").val('');
    $("#alamat_cabang").val('');
  }

  function tutup() {
    $("#modal_tambah").modal("hide");
  }

  // cek kode cabang
  function cek_kode_cabang(params) {
    $.ajax({
      url: "<?= site_url('Master/cek_kode_cabang/'); ?>" + params,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        if (data.status == 1) {
          $("#modal_tambah").modal("hide");
          Swal.fire({
            icon: 'error',
            html: '<span class="text-danger h4 font-weight-bold">KODE CABANG</span><br><b>' + params.toUpperCase() + '</b><br><br>Sudah digunakan!',
          }).then((result) => {
            $("#modal_tambah").modal("show");
            $("#btnupdate").hide();
            $("#kode_cabang").val("");
            $("#kode_cabang").attr("focus", true);
          });
        } else {
          $("#modal_tambah").modal("show");
          $("#btnupdate").hide();
        }
      }
    });
  }

  // cek nama cabang
  function cek_nama_cabang(params) {
    $.ajax({
      url: "<?= site_url('Master/cek_nama_cabang/'); ?>" + params,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        if (data.status == 1) {
          $("#modal_tambah").modal("hide");
          Swal.fire({
            icon: 'error',
            html: '<span class="text-danger h4 font-weight-bold">NAMA CABANG</span><br><b>' + params.toUpperCase() + '</b><br><br>Sudah digunakan!',
          }).then((result) => {
            $("#modal_tambah").modal("show");
            $("#nama_cabang").val("");
            $("#nama_cabang").attr("focus", true);
          });
        } else {
          $("#modal_tambah").modal("show");
          $("#btnupdate").hide();
        }
      }
    });
  }

  // ubah
  function ubah_cabang(id_cabang, kode_cabang, nama_cabang, kontak_cabang, alamat_cabang, penanggungjawab, tgl_mulai, tgl_berakhir) {
    $("#modal_tambah").modal("show");
    $("#btnupdate").show();
    $("#btnsave").hide();
    $(".modal-title").text("Ubah Cabang (" + kode_cabang + ")");
    $("#kode_cabang").val(kode_cabang);
    $("#kode_cabang").attr("readonly", true);
    $("#nama_cabang").val(nama_cabang);
    $("#kontak_cabang").val(kontak_cabang);
    $("#penanggungjawab").val(penanggungjawab);
    $("#tgl_mulai").val(tgl_mulai);
    $("#tgl_berakhir").val(tgl_berakhir);
    $("#alamat_cabang").val(alamat_cabang);
  }

  // tambah
  function simpan() {
    var kode_cabang = $("#kode_cabang").val();
    var nama_cabang = $("#nama_cabang").val();
    var kontak_cabang = $("#kontak_cabang").val();
    var alamat_cabang = $("#alamat_cabang").val();
    if (kode_cabang != '' && nama_cabang != '' && kontak_cabang != '' && alamat_cabang != '') {
      $.ajax({
        url: "<?= site_url('Master/tambah_cabang'); ?>",
        type: "POST",
        data: ($('#form-modal-tambah').serialize()),
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'success',
              html: '<span class="text-success h4 font-weight-bold">CABANG</span><br><b>' + nama_cabang.toUpperCase() + '</b><br><br>Berhasil ditambahkan!',
            }).then((result) => {
              location.href = "<?= site_url('Master/cabang'); ?>";
            });
          } else {
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">CABANG</span><br><b>' + nama_cabang.toUpperCase() + '</b><br><br>Gagal ditambahkan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $("#btnupdate").hide();
            });
          }
        }
      });
    } else {
      $("#modal_tambah").modal("hide");
      Swal.fire({
        icon: 'error',
        html: '<span class="text-danger h4 font-weight-bold">TAMBAH CABANG</span><br><br>Data belum lengkap!',
      }).then((result) => {
        $("#modal_tambah").modal("show");
        $("#btnupdate").hide();
      });
    }
  }

  // update data
  function update() {
    var kode_cabang = $("#kode_cabang").val();
    var nama_cabang = $("#nama_cabang").val();
    var kontak_cabang = $("#kontak_cabang").val();
    var alamat_cabang = $("#alamat_cabang").val();
    $("#modal_tambah").modal("hide");
    Swal.fire({
      html: '<span class="text-warning h4 font-weight-bold">UBAH CABANG</span><br><b>' + nama_cabang.toUpperCase() + '</b><br><br>Ingin diubah?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, ubah cabang',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        if (kode_cabang != '' && nama_cabang != '' && kontak_cabang != '' && alamat_cabang != '') {
          $.ajax({
            url: "<?= site_url('Master/update_cabang'); ?>",
            type: "POST",
            data: ($('#form-modal-tambah').serialize()),
            dataType: "JSON",
            success: function(data) {
              if (data.status == 1) {
                $("#modal_tambah").modal("hide");
                Swal.fire({
                  icon: 'success',
                  html: '<span class="text-success h4 font-weight-bold">CABANG</span><br><b>' + nama_cabang.toUpperCase() + '</b><br><br>Berhasil diubah!',
                }).then((result) => {
                  location.href = "<?= site_url('Master/cabang'); ?>";
                });
              } else {
                $("#modal_tambah").modal("hide");
                Swal.fire({
                  icon: 'error',
                  html: '<span class="text-danger h4 font-weight-bold">CABANG</span><br><b>' + nama_cabang.toUpperCase() + '</b><br><br>Gagal diubah!',
                }).then((result) => {
                  $("#modal_tambah").modal("show");
                  $("#btnupdate").show();
                  $("#btnsave").hide();
                });
              }
            }
          });
        } else {
          $("#modal_tambah").modal("hide");
          Swal.fire({
            icon: 'error',
            html: '<span class="text-danger h4 font-weight-bold">UBAH CABANG</span><br><b>' + nama_cabang.toUpperCase() + '</b><br><br>Data belum lengkap!',
          }).then((result) => {
            $("#modal_tambah").modal("show");
            $("#btnupdate").show();
            $("#btnsave").hide();
          });
        }
      } else {
        tutup();
      }
    });
  }

  // hapus
  function hapus_cabang(id_cabang, nama_cabang) {
    Swal.fire({
      html: '<span class="text-danger h4 font-weight-bold">HAPUS CABANG</span><br><b>' + nama_cabang.toUpperCase() + '</b><br><br>Ingin dihapus?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus cabang',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Master/hapus_cabang/'); ?>" + id_cabang,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">HAPUS CABANG</span><br><b>' + nama_cabang.toUpperCase() + '</b><br><br>Berhasil dilakukan!',
              }).then((result) => {
                location.href = "<?= site_url('Master/cabang'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">HAPUS CABANG</span><br><b>' + nama_cabang.toUpperCase() + '</b><br><br>Gagal dilakukan!',
              });
            }
          }
        });
      } else {
        tutup();
      }
    });
  }
</script>