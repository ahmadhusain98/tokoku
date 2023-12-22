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
                  <th>Kode Satuan</th>
                  <th>Nama Satuan</th>
                  <th width="10%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($satuan as $s) : ?>
                  <tr>
                    <td class="text-right"><?= $no++; ?></td>
                    <td><?= $s->kode_satuan; ?></td>
                    <td><?= $s->nama_satuan; ?></td>
                    <td class="text-center">
                      <button type="button" style="margin-bottom: 5px;" class="btn btn-sm btn-flat btn-warning" title="Ubah Satuan" onclick="ubah_satuan('<?= $s->id_satuan; ?>', '<?= $s->kode_satuan; ?>', '<?= $s->nama_satuan; ?>')"><i class="fa-solid fa-eye-low-vision"></i></button>
                      <?php if ($this->db->query("SELECT * FROM barang WHERE satuan = '$s->kode_satuan'")->num_rows() < 1) : ?>
                        <button type="button" style="margin-bottom: 5px;" class="btn btn-flat btn-sm btn-danger" title="Hapus Satuan" onclick="hapus_satuan('<?= $s->id_satuan; ?>', '<?= $s->nama_satuan; ?>')"><i class="fa-solid fa-ban"></i></button>
                      <?php else : ?>
                        <button type="button" style="margin-bottom: 5px;" class="btn btn-flat btn-sm btn-danger" title="Hapus Satuan" disabled><i class="fa-solid fa-ban"></i></button>
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
        <h4 class="modal-title">Tambah Satuan Baru</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="form-modal-tambah">
        <div class="modal-body">
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="kode_satuan" name="kode_satuan" placeholder="AUTO" value="" readonly>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-code-fork"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="nama_satuan" name="nama_satuan" placeholder="Nama Satuan..." onkeyup="ubah_nama(this.value)">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-regular fa-building"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-flat float-right" id="btnsave" onclick="simpan()">Tambahkan Satuan</button>
          <button type="button" class="btn btn-warning btn-flat float-right" id="btnupdate" onclick="update()">Ubah Satuan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function tambah() {
    $("#modal_tambah").modal("show");
    $(".modal-title").text("Tambah Satuan Baru");
    $("#btnupdate").hide();
    $("#btnsave").show();
    $("#kode_satuan").val('');
    $("#nama_satuan").val('');
  }

  function ubah_nama(nama) {
    str = nama.toLowerCase().replace(/\b[a-z]/g, function(letter) {
      return letter.toUpperCase();
    });
    $("#nama_satuan").val(str);
  }

  function tutup() {
    $("#modal_tambah").modal("hide");
  }

  function ubah_satuan(id_satuan, kode_satuan, nama_satuan) {
    $("#modal_tambah").modal("show");
    $(".modal-title").text("Ubah Satuan Baru");
    $("#btnsave").hide();
    $("#btnupdate").show();
    $("#kode_satuan").val(kode_satuan);
    $("#nama_satuan").val(nama_satuan);
  }
</script>

<script>
  function simpan() {
    var kode_satuan = $("#kode_satuan").val();
    var nama_satuan = $("#nama_satuan").val();
    if (nama_satuan == '' || nama_satuan == null) {
      $("#modal_tambah").modal("hide");
      Swal.fire({
        icon: 'error',
        html: '<span class="text-danger h4 font-weight-bold">TAMBAH SATUAN</span><br><br>Data belum lengkap!',
      }).then((result) => {
        $("#modal_tambah").modal("show");
        $("#btnupdate").hide();
      });
    } else {
      $.ajax({
        url: "<?= site_url('Inti/get_nama_satuan/') ?>" + nama_satuan,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#nama_satuan").val('');
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">TAMBAH SATUAN</span><br><b>' + nama_satuan.toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $(".modal-title").text("Tambah Satuan Baru");
              $("#btnsave").show();
              $("#btnupdate").hide();
              $("#kode_satuan").val(kode_satuan);
              $("#nama_satuan").val('');
            });
            return;
          } else {
            $.ajax({
              url: "<?= site_url('Inti/simpan_satuan') ?>",
              type: "POST",
              data: ($('#form-modal-tambah').serialize()),
              dataType: "JSON",
              success: function(data) {
                if (data.status == 1) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'success',
                    html: '<span class="text-success h4 font-weight-bold">TAMBAH SATUAN</span><br><b>' + nama_satuan.toUpperCase() + '</b><br><br>Berhasil ditambahkan!',
                  }).then((result) => {
                    location.href = "<?= site_url('Inti/satuan'); ?>";
                  });
                } else {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">TAMBAH SATUAN</span><br><b>' + nama_satuan.toUpperCase() + '</b><br><br>Gagal ditambahkan!',
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
    var kode_satuan = $("#kode_satuan").val();
    var nama_satuan = $("#nama_satuan").val();
    if (nama_satuan == '' || nama_satuan == null) {
      Swal.fire({
        icon: 'error',
        title: 'NAMA',
        text: 'Tidak boleh kosong!',
      });
    } else {
      $.ajax({
        url: "<?= site_url('Inti/get_nama_satuan/') ?>" + nama_satuan,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#nama_satuan").val('');
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">UBAH SATUAN</span><br><b>' + nama_satuan.toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $(".modal-title").text("Ubah Satuan Baru");
              $("#btnsave").hide();
              $("#btnupdate").show();
              $("#kode_satuan").val(kode_satuan);
              $("#nama_satuan").val('');
            });
            return;
          } else {
            Swal.fire({
              html: '<span class="text-warning h4 font-weight-bold">UBAH SATUAN</span><br><b>' + nama_satuan.toUpperCase() + '</b><br><br>Ingin diubah?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, ubah satuan',
              cancelButtonText: 'Tidak'
            }).then((result) => {
              if (result.isConfirmed) {
                if (nama_satuan == '' || nama_satuan == null) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">UBAH SATUAN</span><br><br>Data belum lengkap!',
                  }).then((result) => {
                    $("#modal_tambah").modal("show");
                    $("#btnsave").hide();
                    $("#btnupdate").show();
                  });
                } else {
                  $.ajax({
                    url: "<?= site_url('Inti/update_satuan'); ?>",
                    type: "POST",
                    data: ($('#form-modal-tambah').serialize()),
                    dataType: "JSON",
                    success: function(data) {
                      if (data.status == 1) {
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                          icon: 'success',
                          html: '<span class="text-success h4 font-weight-bold">UBAH SATUAN</span><br><b>' + nama_satuan.toUpperCase() + '</b><br><br>Berhasil diubah!',
                        }).then((result) => {
                          location.href = "<?= site_url('Inti/satuan'); ?>";
                        });
                      } else {
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                          icon: 'error',
                          html: '<span class="text-danger h4 font-weight-bold">UBAH SATUAN</span><br><b>' + nama_satuan.toUpperCase() + '</b><br><br>Gagal diubah!',
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

  function hapus_satuan(id_satuan, nama_satuan) {
    Swal.fire({
      html: '<span class="text-danger h4 font-weight-bold">HAPUS SATUAN</span><br><b>' + nama_satuan.toUpperCase() + '</b><br><br>Ingin dihapus?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus satuan',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Inti/hapus_satuan/'); ?>" + id_satuan,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">HAPUS SATUAN</span><br><b>' + nama_satuan.toUpperCase() + '</b><br><br>Berhasil dihapus!',
              }).then((result) => {
                location.href = "<?= site_url('Inti/satuan'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">HAPUS SATUAN</span><br><b>' + nama_satuan.toUpperCase() + '</b><br><br>Gagal dihapus!',
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