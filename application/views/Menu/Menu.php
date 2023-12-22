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
            <button type="button" onclick="tambah()" title="Tambah Menu" class="btn btn-flat btn-success float-right"><i class="fa-solid fa-plus"></i></button>
            <br>
            <br>
            <table id="table-menu" class="table table-bordered table-striped" style="width: 100%;">
              <thead class="text-center">
                <tr>
                  <th width="5%">No</th>
                  <th>Nama Menu</th>
                  <th width="7%">Icon</th>
                  <th>Url</th>
                  <th width="10%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($menu as $m) : ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $m->nama_menu; ?></td>
                    <td class="text-center"><?= $m->icon; ?></td>
                    <td><?= $m->url; ?></td>
                    <td class="text-center">
                      <button type="button" style="margin-bottom: 5px;" class="btn btn-flat btn-warning btn-sm" title="Ubah Menu" onclick="ubah_menu('<?= $m->id; ?>', '<?= $m->nama_menu; ?>')"><i class="fa-solid fa-eye-low-vision"></i></button>
                      <?php
                      $cek = $this->db->query("SELECT sm.* FROM akses_menu sm WHERE sm.id_menu = '$m->id'")->num_rows();
                      if ($cek > 0) {
                        $disabled = "disabled";
                      } else {
                        $cek2 = $this->db->query("SELECT * FROM sub_menu WHERE id_menu = '$m->id'")->num_rows();
                        if ($cek2 > 0) {
                          $disabled = "disabled";
                        } else {
                          $disabled = "";
                        }
                      }
                      ?>
                      <button type="button" style="margin-bottom: 5px;" <?= $disabled; ?> class="btn btn-flat btn-sm btn-danger" title="Hapus Menu" onclick="hapus_menu('<?= $m->id; ?>', '<?= $m->nama_menu; ?>')"><i class="fa-solid fa-ban"></i></button>
                    </td>
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
</section>

<div class="modal fade" id="modal_tambah">
  <div class="modal-dialog  modal-dialog-centered modal-sm">
    <div class="modal-content" style="border-top: solid 3px red; border-bottom: solid 3px #0069d9;">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Menu</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="form-modal-tambah">
        <div class="modal-body">
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="id" name="id" placeholder="AUTO" value="" readonly>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-code-fork"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="nama_menu" name="nama_menu" placeholder="Nama Menu..." onkeyup="ubah_nama(this.value)">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-indent"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="iconx" name="iconx" placeholder="Icon Fontawesome">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-icons"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="urlx" name="urlx" placeholder="Url...">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-link"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-flat float-right" id="btnsave" onclick="simpan()">Tambahkan Menu</button>
          <button type="button" class="btn btn-warning btn-flat float-right" id="btnupdate" onclick="update()">Ubah Menu</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#table-menu').DataTable({
      "scrollCollapse": true,
      "paging": true,
      "oLanguage": {
        "sEmptyTable": "<div class='text-center'>Tidak ada data</div>",
        "sInfoEmpty": "",
        "sInfoFiltered": " - Dipilih dari _TOTAL_ data",
        "sSearch": "Cari : ",
        "sInfo": " Jumlah _TOTAL_ Data (_START_ - _END_)",
        "sLengthMenu": "_MENU_ Baris",
        "sZeroRecords": "<div class='text-center'>Tidak ada data</div>",
        "oPaginate": {
          "sPrevious": "Sebelumnya",
          "sNext": "Berikutnya"
        }
      },
      "aLengthMenu": [
        [5, 15, 20, -1],
        [5, 15, 20, "Semua"]
      ],
      "columnDefs": [{
        "targets": [-1],
        "orderable": false,
      }, ],
    });
  });
</script>

<script>
  function tambah() {
    $("#modal_tambah").modal("show");
    $(".modal-title").text("Tambah Menu");
    $("#btnupdate").hide();
    $("#btnsave").show();
    $("#id").val('');
    $("#nama_menu").val('');
    $("#iconx").val('');
    $("#urlx").val('');
  }

  function ubah_nama(nama) {
    str = nama.toLowerCase().replace(/\b[a-z]/g, function(letter) {
      return letter.toUpperCase();
    });
    $("#nama_menu").val(str);
  }

  function tutup() {
    $("#modal_tambah").modal("hide");
  }

  function ubah_menu(id, nama_menu) {
    $.ajax({
      url: "<?= site_url('Menu/get_data_menu/'); ?>" + id,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $("#modal_tambah").modal("show");
        $(".modal-title").text("Ubah Menu");
        $("#btnsave").hide();
        $("#btnupdate").show();
        $("#id").val(id);
        $("#nama_menu").val(nama_menu);
        $("#iconx").val(data.icon);
        $("#urlx").val(data.url);
      }
    });
  }
</script>

<script>
  function simpan() {
    var nama_menu = $("#nama_menu").val();
    var iconx = $("#iconx").val();
    var urlx = $("#urlx").val();
    if (nama_menu == "" || nama_menu == null || iconx == "" || iconx == null || urlx == "" || urlx == null) {
      $("#modal_tambah").modal("hide");
      Swal.fire({
        icon: 'error',
        html: '<span class="text-danger h4 font-weight-bold">TAMBAH MENU</span><br><br>Data belum lengkap!',
      }).then((result) => {
        $("#modal_tambah").modal("show");
        $("#btnupdate").hide();
      });
    } else {
      $.ajax({
        url: "<?= site_url('Menu/get_nama_menu/') ?>" + nama_menu,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#nama_menu").val('');
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">TAMBAH MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $(".modal-title").text("Tambah Menu");
              $("#btnsave").show();
              $("#btnupdate").hide();
              $("#id").val(id);
              $("#nama_menu").val('');
              $("#icon").val('');
              $("#url").val('');
            });
            return;
          } else {
            $.ajax({
              url: "<?= site_url('Menu/simpan_menu') ?>",
              type: "POST",
              data: ($('#form-modal-tambah').serialize()),
              dataType: "JSON",
              success: function(data) {
                if (data.status == 1) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'success',
                    html: '<span class="text-success h4 font-weight-bold">TAMBAH MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Berhasil ditambahkan!',
                  }).then((result) => {
                    location.href = "<?= site_url('Menu'); ?>";
                  });
                } else {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">TAMBAH MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Gagal ditambahkan!',
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
    var id = $("#id").val();
    var nama_menu = $("#nama_menu").val();
    var iconx = $("#iconx").val();
    var urlx = $("#urlx").val();
    if (nama_menu == "" || nama_menu == null || iconx == "" || iconx == null || urlx == "" || urlx == null) {
      $("#modal_tambah").modal("hide");
      Swal.fire({
        icon: 'error',
        html: '<span class="text-danger h4 font-weight-bold">TAMBAH MENU</span><br><br>Data belum lengkap!',
      }).then((result) => {
        ubah_menu(id, nama_menu);
      });
    } else {
      $.ajax({
        url: "<?= site_url('Menu/get_nama_menu/') ?>" + nama_menu,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#nama_menu").val('');
            $("#iconx").val('');
            $("#urlx").val('');
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">UBAH MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $(".modal-title").text("Ubah Menu");
              $("#btnsave").hide();
              $("#btnupdate").show();
              $("#id").val(id);
              $("#nama_menu").val('');
              $("#iconx").val(iconx);
              $("#urlx").val(urlx);
            });
            return;
          } else {
            Swal.fire({
              html: '<span class="text-warning h4 font-weight-bold">UBAH MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Ingin diubah?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, ubah menu',
              cancelButtonText: 'Tidak'
            }).then((result) => {
              if (result.isConfirmed) {
                if (nama_menu == '' || nama_menu == null) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">UBAH MENU</span><br><br>Data belum lengkap!',
                  }).then((result) => {
                    $("#modal_tambah").modal("show");
                    $("#btnsave").hide();
                    $("#btnupdate").show();
                  });
                } else {
                  $.ajax({
                    url: "<?= site_url('Menu/update_menu'); ?>",
                    type: "POST",
                    data: ($('#form-modal-tambah').serialize()),
                    dataType: "JSON",
                    success: function(data) {
                      if (data.status == 1) {
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                          icon: 'success',
                          html: '<span class="text-success h4 font-weight-bold">UBAH MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Berhasil diubah!',
                        }).then((result) => {
                          location.href = "<?= site_url('Menu'); ?>";
                        });
                      } else {
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                          icon: 'error',
                          html: '<span class="text-danger h4 font-weight-bold">UBAH MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Gagal diubah!',
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

  function hapus_menu(id, nama_menu) {
    Swal.fire({
      html: '<span class="text-danger h4 font-weight-bold">HAPUS MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Ingin dihapus?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus menu',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Menu/hapus_menu/'); ?>" + id,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">HAPUS MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Berhasil dihapus!',
              }).then((result) => {
                location.href = "<?= site_url('Menu'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">HAPUS MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Gagal dihapus!',
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