<section class="content">
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
            <button type="button" onclick="tambah()" title="Tambah Satuan" class="btn btn-flat btn-success float-right"><i class="fa-solid fa-plus"></i></button>
            <br>
            <br>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th width="5%">No</th>
                  <th>Kode Tingkatan</th>
                  <th>Nama Tingkatan</th>
                  <th width="10%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($role as $r) : ?>
                  <tr>
                    <td class="text-right"><?= $no++; ?></td>
                    <td><?= $r->id_role; ?></td>
                    <td><?= $r->tingkatan; ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-flat btn-warning" title="Ubah Satuan" onclick="ubah_tingkatan('<?= $r->id_role; ?>', '<?= $r->tingkatan; ?>')"><i class="fa-solid fa-eye-low-vision"></i></button>
                      <?php if ($this->db->query("SELECT * FROM user WHERE id_role = '$r->id_role'")->num_rows() < 1) : ?>
                        <button type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus Satuan" onclick="hapus_tingkatan('<?= $r->id_role; ?>', '<?= $r->tingkatan; ?>')"><i class="fa-solid fa-ban"></i></button>
                      <?php else : ?>
                        <button type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus Satuan" disabled><i class="fa-solid fa-ban"></i></button>
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
</section>

<div class="modal fade" id="modal_tambah">
  <div class="modal-dialog  modal-dialog-centered modal-sm">
    <div class="modal-content" style="border-top: solid 3px red; border-bottom: solid 3px #0069d9;">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Tingkatan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="form-modal-tambah">
        <div class="modal-body">
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="id_role" name="id_role" placeholder="AUTO" value="" readonly>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-code-fork"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="tingkatan" name="tingkatan" placeholder="Nama Tingkatan..." onkeyup="ubah_nama(this.value)">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-regular fa-building"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-flat float-right" id="btnsave" onclick="simpan()">Tambahkan Tingkatan</button>
          <button type="button" class="btn btn-warning btn-flat float-right" id="btnupdate" onclick="update()">Ubah Tingkatan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function tambah() {
    $("#modal_tambah").modal("show");
    $(".modal-title").text("Tambah Tingkatan");
    $("#btnupdate").hide();
    $("#btnsave").show();
    $("#id_role").val('');
    $("#tingkatan").val('');
  }

  function ubah_nama(nama) {
    str = nama.toLowerCase().replace(/\b[a-z]/g, function(letter) {
      return letter.toUpperCase();
    });
    $("#tingkatan").val(str);
  }

  function tutup() {
    $("#modal_tambah").modal("hide");
  }

  function ubah_tingkatan(id_role, tingkatan) {
    $("#modal_tambah").modal("show");
    $(".modal-title").text("Ubah Tingkatan");
    $("#btnsave").hide();
    $("#btnupdate").show();
    $("#id_role").val(id_role);
    $("#tingkatan").val(tingkatan);
  }
</script>

<script>
  function simpan() {
    var tingkatan = $("#tingkatan").val();
    if (tingkatan == '' || tingkatan == null) {
      $("#modal_tambah").modal("hide");
      Swal.fire({
        icon: 'error',
        html: '<span class="text-danger h4 font-weight-bold">TAMBAH TINGKATAN</span><br><br>Data belum lengkap!',
      }).then((result) => {
        $("#modal_tambah").modal("show");
        $("#btnupdate").hide();
      });
    } else {
      $.ajax({
        url: "<?= site_url('Privatex/get_tingkatan/') ?>" + tingkatan,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#tingkatan").val('');
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">TAMBAH TINGKATAN</span><br><b>' + tingkatan.toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $(".modal-title").text("Tambah Tingkatan");
              $("#btnsave").show();
              $("#btnupdate").hide();
              $("#id_role").val('');
              $("#tingkatan").val('');
            });
            return;
          } else {
            $.ajax({
              url: "<?= site_url('Privatex/simpan_tingkatan') ?>",
              type: "POST",
              data: ($('#form-modal-tambah').serialize()),
              dataType: "JSON",
              success: function(data) {
                if (data.status == 1) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'success',
                    html: '<span class="text-success h4 font-weight-bold">TAMBAH TINGKATAN</span><br><b>' + tingkatan.toUpperCase() + '</b><br><br>Berhasil ditambahkan!',
                  }).then((result) => {
                    location.href = "<?= site_url('Privatex/master_role'); ?>";
                  });
                } else {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">TAMBAH TINGKATAN</span><br><b>' + tingkatan.toUpperCase() + '</b><br><br>Gagal ditambahkan!',
                  }).then((result) => {
                    $("#modal_tambah").modal("show");
                    $("#btnupdate").hide();
                  });
                }
              }
            });
          }
        }
      });
    }
  }

  function update() {
    var id_role = $("#id_role").val();
    var tingkatan = $("#tingkatan").val();
    if (tingkatan == '' || tingkatan == null) {
      Swal.fire({
        icon: 'error',
        title: 'NAMA',
        text: 'Tidak boleh kosong!',
      });
    } else {
      $.ajax({
        url: "<?= site_url('Privatex/get_tingkatan/') ?>" + tingkatan,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#tingkatan").val('');
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">UBAH TINGKATAN</span><br><b>' + tingkatan.toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $(".modal-title").text("Ubah Tingkatan");
              $("#btnsave").hide();
              $("#btnupdate").show();
              $("#id_role").val(id_role);
              $("#tingkatan").val('');
            });
            return;
          } else {
            Swal.fire({
              html: '<span class="text-warning h4 font-weight-bold">UBAH TINGKATAN</span><br><b>' + tingkatan.toUpperCase() + '</b><br><br>Ingin diubah?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, ubah tingkatan',
              cancelButtonText: 'Tidak'
            }).then((result) => {
              if (result.isConfirmed) {
                if (tingkatan == '' || tingkatan == null) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">UBAH TINGKATAN</span><br><br>Data belum lengkap!',
                  }).then((result) => {
                    $("#modal_tambah").modal("show");
                    $("#btnsave").hide();
                    $("#btnupdate").show();
                  });
                } else {
                  $.ajax({
                    url: "<?= site_url('Privatex/update_tingkatan'); ?>",
                    type: "POST",
                    data: ($('#form-modal-tambah').serialize()),
                    dataType: "JSON",
                    success: function(data) {
                      if (data.status == 1) {
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                          icon: 'success',
                          html: '<span class="text-success h4 font-weight-bold">UBAH TINGKATAN</span><br><b>' + tingkatan.toUpperCase() + '</b><br><br>Berhasil diubah!',
                        }).then((result) => {
                          location.href = "<?= site_url('Privatex/master_role'); ?>";
                        });
                      } else {
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                          icon: 'error',
                          html: '<span class="text-danger h4 font-weight-bold">UBAH TINGKATAN</span><br><b>' + tingkatan.toUpperCase() + '</b><br><br>Gagal diubah!',
                        }).then((result) => {
                          $("#modal_tambah").modal("show");
                          $("#btnupdate").show();
                          $("#btnsave").hide();
                        });
                      }
                    }
                  });
                }
              } else {
                tutup();
              }
            });
          }
        }
      });
    }
  }

  function hapus_tingkatan(id_role, nama_tingkatan) {
    Swal.fire({
      html: '<span class="text-danger h4 font-weight-bold">HAPUS TINGKATAN</span><br><b>' + nama_tingkatan.toUpperCase() + '</b><br><br>Ingin dihapus?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus tingkatan',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Privatex/hapus_tingkatan/'); ?>" + id_role,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">HAPUS TINGKATAN</span><br><b>' + nama_tingkatan.toUpperCase() + '</b><br><br>Berhasil dihapus!',
              }).then((result) => {
                location.href = "<?= site_url('Privatex/master_role'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">HAPUS TINGKATAN</span><br><b>' + nama_tingkatan.toUpperCase() + '</b><br><br>Gagal dihapus!',
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