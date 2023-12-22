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
            <button type="button" onclick="tambah()" title="Tambah Supplier" class="btn btn-flat btn-success float-right"><i class="fa-solid fa-plus"></i></button>
            <br>
            <br>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th width="5%">No</th>
                  <th>Kode Supplier</th>
                  <th>Nama Supplier</th>
                  <th>Alamat Supplier</th>
                  <th>Penanggung Jawab</th>
                  <th>Nomor Handphone</th>
                  <th>Email Supplier</th>
                  <th width="10%">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                foreach ($supplier as $s) : ?>
                  <tr>
                    <td class="text-right"><?= $no++; ?></td>
                    <td><?= $s->kode_supplier; ?></td>
                    <td><?= $s->nama_supplier; ?></td>
                    <td><?= $s->alamat; ?></td>
                    <td><?= $s->wali; ?></td>
                    <td><?= $s->nohp_supplier; ?></td>
                    <td><?= $s->email_supplier; ?></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-flat btn-warning" title="Ubah Supplier" onclick="ubah_supplier('<?= $s->id_supplier; ?>', '<?= $s->kode_supplier; ?>', '<?= $s->nama_supplier; ?>', '<?= $s->alamat; ?>', '<?= $s->wali; ?>', '<?= $s->nohp_supplier; ?>', '<?= $s->email_supplier; ?>')"><i class="fa-solid fa-eye-low-vision"></i></button>
                      <?php if ($this->db->query("SELECT * FROM pembelian_h WHERE kode_supplier = '$s->kode_supplier'")->num_rows() < 1) : ?>
                        <button type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus Supplier" onclick="hapus_supplier('<?= $s->id_supplier; ?>', '<?= $s->nama_supplier; ?>')"><i class="fa-solid fa-ban"></i></button>
                      <?php else : ?>
                        <button type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus Supplier" disabled><i class="fa-solid fa-ban"></i></button>
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
  <div class="modal-dialog  modal-dialog-centered modal-lg">
    <div class="modal-content" style="border-top: solid 3px red; border-bottom: solid 3px #0069d9;">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Supplier Baru</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="form-modal-tambah">
        <div class="modal-body">
          <div class="row">
            <div class="col-6">
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="kode_supplier" name="kode_supplier" value="" placeholder="AUTO" readonly>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa-solid fa-code-fork"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" placeholder="Nama Supplier..." onkeyup="ubah_nama(this.value, 1)">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa-solid fa-warehouse"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="wali" name="wali" placeholder="Penanggungjawab..." onkeyup="ubah_nama(this.value, 2)">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa-solid fa-user-tag"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="08..." max="15">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa-solid fa-mobile-screen"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="input-group mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Supplier@gmail.com">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa-solid fa-envelope-circle-check"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="input-group mb-3">
                <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat Supplier..." onkeyup="ubah_nama(this.value, 3)"></textarea>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fa-solid fa-location-crosshairs"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-flat float-right" id="btnsave" onclick="simpan()">Tambahkan Supplier</button>
          <button type="button" class="btn btn-warning btn-flat float-right" id="btnupdate" onclick="update()">Ubah Supplier</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function ubah_nama(nama, id) {
    if (id == 1) {
      str = nama.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
      });
      $("#nama_supplier").val(str);
    } else if (id == 2) {
      str = nama.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
      });
      $("#wali").val(str);
    } else {
      str = nama.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
      });
      $("#alamat").val(str);
    }
  }

  function tambah() {
    $("#modal_tambah").modal("show");
    $(".modal-title").text("Tambah Supplier Baru");
    $("#btnupdate").hide();
    $("#btnsave").show();
    $("#kode_supplier").val('');
    $("#nama_supplier").val('');
  }

  function tutup() {
    $("#modal_tambah").modal("hide");
  }

  function ubah_supplier(id_supplier, kode_supplier, nama_supplier, alamat, wali, no_hp, email) {
    $("#modal_tambah").modal("show");
    $(".modal-title").text("Ubah Supplier");
    $("#btnsave").hide();
    $("#btnupdate").show();
    $("#kode_supplier").val(kode_supplier);
    $("#nama_supplier").val(nama_supplier);
    $("#alamat").val(alamat);
    $("#wali").val(wali);
    $("#no_hp").val(no_hp);
    $("#email").val(email);
  }
</script>

<script>
  function simpan() {
    var nama_supplier = $("#nama_supplier").val();
    if (nama_supplier == '' || nama_supplier == null) {
      $("#modal_tambah").modal("hide");
      Swal.fire({
        icon: 'error',
        html: '<span class="text-danger h4 font-weight-bold">TAMBAH SUPPLIER</span><br><br>Data belum lengkap!',
      }).then((result) => {
        $("#modal_tambah").modal("show");
        $("#btnupdate").hide();
      });
    } else {
      $.ajax({
        url: "<?= site_url('Inti/get_nama_supplier/') ?>" + nama_supplier,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">TAMBAH SUPPLIER</span><br><b>' + nama_supplier.toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $(".modal-title").text("Tambah Supplier Baru");
              $("#btnsave").show();
              $("#btnupdate").hide();
              $("#kode_supplier").val(kode_supplier);
              $("#nama_supplier").val('');
            });
            return;
          } else {
            $.ajax({
              url: "<?= site_url('Inti/simpan_supplier') ?>",
              type: "POST",
              data: ($('#form-modal-tambah').serialize()),
              dataType: "JSON",
              success: function(data) {
                if (data.status == 1) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'success',
                    html: '<span class="text-success h4 font-weight-bold">TAMBAH SUPPLIER</span><br><b>' + nama_supplier.toUpperCase() + '</b><br><br>Berhasil ditambahkan!',
                  }).then((result) => {
                    location.href = "<?= site_url('Inti/supplier'); ?>";
                  });
                } else {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">TAMBAH SUPPLIER</span><br><b>' + nama_supplier.toUpperCase() + '</b><br><br>Gagal ditambahkan!',
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
    var kode_supplier = $("#kode_supplier").val();
    var nama_supplier = $("#nama_supplier").val();
    var alamar = $("#alamar").val();
    var wali = $("#wali").val();
    var no_hp = $("#no_hp").val();
    var wali = $("#wali").val();
    if (nama_supplier == '' || nama_supplier == null) {
      Swal.fire({
        icon: 'error',
        title: 'NAMA',
        text: 'Tidak boleh kosong!',
      });
    } else if (alamat == '' || alamat == null) {
      Swal.fire({
        icon: 'error',
        title: 'ALAMAT',
        text: 'Tidak boleh kosong!',
      });
    } else if (wali == '' || wali == null) {
      Swal.fire({
        icon: 'error',
        title: 'PENANGGUNGJAWAB',
        text: 'Tidak boleh kosong!',
      });
    } else if (no_hp == '' || no_hp == null) {
      Swal.fire({
        icon: 'error',
        title: 'NOMOR HANDPHONE',
        text: 'Tidak boleh kosong!',
      });
    } else if (email == '' || email == null) {
      Swal.fire({
        icon: 'error',
        title: 'EMAIL',
        text: 'Tidak boleh kosong!',
      });
    } else {
      $.ajax({
        url: "<?= site_url('Inti/get_nama_supplier/') ?>" + nama_supplier,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          if (data.status == 1) {
            $("#nama_supplier").val('');
            $("#modal_tambah").modal("hide");
            Swal.fire({
              icon: 'error',
              html: '<span class="text-danger h4 font-weight-bold">UBAH SUPPLIER</span><br><b>' + nama_supplier.toUpperCase() + '</b><br><br>Sudah digunakan!',
            }).then((result) => {
              $("#modal_tambah").modal("show");
              $(".modal-title").text("Ubah Supplier");
              $("#btnsave").hide();
              $("#btnupdate").show();
              $("#kode_supplier").val(kode_supplier);
              $("#nama_supplier").val('');
              $("#alamat").val('');
              $("#wali").val('');
              $("#no_hp").val('');
              $("#email").val('');
            });
            return;
          } else {
            Swal.fire({
              html: '<span class="text-warning h4 font-weight-bold">UBAH SUPPLIER</span><br><b>' + nama_supplier.toUpperCase() + '</b><br><br>Ingin diubah?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, ubah supplier',
              cancelButtonText: 'Tidak'
            }).then((result) => {
              if (result.isConfirmed) {
                if (nama_supplier == '' || nama_supplier == null) {
                  $("#modal_tambah").modal("hide");
                  Swal.fire({
                    icon: 'error',
                    html: '<span class="text-danger h4 font-weight-bold">UBAH KATEGORI</span><br><br>Data belum lengkap!',
                  }).then((result) => {
                    $("#modal_tambah").modal("show");
                    $("#btnsave").hide();
                    $("#btnupdate").show();
                  });
                } else {
                  $.ajax({
                    url: "<?= site_url('Inti/update_supplier'); ?>",
                    type: "POST",
                    data: ($('#form-modal-tambah').serialize()),
                    dataType: "JSON",
                    success: function(data) {
                      if (data.status == 1) {
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                          icon: 'success',
                          html: '<span class="text-success h4 font-weight-bold">UBAH SUPPLIER</span><br><b>' + nama_supplier.toUpperCase() + '</b><br><br>Berhasil diubah!',
                        }).then((result) => {
                          location.href = "<?= site_url('Inti/supplier'); ?>";
                        });
                      } else {
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                          icon: 'error',
                          html: '<span class="text-danger h4 font-weight-bold">UBAH SUPPLIER</span><br><b>' + nama_supplier.toUpperCase() + '</b><br><br>Gagal diubah!',
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

  function hapus_supplier(id_supplier, nama_supplier) {
    Swal.fire({
      html: '<span class="text-danger h4 font-weight-bold">HAPUS SUPPLIER</span><br><b>' + nama_supplier.toUpperCase() + '</b><br><br>Ingin dihapus?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus supplier',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Inti/hapus_supplier/'); ?>" + id_supplier,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">HAPUS SUPPLIER</span><br><b>' + nama_supplier.toUpperCase() + '</b><br><br>Berhasil dihapus!',
              }).then((result) => {
                location.href = "<?= site_url('Inti/supplier'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">HAPUS SUPPLIER</span><br><b>' + nama_supplier.toUpperCase() + '</b><br><br>Gagal dihapus!',
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