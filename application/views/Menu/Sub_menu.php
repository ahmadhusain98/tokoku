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
            <select name="group_menu" id="group_menu" class="select2_all" data-placeholder="Group By Menu..." style="width: 40%" onchange="get_menu(this.value)">
              <option value="">Group By Menu...</option>
              <?php foreach ($menu as $m) : ?>
                <?php if ($id_menu == $m->id) {
                  $select = 'selected';
                } else {
                  $select = '';
                } ?>
                <option value="<?= $m->id ?>" <?= $select; ?>><?= $m->nama_menu; ?></option>
              <?php endforeach; ?>
            </select>
            <button type="button" onclick="tambah()" title="Tambah Sub Menu" class="btn btn-flat btn-success float-right"><i class="fa-solid fa-plus"></i></button>
            <br>
            <br>
            <table id="table-submenu" class="table table-bordered table-striped" style="width: 100%;">
              <thead class="text-center">
                <tr>
                  <th width="5%">No</th>
                  <th>Menu Utama</th>
                  <th>Sub Menu</th>
                  <th width="7%">Icon</th>
                  <th>Url</th>
                  <th width="10%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($sub_menu as $sm) :
                  $menu = $this->db->get_where("menu", ["id" => $sm->id_menu])->row();
                ?>
                  <tr>
                    <td><?= $no; ?></td>
                    <td><?= $menu->nama_menu; ?></td>
                    <td><?= $sm->nama_menu; ?></td>
                    <td class="text-center"><?= $sm->icon; ?></td>
                    <td><?= $sm->url; ?></td>
                    <td class="text-center">
                      <button type="button" style="margin-bottom: 5px;" class="btn btn-flat btn-warning btn-sm" title="Ubah Menu" onclick="ubah_menu('<?= $sm->id; ?>', '<?= $sm->nama_menu; ?>')"><i class="fa-solid fa-eye-low-vision"></i></button>
                      <?php
                      $cek_menu = $this->db->get_where("menu", ["id" => $sm->id_menu])->row();
                      $cek = $this->db->query("SELECT sm.* FROM akses_menu sm WHERE sm.id_menu = '$cek_menu->id'")->num_rows();
                      if ($cek > 0) {
                        $disabled = "disabled";
                      } else {
                        $cek2 = $this->db->query("SELECT * FROM sub_menu WHERE id_menu = '$sm->id'")->num_rows();
                        if ($cek2 > 0) {
                          $disabled = "disabled";
                        } else {
                          $disabled = "";
                        }
                      }
                      ?>
                      <button type="button" style="margin-bottom: 5px;" <?= $disabled; ?> class="btn btn-flat btn-sm btn-danger" title="Hapus Menu" onclick="hapus_menu('<?= $sm->id; ?>', '<?= $sm->nama_menu; ?>')"><i class="fa-solid fa-ban"></i></button>
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
        <h4 class="modal-title">Tambah Sub Menu</h4>
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
            <select name="id_menu" id="id_menu" class="form-control select2_modal" data-placeholder="Pilih Menu Utama..." style="width: 85%;">
              <option value="">Pilih Menu Utama...</option>
              <?php
              $menux = $this->db->get("menu")->result();
              foreach ($menux as $m) :
              ?>
                <option value="<?= $m->id; ?>"><?= $m->nama_menu; ?></option>
              <?php endforeach; ?>
            </select>
            <div class="input-group-append" style="width: 15%;">
              <div class="input-group-text">
                <span class="fa-solid fa-bars"></span>
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
          <button type="button" class="btn btn-primary btn-flat float-right" id="btnsave" onclick="simpan()">Tambahkan Sub Menu</button>
          <button type="button" class="btn btn-warning btn-flat float-right" id="btnupdate" onclick="update()">Ubah Sub Menu</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#table-submenu').DataTable({
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

  function get_menu(id) {
    location.href = "<?= site_url('Menu/sub_menu?id_menu=') ?>" + id;
  }

  $(".select2_modal").select2({
    allowClear: true,
    placeholder: $(this).data('placeholder'),
    multiple: false,
    dropdownAutoWidth: true,
  })
</script>

<script>
  function tambah() {
    $("#modal_tambah").modal("show");
    $(".modal-title").text("Tambah Sub Menu");
    $("#btnupdate").hide();
    $("#btnsave").show();
    $("#id").val('');
    $("#id_menu").val('').change();
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
      url: "<?= site_url('Menu/get_data_sub_menu/'); ?>" + id,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $("#modal_tambah").modal("show");
        $(".modal-title").text("Ubah Menu");
        $("#btnsave").hide();
        $("#btnupdate").show();
        $("#id").val(id);
        $("#id_menu").val(data.id_menu).change();
        $("#nama_menu").val(nama_menu);
        $("#iconx").val(data.icon);
        $("#urlx").val(data.url);
      }
    });
  }
</script>

<script>
  function simpan() {
    var id_menu = $("#id_menu").val();
    var nama_menu = $("#nama_menu").val();
    var iconx = $("#iconx").val();
    var urlx = $("#urlx").val();
    if (id_menu == "" || id_menu == null || nama_menu == "" || nama_menu == null || iconx == "" || iconx == null || urlx == "" || urlx == null) {
      $("#modal_tambah").modal("hide");
      Swal.fire({
        icon: 'error',
        html: '<span class="text-danger h4 font-weight-bold">TAMBAH SUB MENU</span><br><br>Data belum lengkap!',
      }).then((result) => {
        $("#modal_tambah").modal("show");
        $("#btnupdate").hide();
      });
    } else {
      $.ajax({
        url: "<?= site_url('Menu/get_nama_sub_menu/') ?>" + nama_menu,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#nama_menu").val('');
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">TAMBAH SUB MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $(".modal-title").text("Tambah Sub Menu");
              $("#btnsave").show();
              $("#btnupdate").hide();
              $("#id").val(id);
              $("#id_menu").val('').change();
              $("#nama_menu").val('');
              $("#icon").val('');
              $("#url").val('');
            });
            return;
          } else {
            $.ajax({
              url: "<?= site_url('Menu/simpan_sub_menu') ?>",
              type: "POST",
              data: ($('#form-modal-tambah').serialize()),
              dataType: "JSON",
              success: function(data) {
                if (data.status == 1) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'success',
                    html: '<span class="text-success h4 font-weight-bold">TAMBAH SUB MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Berhasil ditambahkan!',
                  }).then((result) => {
                    location.href = "<?= site_url('Menu/sub_menu'); ?>";
                  });
                } else {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">TAMBAH SUB MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Gagal ditambahkan!',
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
    var id_menu = $("#id_menu").val();
    var nama_menu = $("#nama_menu").val();
    var iconx = $("#iconx").val();
    var urlx = $("#urlx").val();
    if (id_menu == "" || id_menu == null || nama_menu == "" || nama_menu == null || iconx == "" || iconx == null || urlx == "" || urlx == null) {
      $("#modal_tambah").modal("hide");
      Swal.fire({
        icon: 'error',
        html: '<span class="text-danger h4 font-weight-bold">TAMBAH SUB MENU</span><br><br>Data belum lengkap!',
      }).then((result) => {
        ubah_menu(id, nama_menu);
      });
    } else {
      $.ajax({
        url: "<?= site_url('Menu/get_nama_sub_menu/') ?>" + nama_menu,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#id_menu").val('').change();
            $("#nama_menu").val('');
            $("#iconx").val('');
            $("#urlx").val('');
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">UBAH SUB MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $(".modal-title").text("Ubah Sub Menu");
              $("#btnsave").hide();
              $("#btnupdate").show();
              $("#id").val(id);
              $("#id_menu").val(id_menu).change();
              $("#nama_menu").val('');
              $("#iconx").val(iconx);
              $("#urlx").val(urlx);
            });
            return;
          } else {
            Swal.fire({
              html: '<span class="text-warning h4 font-weight-bold">UBAH SUB MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Ingin diubah?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, ubah sub menu',
              cancelButtonText: 'Tidak'
            }).then((result) => {
              if (result.isConfirmed) {
                if (id_menu == "" || id_menu == null || nama_menu == "" || nama_menu == null || iconx == "" || iconx == null || urlx == "" || urlx == null) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">UBAH SUB MENU</span><br><br>Data belum lengkap!',
                  }).then((result) => {
                    $("#modal_tambah").modal("show");
                    $("#btnsave").hide();
                    $("#btnupdate").show();
                  });
                } else {
                  $.ajax({
                    url: "<?= site_url('Menu/update_sub_menu'); ?>",
                    type: "POST",
                    data: ($('#form-modal-tambah').serialize()),
                    dataType: "JSON",
                    success: function(data) {
                      if (data.status == 1) {
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                          icon: 'success',
                          html: '<span class="text-success h4 font-weight-bold">UBAH SUB MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Berhasil diubah!',
                        }).then((result) => {
                          location.href = "<?= site_url('Menu/sub_menu'); ?>";
                        });
                      } else {
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                          icon: 'error',
                          html: '<span class="text-danger h4 font-weight-bold">UBAH SUB MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Gagal diubah!',
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
      html: '<span class="text-danger h4 font-weight-bold">HAPUS SUB MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Ingin dihapus?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus sub menu',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Menu/hapus_sub_menu/'); ?>" + id,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">HAPUS SUB MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Berhasil dihapus!',
              }).then((result) => {
                location.href = "<?= site_url('Menu/sub_menu'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">HAPUS SUB MENU</span><br><b>' + nama_menu.toUpperCase() + '</b><br><br>Gagal dihapus!',
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