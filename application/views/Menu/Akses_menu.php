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
          <div class="table-responsive"><button type="button" onclick="tambah()" title="Tambah Akses Manual" class="btn btn-flat btn-success float-right"><i class="fa-solid fa-plus"></i></button>
            <br>
            <br>
            <table id="table-akses" class="table table-bordered table-striped" style="width: 100%;">
              <thead class="text-center">
                <tr>
                  <th width="5%" rowspan="2">No</th>
                  <th rowspan="2">Nama Menu Utama</th>
                  <th colspan="<?= $jumrole; ?>">Tingkatan</th>
                </tr>
                <tr>
                  <?php foreach ($role as $r) : ?>
                    <th><?= $r->tingkatan; ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $nox = 1;
                foreach ($menu as $m) :
                ?>
                  <tr>
                    <td class="text-right"><?= $nox; ?></td>
                    <td><?= $m->nama_menu; ?></td>
                    <?php
                    $no = 1;
                    foreach ($role as $r) :
                      $cek_am = $this->db->query("SELECT * FROM akses_menu WHERE id_menu = '$m->id' AND id_role = '$r->id_role'")->row();
                      if ($cek_am) {
                        $id_am = $cek_am->id;
                        if ($r->id_role == $cek_am->id_role) {
                          $cekcked = "checked";
                        } else {
                          $cekcked = "";
                        }
                      } else {
                        $cekcked = "";
                        $id_am = 0;
                      }
                    ?>
                      <td class="text-center">
                        <input type="checkbox" <?= $cekcked; ?> name="id_role[]" id="id_role<?= $nox; ?>_<?= $r->id_role; ?>" class="form-control" onclick="ubah_akses('<?= $id_am; ?>', '<?= $nox; ?>', '<?= $no; ?>', '<?= $m->id; ?>', '<?= $r->id_role; ?>', '<?= $m->nama_menu; ?>', '<?= $r->tingkatan; ?>')">
                      </td>
                    <?php
                      $no++;
                    endforeach;
                    ?>
                  </tr>
                <?php
                  $nox++;
                endforeach;
                ?>
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
        <h4 class="modal-title">Tambah Akses Manual</h4>
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
            <select name="id_menu" id="id_menu" class="form-control select2_modal" data-placeholder="Pilih Menu..." style="width: 85%;">
              <option value="">Pilih Menu...</option>
              <?php
              $menux = $this->db->get("menu")->result();
              foreach ($menux as $m) :
              ?>
                <option value="<?= $m->id; ?>"><?= $m->nama_menu; ?></option>
              <?php endforeach; ?>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-bars"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <select name="id_rolex" id="id_rolex" class="form-control select2_modal2" data-placeholder="Pilih Tingkatan..." style="width: 85%;">
              <option value="">Pilih Tingkatan...</option>
              <?php
              $rolex = $this->db->get("role")->result();
              foreach ($rolex as $rx) :
              ?>
                <option value="<?= $rx->id_role; ?>"><?= $rx->tingkatan; ?></option>
              <?php endforeach; ?>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa-solid fa-user-tie"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-flat float-right" id="btnsave" onclick="simpan()">Tambahkan Akses Manual</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#table-akses').DataTable({
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

  function tambah() {
    $("#modal_tambah").modal("show");
    $(".modal-title").text("Tambah Akses Manual");
    $("#btnupdate").hide();
    $("#btnsave").show();
    $("#id").val('');
    $("#id_menu").val('').change();
    $("#id_role").val('').change();
  }

  $(".select2_modal").select2({
    allowClear: true,
    dropdownParent: $("#modal_tambah"),
  })

  $(".select2_modal2").select2({
    allowClear: true,
    dropdownParent: $("#modal_tambah"),
  })
</script>

<script>
  function ubah_akses(id_akses, no1, no2, id_menu, id_role, nama_menu, tingkatan) {
    Swal.fire({
      html: '<span class="text-warning h4 font-weight-bold">UBAH AKSES</span><br>Menu <b style="color: red;">' + nama_menu.toUpperCase() + '</b><br>Diubah akses <b>' + tingkatan.toUpperCase() + '</b>?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, ubah akses',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Menu/ubah_akses/'); ?>" + id_akses + "?id_role=" + id_role + "&id_menu=" + id_menu,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">UBAH AKSES</span><br><b>' + tingkatan.toUpperCase() + '</b> Menu <b style="color: red;">' + nama_menu.toUpperCase() + '</b><br><br>Berhasil diubah',
              }).then((result) => {
                location.href = "<?= site_url('Menu/akses_menu'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">UBAH AKSES</span><br><b>' + tingkatan.toUpperCase() + '</b> Menu <b style="color: red;">' + nama_menu.toUpperCase() + '</b><br><br>Gagal diubah',
              });
              document.getElementById("id_role" + no1 + "_" + id_role).checked = false;
            }
          }
        });
      } else {
        document.getElementById("id_role" + no1 + "_" + id_role).checked = false;
      }
    });
  }

  function simpan() {
    var id_menu = $("#id_menu").val();
    var id_rolex = $("#id_rolex").val();
    if (id_menu == "" || id_menu == null || id_rolex == "" || id_rolex == null) {
      $("#modal_tambah").modal("hide");
      Swal.fire({
        icon: 'error',
        html: '<span class="text-danger h4 font-weight-bold">TAMBAH AKSES MANUAL</span><br><br>Data belum lengkap!',
      }).then((result) => {
        $("#modal_tambah").modal("show");
      });
    } else {
      $.ajax({
        url: "<?= site_url('Menu/cek_akses/') ?>" + id_menu + "/" + id_rolex,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#id_menu").val('').change();
            $("#id_rolex").val('').change();
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">TAMBAH AKSES MANUAL</span><br><b>' + (data.nama_menu).toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
            });
            return;
          } else {
            $.ajax({
              url: "<?= site_url('Menu/tambah_akses') ?>",
              type: "POST",
              data: ($('#form-modal-tambah').serialize()),
              dataType: "JSON",
              success: function(data) {
                if (data.status == 1) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'success',
                    html: '<span class="text-success h4 font-weight-bold">TAMBAH AKSES MANUAL</span><br><b>' + (data.nama_menu).toUpperCase() + '</b><br><br>Berhasil ditambahkan!',
                  }).then((result) => {
                    location.href = "<?= site_url('Menu/akses_menu'); ?>";
                  });
                } else {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">TAMBAH AKSES MENU</span><br><b>' + (data.nama_menu).toUpperCase() + '</b><br><br>Gagal ditambahkan!',
                  }).then((result) => {
                    $("#modal_tambah").modal("show");
                  });
                }
              }
            });
          }
        }
      });
    }
  }
</script>