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
                  <th>Nama PPN</th>
                  <th>Value PPN</th>
                  <th width="10%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($ppn as $p) : ?>
                  <tr>
                    <td class="text-right"><?= $no++; ?></td>
                    <td><?= $p->nama_ppn; ?></td>
                    <td><?= $p->value_ppn; ?>%</td>
                    <td class="text-center">
                      <button type="button" style="margin-bottom: 5px;" class="btn btn-sm btn-flat btn-warning" title="Ubah PPN" onclick="ubah_ppn('<?= $p->id_ppn; ?>', '<?= $p->nama_ppn; ?>', '<?= $p->value_ppn; ?>')"><i class="fa-solid fa-eye-low-vision"></i></button>
                      <button type="button" style="margin-bottom: 5px;" class="btn btn-flat btn-sm btn-danger" title="Hapus PPN" onclick="hapus_ppn('<?= $p->id_ppn; ?>', '<?= $p->nama_ppn; ?>')"><i class="fa-solid fa-ban"></i></button>
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
        <h4 class="modal-title">Tambah PPN Baru</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="form-modal-tambah">
        <div class="modal-body">
          <div class="input-group mb-3">
            <input type="hidden" class="form-control" id="id_ppn" name="id_ppn">
            <input type="text" class="form-control" id="nama_ppn" name="nama_ppn" placeholder="NAMA PPN..." onkeyup="ubah_nama(this.value)">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-pen"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="value_ppn" name="value_ppn" placeholder="Value PPN %...">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-percent"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-flat float-right" id="btnsave" onclick="simpan()">Tambahkan PPN</button>
          <button type="button" class="btn btn-warning btn-flat float-right" id="btnupdate" onclick="update()">Ubah PPN</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function tambah() {
    $("#modal_tambah").modal("show");
    $(".modal-title").text("Tambah PPN Baru");
    $("#btnupdate").hide();
    $("#btnsave").show();
    $("#id_ppn").val('');
    $("#nama_ppn").val('');
    $("#value_ppn").val('');
  }

  function ubah_nama(nama) {
    str = nama.toLowerCase().replace(/\b[a-z]/g, function(letter) {
      return letter.toUpperCase();
    });
    $("#nama_ppn").val(str);
  }

  function tutup() {
    $("#modal_tambah").modal("hide");
  }

  function ubah_ppn(id_ppn, nama_ppn, value_ppn) {
    $("#modal_tambah").modal("show");
    $(".modal-title").text("Ubah PPN");
    $("#btnsave").hide();
    $("#btnupdate").show();
    $("#id_ppn").val(id_ppn);
    $("#nama_ppn").val(nama_ppn);
    $("#value_ppn").val(value_ppn);
  }
</script>

<script>
  function simpan() {
    var id_ppn = $("#id_ppn").val();
    var nama_ppn = $("#nama_ppn").val();
    if (nama_ppn == '' || nama_ppn == null || value_ppn == '' || value_ppn == null) {
      $("#modal_tambah").modal("hide");
      Swal.fire({
        icon: 'error',
        html: '<span class="text-danger h4 font-weight-bold">TAMBAH PPN</span><br><br>Data belum lengkap!',
      }).then((result) => {
        $("#modal_tambah").modal("show");
        $("#btnupdate").hide();
      });
    } else {
      $.ajax({
        url: "<?= site_url('Inti/get_nama_ppn/?nama=') ?>" + nama_ppn,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#nama_ppn").val('');
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">TAMBAH PPN</span><br><b>' + nama_ppn.toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $(".modal-title").text("Tambah PPN Baru");
              $("#btnsave").show();
              $("#btnupdate").hide();
              $("#id_ppn").val(id_ppn);
              $("#nama_ppn").val('');
              $("#value_ppn").val('');
            });
            return;
          } else {
            $.ajax({
              url: "<?= site_url('Inti/simpan_ppn') ?>",
              type: "POST",
              data: ($('#form-modal-tambah').serialize()),
              dataType: "JSON",
              success: function(data) {
                if (data.status == 1) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'success',
                    html: '<span class="text-success h4 font-weight-bold">TAMBAH PPN</span><br><b>' + nama_ppn.toUpperCase() + '</b><br><br>Berhasil ditambahkan!',
                  }).then((result) => {
                    location.href = "<?= site_url('Inti/ppn'); ?>";
                  });
                } else {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">TAMBAH PPN</span><br><b>' + nama_ppn.toUpperCase() + '</b><br><br>Gagal ditambahkan!',
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
    var id_ppn = $("#id_ppn").val();
    var nama_ppn = $("#nama_ppn").val();
    var value_ppn = $("#value_ppn").val();
    if (nama_ppn == '' || nama_ppn == null) {
      Swal.fire({
        icon: 'error',
        title: 'NAMA',
        text: 'Tidak boleh kosong!',
      });
    } else if (value_ppn == '' || value_ppn == null) {
      Swal.fire({
        icon: 'error',
        title: 'VALUE',
        text: 'Tidak boleh kosong!',
      });
    } else {
      $.ajax({
        url: "<?= site_url('Inti/get_nama_ppn/?nama=') ?>" + nama_ppn,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#nama_ppn").val('');
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">UBAH PPN</span><br><b>' + nama_ppn.toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $(".modal-title").text("Ubah PPN");
              $("#btnsave").hide();
              $("#btnupdate").show();
              $("#id_ppn").val(id_ppn);
              $("#nama_ppn").val('');
              $("#value_ppn").val('');
            });
            return;
          } else {
            Swal.fire({
              html: '<span class="text-warning h4 font-weight-bold">UBAH PPN</span><br><b>' + nama_ppn.toUpperCase() + '</b><br><br>Ingin diubah?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, ubah PPN',
              cancelButtonText: 'Tidak'
            }).then((result) => {
              if (result.isConfirmed) {
                if (nama_ppn == '' || nama_ppn == null) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">UBAH PPN</span><br><br>Data belum lengkap!',
                  }).then((result) => {
                    $("#modal_tambah").modal("show");
                    $("#btnsave").hide();
                    $("#btnupdate").show();
                  });
                } else {
                  $.ajax({
                    url: "<?= site_url('Inti/update_ppn'); ?>",
                    type: "POST",
                    data: ($('#form-modal-tambah').serialize()),
                    dataType: "JSON",
                    success: function(data) {
                      if (data.status == 1) {
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                          icon: 'success',
                          html: '<span class="text-success h4 font-weight-bold">UBAH PPN</span><br><b>' + nama_ppn.toUpperCase() + '</b><br><br>Berhasil diubah!',
                        }).then((result) => {
                          location.href = "<?= site_url('Inti/ppn'); ?>";
                        });
                      } else {
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                          icon: 'error',
                          html: '<span class="text-danger h4 font-weight-bold">UBAH PPN</span><br><b>' + nama_ppn.toUpperCase() + '</b><br><br>Gagal diubah!',
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

  function hapus_ppn(id_ppn, nama_ppn) {
    Swal.fire({
      html: '<span class="text-danger h4 font-weight-bold">HAPUS PPN</span><br><b>' + nama_ppn.toUpperCase() + '</b><br><br>Ingin dihapus?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus ppn',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Inti/hapus_ppn/'); ?>" + id_ppn,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">HAPUS PPN</span><br><b>' + nama_ppn.toUpperCase() + '</b><br><br>Berhasil dihapus!',
              }).then((result) => {
                location.href = "<?= site_url('Inti/ppn'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">HAPUS PPN</span><br><b>' + nama_ppn.toUpperCase() + '</b><br><br>Gagal dihapus!',
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