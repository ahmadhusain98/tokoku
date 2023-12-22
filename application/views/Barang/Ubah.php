<section class="content">
  <form method="post" id="form-tambah">
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
          <div class="col-sm-12">
            <div class="card shadow" style="border-top: 5px solid blue; border-bottom: 5px solid red;">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="h4">Update
                      <a class="btn btn-flat btn-danger float-right" href="<?= site_url('Master/barang'); ?>" type="button" title="Kembali"><i class="fa-solid fa-backward"></i></a>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Kategori <sup class="text-danger">*</sup></label>
                      <?php $kategori = $this->db->query("SELECT * FROM kategori WHERE kode_cabang = '$barang->kode_cabang' AND kode_kategori = '$barang->kode_kategori'")->row(); ?>
                      <div class="col-sm-9">
                        <select name="kode_kategori" id="kode_kategori" class="form-control select2_kategori" data-placeholder="Kategori">
                          <option value="<?= $barang->kode_kategori ?>" selected><?= $kategori->nama_kategori ?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Kode Barang <sup class="text-danger">*</sup></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="<?= $barang->kode_barang; ?>" readonly>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Nama Barang <sup class="text-danger">*</sup></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="..." value="<?= $barang->nama_barang; ?>" onkeyup="ubah_nama(this.value)">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Satuan <sup class="text-danger">*</sup></label>
                      <?php $satuan1 = $this->db->query("SELECT * FROM satuan WHERE kode_cabang = '$barang->kode_cabang' AND kode_satuan = '$barang->satuan'")->row(); ?>
                      <div class="col-sm-9">
                        <select name="satuan" id="satuan" class="form-control select2_satuan" data-placeholder="Satuan">
                          <option value="<?= $barang->satuan ?>" selected><?= $satuan1->nama_satuan ?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Stok Awal</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control text-right" id="saldo_awal" name="saldo_awal" placeholder="0" value="<?= number_format($barang->saldo_awal); ?>" onkeyup="format_currency()">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Harga Beli <sup class="text-danger">*</sup></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control text-right" id="harga_beli" name="harga_beli" placeholder="0" value="<?= number_format($barang->harga_beli); ?>" onkeyup="cek_hj(); format_currency()">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Profit <sup class="text-danger">*</sup></label>
                      <div class="col-sm-6" style="margin-bottom: 5px;">
                        <select name="pilihan_profit" id="pilihan_profit" class="form-control select2_all" style="width: 100%;" data-placeholder="Pilih..." onchange="format(this.value)">
                          <option value="">Pilih...</option>
                          <option value="manual" <?= ($barang->pilihan_profit == 'manual') ? 'selected' : '' ?>>Manual</option>
                          <option value="persentase" <?= ($barang->pilihan_profit == 'persentase') ? 'selected' : '' ?>>Persentase</option>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <?php if ($barang->pilihan_profit == 'persentase') {
                          $profit = ($barang->profit * 100) / $barang->harga_beli;
                        } else {
                          $profit = $barang->profit;
                        } ?>
                        <input type="text" class="form-control text-right" id="profit" name="profit" onkeyup="cek_hj(); format_currency()" value="<?= number_format($profit); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Diskon</label>
                      <div class="col-sm-6" style="margin-bottom: 5px;">
                        <select name="pilihan_diskon" id="pilihan_diskon" class="form-control select2_all" style="width: 100%;" data-placeholder="Pilih..." onchange="format_diskon(this.value)">
                          <option value="">Pilih...</option>
                          <option value="manual" <?= ($barang->pilihan_disc == 'manual') ? 'selected' : '' ?>>Manual</option>
                          <option value="persentase" <?= ($barang->pilihan_disc == 'persentase') ? 'selected' : '' ?>>Persentase</option>
                        </select>
                      </div>
                      <div class="col-sm-3">
                        <?php if ($barang->pilihan_disc == 'persentase') {
                          $disc = ($barang->disc * 100) / ($barang->harga_beli + $barang->profit);
                        } else {
                          $disc = $barang->disc;
                        } ?>
                        <input type="text" class="form-control text-right" id="diskon" name="diskon" onkeyup="cek_hj(); format_currency()" value="<?= number_format($disc); ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <label for="Gambar" class="col-3 col-form-label">Gambar</label>
                      <div class="col-sm-3" style="margin-bottom: 5px;">
                        <img id="preview_img" class="profile-user-img img-fluid" src="<?= base_url('assets/img/barang/') . $barang->gambar; ?>" alt="User profile picture">
                      </div>
                      <div class="col-sm-6">
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="filefoto" aria-describedby="inputGroupFileAddon01" name="filefoto">
                            <label class="custom-file-label" id="label-gambar" for="inputGroupFile01">Cari Gambar</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">Harga Jual <sup class="text-danger">*</sup></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control text-right" id="harga_jual" name="harga_jual" placeholder="[Beli + Profit]" readonly value="<?= number_format($barang->harga_jual); ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-6">
                    <button id="btnsave" class="btn btn-warning btn-sm btn-flat" type="button" onclick="simpan()">Update <i class="fa-solid fa-rotate"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>

<script>
  $(document).ready(function() {
    var cabang = '<?= $barang->kode_cabang; ?>';
    initailizeSelect2_satuan(cabang);
    initailizeSelect2_kategori(cabang);

    var pilihan_profit = $("#pilihan_profit").val();
    format(pilihan_profit);
  });

  function ubah_nama(nama) {
    // var nama_barang = nama.charAt(0).toUpperCase() + nama.slice(1);
    str = nama.toLowerCase().replace(/\b[a-z]/g, function(letter) {
      return letter.toUpperCase();
    });
    $("#nama_barang").val(str);
  }

  // when photo has been change
  $("#filefoto").change(function() {
    readURL(this);
  });

  // preview image
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#div_preview_foto').css("display", "block");
        $('#preview_img').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    } else {
      $('#div_preview_foto').css("display", "none");
      $('#preview_img').attr('src', '');
    }
  }

  function format(param) {
    if (param == "persentase") {
      document.getElementById("profit").placeholder = "%";
    } else {
      document.getElementById("profit").placeholder = "Rp";
    }
  }

  function format_currency() {
    if ($("#saldo_awal").val() == '') {
      var saldoawal = 0;
    } else {
      var saldoawal = Number(parseInt(($("#saldo_awal").val()).replaceAll(',', '')));
    }
    $("#saldo_awal").val(formatRupiah(saldoawal));

    if ($("#harga_beli").val() == '') {
      var harga_beli = 0;
    } else {
      var harga_beli = Number(parseInt(($("#harga_beli").val()).replaceAll(',', '')));
    }
    $("#harga_beli").val(formatRupiah(harga_beli));

    if ($("#profit").val() == '') {
      var profit = 0;
    } else {
      var profit = Number(parseInt(($("#profit").val()).replaceAll(',', '')));
    }
    $("#profit").val(formatRupiah(profit));

    if ($("#diskon").val() == '') {
      var diskon = 0;
    } else {
      var diskon = Number(parseInt(($("#diskon").val()).replaceAll(',', '')));
    }
    $("#diskon").val(formatRupiah(diskon));

    if ($("#harga_jual").val() == '') {
      var harga_jual = 0;
    } else {
      var harga_jual = Number(parseInt(($("#harga_jual").val()).replaceAll(',', '')));
    }
    $("#harga_jual").val(formatRupiah(harga_jual));
  }

  function cek_hj() {
    if ($("#harga_beli").val() == '') {
      var harga_beli = 0;
    } else {
      var harga_beli = Number(parseInt(($("#harga_beli").val()).replaceAll(',', '')));
    }
    if (harga_beli != '' || harga_beli > 0) {
      $("#pilihan_profit").attr("disabled", false);
      $("#profit").attr("disabled", false);
    } else {
      $("#pilihan_profit").attr("disabled", true);
      $("#profit").attr("disabled", true);
    }
    if ($("#profit").val() == '') {
      var profit = 0;
    } else {
      var profit = Number(parseInt(($("#profit").val()).replaceAll(',', '')));
    }
    if ($("#diskon").val() == '') {
      var diskon = 0;
    } else {
      var diskon = Number(parseInt(($("#diskon").val()).replaceAll(',', '')));
    }
    var pilihan_profit = $("#pilihan_profit").val();
    if (pilihan_profit == "persentase") {
      var hj = harga_beli + (harga_beli * (profit / 100));
    } else {
      var hj = harga_beli + profit;
    }
    var pilihan_diskon = $("#pilihan_diskon").val();
    if (pilihan_diskon == "persentase") {
      var hasil = hj - (hj * (diskon / 100));
    } else {
      var hasil = hj - diskon;
    }
    var hargajual = hasil;
    $("#harga_jual").val(formatRupiah(hargajual));
  }
</script>

<script>
  function simpan() {
    var kode_kategori = $("#kode_kategori").val();
    var nama_barang = $("#nama_barang").val();
    var satuan = $("#satuan").val();
    var profit = $("#profit").val();
    var harga_beli = $("#harga_beli").val();
    if (kode_kategori == '' || kode_kategori == null) {
      Swal.fire({
        icon: 'error',
        title: 'KATEGORI',
        text: 'Tidak boleh kosong!',
      });
      return;
    }
    if (nama_barang == '') {
      Swal.fire({
        icon: 'error',
        title: 'NAMA BARANG',
        text: 'Tidak boleh kosong!',
      });
      return;
    }
    if (satuan == '' || satuan == null || satuan == 'null') {
      Swal.fire({
        icon: 'error',
        title: 'SATUAN 1',
        text: 'Tidak boleh kosong!',
      });
      return;
    }
    if (harga_beli == '') {
      Swal.fire({
        icon: 'error',
        title: 'HARGA BELI',
        text: 'Tidak boleh kosong!',
      });
      return;
    }
    if (profit == '' || profit < 1) {
      Swal.fire({
        icon: 'error',
        title: 'PROFIT',
        text: 'Tidak boleh kosong!',
      });
      return;
    }
    Swal.fire({
      html: '<span class="text-warning font-weight-bold h4">UBAH BARANG</span><br><b>' + nama_barang.toUpperCase() + "</b><br><br>Yakin ingin mengubah barang ini ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, ubah barang',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        var form = $('#form-tambah')[0];
        var data = new FormData(form);
        $.ajax({
          url: "<?= site_url('Master/edit_barang_aksi') ?>",
          type: "POST",
          enctype: 'multipart/form-data',
          data: data,
          dataType: "JSON",
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">BARANG</span><br><b>' + nama_barang.toUpperCase() + "</b><br><br>Berhasil diubah",
              }).then((result) => {
                location.href = "<?= site_url('Master/barang'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">BARANG</span><br><b>' + nama_barang.toUpperCase() + "</b><br><br>Gagal diubah",
              });
            }
          }
        });
      }
    });
  }
</script>