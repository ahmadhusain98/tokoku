<?php $saldo = $this->db->query("SELECT saldo_akhir FROM stok WHERE kode_cabang = '$barang->kode_cabang' AND kode_barang = '$barang->kode_barang'")->row(); ?>
<section class="content">
  <form method="post" id="form-pesan">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div>
              <span class="h5 font-weight-bold">Detail Barang</span>
              <a class="btn btn-danger btn-flat float-right" title="Kembali" type="button" href="<?= site_url('Penjualan'); ?>"><i class="fa-solid fa-backward"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-9" style="margin-bottom: 5px;">
        <div class="card mb-3 h-100">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-5 my-auto">
                <img src="<?= site_url('assets/img/barang/') . $barang->gambar; ?>" class="img-fluid" width="100%">
              </div>
              <input type="hidden" name="selain" id="selain" value="<?= $barang->kode_barang; ?>">
              <div class="col-sm-7">
                <div class="h4 font-weight-bold">
                  <?= $barang->nama_barang; ?>
                </div>
                <span><i class="fa-solid fa-star"></i> 0 | Terjual 0</span>
                <br>
                <?php
                $satuanz = $this->db->query("SELECT * FROM satuan WHERE kode_satuan = '$barang->satuan'")->row();
                $satuan = $barang->satuan;
                ?>
                <div><span class="h3 font-weight-bold" style="font-size: 30px;">Rp. <?= number_format($barang->harga_jual); ?></span> / <?= $satuan; ?></div>
                <input type="hidden" name="takaran" id="takaran" value="<?= $satuan; ?>">
                <?php if ((int)$barang->disc > 0) : ?>
                  <span class="font-weight-bold badge badge-danger" style="font-size: 18px;"><?= number_format(((int)$barang->disc / ((int)$barang->harga_jual + (int)$barang->disc)) * 100) . ' %'; ?></span> <span class="my-auto" style="text-decoration: line-through;">Rp. <?= number_format($barang->harga_jual + $barang->disc); ?></span>
                <?php endif; ?>
                <hr>
                <div class="row">
                  <div class="col-sm-8">
                    <div class="h4 font-weight-bold">Detail</div>
                    <div class="table-responsive">
                      <table border="0" width="100%">
                        <tr>
                          <td width="30%">Nama</td>
                          <td width="2%"> : </td>
                          <td><?= $barang->nama_barang; ?></td>
                        </tr>
                        <tr>
                          <td>Kategori</td>
                          <td> : </td>
                          <td><?= $barang->nama_kategori ?></td>
                        </tr>
                        <tr>
                          <td>Satuan</td>
                          <td> : </td>
                          <td>
                            <?= $barang->satuan; ?>
                          </td>
                        </tr>
                        <tr>
                          <td>Tersisa</td>
                          <td> : </td>
                          <td>
                            <?= number_format($saldo->saldo_akhir) . ' ' . $barang->satuan; ?>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="h4 font-weight-bold">Grafik</div>
                    <div id="graph_jual"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card mb-3 h-100">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                Atur jumlah dan catatan
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text bg-danger" onclick="min()"><i class="fa-solid fa-minus"></i></div>
                  </div>
                  <input type="text" class="form-control text-right" id="qty" value="1" min="1" name="qty" onkeyup="format_currency()">
                  <div class="input-group-prepend">
                    <div class="input-group-text bg-primary" onclick="plus('<?= $saldo->saldo_akhir; ?>')"><i class="fa-solid fa-plus"></i></div>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12">
                <div class="h6">Subtotal</div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <input type="hidden" name="hargajual" id="hargajual" value="<?= $barang->harga_jual; ?>">
                <div class="h1">Rp. <span class="float-right" id="subtotal"><?= number_format($barang->harga_jual); ?></span></div>
              </div>
            </div>
            <br>
            <div class="row justify-content-center">
              <div class="table-responsive">
                <table border="0" width="100%">
                  <tr>
                    <td class="text-center">
                      <input type="checkbox" name="antar" id="antar" class="form-control" onclick="cara_beli(1)">
                    </td>
                    <td class="text-center">
                      <input type="checkbox" name="ambil" id="ambil" class="form-control" onclick="cara_beli(2)">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">
                      <span>Antar</span>
                    </td>
                    <td class="text-center">
                      <span>Ambil</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12">
                <button class="btn btn-success btn-flat text-center" type="button" style="width: 100%;" id="btnpesan" disabled onclick="pesan_barang('<?= $barang->nama_barang; ?>')">Pesan</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>
<br>
<section class="content">
  <div class="row justify-content-center" id="body-card">
    <?php
    $cabang = $this->session->userdata("cabang");
    $barangx = $this->db->query("SELECT b.*, b.disc, (SELECT nama_satuan FROM satuan WHERE kode_satuan = b.satuan) as satuan, nama_kategori FROM barang b JOIN kategori USING (kode_kategori) WHERE b.kode_cabang = '$cabang' AND b.kode_barang != '$barang->kode_barang' ORDER BY b.kode_barang ASC")->result();
    $jum = count($barangx);
    ?>
    <?php foreach ($barangx as $b) : ?>
      <div class="col-lg-3 col-6 text-center mb-3">
        <div class="card shadow mb-3 h-100" onclick="detail('<?= $b->kode_barang; ?>')">
          <?php if ((int)$b->disc > 0) {
            $border = 'border-danger';
          } else {
            $border = '';
          } ?>
          <img src="<?= site_url('assets/img/barang/') . $b->gambar; ?>" class="img-thumbnail img-fluid <?= $border; ?>" alt="Gambar">
          <div class="card-body">
            <div class="row h-50">
              <div class="col-sm-12 text-left">
                <span title="<?= $b->nama_barang; ?>" class="h5 font-weight-bold"><?= mb_strimwidth($b->nama_barang, 0, 22, "..."); ?></span>
              </div>
            </div>
            <div class="row" style="margin-top: -10px;">
              <div class="col-sm-12 text-left">
                <span style="font-size: 10px;">Kategori : <?= $b->nama_kategori; ?></span>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 text-left" style="margin-bottom: 5px;;">
                <span class="font-weight-bold badge badge-warning" style="font-size: 18px; width: 100%">Rp. <?= number_format($b->harga_jual); ?></span>
              </div>
              <?php if ((int)$b->disc > 0) : ?>
                <div class="col-sm-6 text-left">
                  <span class="font-weight-bold badge badge-danger" style="font-size: 18px; width: 100%">Disc <?= number_format(((int)$b->disc / ((int)$b->harga_jual + (int)$b->disc)) * 100) . ' %'; ?></span>
                </div>
              <?php else : ?>
                <div class="col-sm-6"></div>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-12 text-left">
                <?php
                $terjual = $this->db->query("SELECT SUM(qty) as qty FROM order_pesanan WHERE kode_barang = '$b->kode_barang' AND status_order = 0")->row();
                if ($terjual) {
                  if ($terjual->qty > 0) {
                    $terjual = number_format($terjual->qty);
                  } else {
                    $terjual = number_format(0);
                  }
                } else {
                  $terjual = number_format(0);
                }
                ?>
                <span><i class="fa-solid fa-star"></i> 0 | Terjual <?= $terjual ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<script>
  $(document).ready(function() {
    graph_jual.draw([0,
      <?php
      foreach ($loop as $l) {
        echo $l['qty'] . ',';
      }
      ?>
    ]);
  });

  function cara_beli(par) {
    var qtyx = $("#qty").val();
    var qty = Number(parseInt(qtyx.replaceAll(',', '')));
    if (par == 1) {
      Swal.fire({
        icon: 'info',
        title: 'ANTAR BARANG',
        text: 'Menambah biaya transportasi antar sebesar 2,000/Km!',
      });
      document.getElementById("antar").checked = true;
      document.getElementById("ambil").checked = false;
    } else {
      document.getElementById("antar").checked = false;
      document.getElementById("ambil").checked = true;
    }
    if (qty < 1) {
      $("#btnpesan").attr("disabled", true);
    } else {
      $("#btnpesan").attr("disabled", false);
    }
  }

  function min() {
    var hargajual = $("#hargajual").val();
    var qtyx = $("#qty").val();
    var qty = Number(parseInt(qtyx.replaceAll(',', '')));
    if (qty <= 1) {
      $("#qty").val(1);
      $("#subtotal").text(formatRupiah(hargajual * 1));
      $("#btnpesan").attr("disabled", true);
      return;
    } else {
      $("#qty").val(formatRupiah(qty - 1));
      $("#subtotal").text(formatRupiah(hargajual * (qty - 1)));
      if ((document.getElementById("antar").checked == true) || (document.getElementById("ambil").checked == true)) {
        $("#btnpesan").attr("disabled", false);
      }
    }

    if ((hargajual * (qty - 1)) <= 1) {
      $("#qty").val(1);
      $("#subtotal").text(formatRupiah(hargajual * 0));
      $("#btnpesan").attr("disabled", true);
    } else {
      $("#qty").val(formatRupiah(qty - 1));
      $("#subtotal").text(formatRupiah(hargajual * (qty - 1)));
      if ((document.getElementById("antar").checked == true) || (document.getElementById("ambil").checked == true)) {
        $("#btnpesan").attr("disabled", false);
      }
    }
  }

  function plus(saldo_akhir) {
    var hargajual = $("#hargajual").val();
    var qtyx = $("#qty").val();
    var qty = Number(parseInt(qtyx.replaceAll(',', '')));
    if ((qty + 1) > saldo_akhir) {
      Swal.fire({
        icon: 'error',
        title: 'SISA STOK',
        text: 'Tersisa ' + formatRupiah(saldo_akhir) + ', qty melebihi batas!',
      });
      $("#qty").val(formatRupiah(saldo_akhir));
      $("#subtotal").text(formatRupiah(hargajual * (saldo_akhir)));
    } else {
      $("#qty").val(formatRupiah(qty + 1));
      $("#subtotal").text(formatRupiah(hargajual * (qty + 1)));
    }
    if ((document.getElementById("antar").checked == true) || (document.getElementById("ambil").checked == true)) {
      $("#btnpesan").attr("disabled", false);
    }
  }

  function format_currency() {
    var hargajual = $("#hargajual").val();
    var qtyx = $("#qty").val();
    var qtyy = Number(parseInt(qtyx.replaceAll(',', '')));
    if (qtyy <= 1 || $("#qty").val() == '' || $("#qty").val() == null) {
      qty = 1;
      $("#btnpesan").attr("disabled", true);
    } else {
      qty = qtyy;
      $("#btnpesan").attr("disabled", false);
    }
    $("#qty").val(formatRupiah(qty));
    $("#subtotal").text(formatRupiah(hargajual * qty));
  }

  function detail(kode) {
    location.href = "<?= site_url('Penjualan/detail/') ?>" + kode;
  }
</script>

<script>
  function cari(par) {
    var selain = $("#selain").val();
    var params = par.toLowerCase();
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("body-card").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "<?php echo base_url(); ?>Penjualan/isi_detail/" + params + '?selain=' + selain, true);
    xhttp.send();
  }

  function pesan_barang(nama_barang) {
    var kode_barang = $("#selain").val();
    var qtyx = $("#qty").val();
    var qty = Number(parseInt(qtyx.replaceAll(',', '')));
    if (document.getElementById("antar").checked == true) {
      var status_antar = 2;
    } else {
      var status_antar = 1;
    }
    Swal.fire({
      html: '<span class="text-warning font-weight-bold h4">PESAN BARANG</span><br><b>' + nama_barang.toUpperCase() + "</b><br>Dengan Qty Sebanyak : " + qtyx + "<br><br>Pesanan sudah sesuai ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, sesuai',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Penjualan/pesan_barang/') ?>" + qty + "?status_antar=" + status_antar,
          type: "POST",
          data: ($('#form-pesan').serialize()),
          dataType: "JSON",
          success: function(data) {
            // console.log(data);
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">PESAN BARANG</span><br><b>' + nama_barang.toUpperCase() + "</b><br>Dengan Qty Sebanyak : " + qtyx + "<br><br>Berhasil dipesan",
              }).then((result) => {
                location.href = "<?= site_url('Penjualan/detail/'); ?>" + kode_barang;
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">PESAN BARANG</span><br><b>' + nama_barang.toUpperCase() + "</b><br>Dengan Qty Sebanyak : " + qtyx + "<br><br>Gagal dipesan",
              });
            }
          }
        });
      }
    });
  }
</script>

<script src="<?= base_url('tema'); ?>/plugins/sparklines/sparkline.js"></script>

<script>
  var graph_jual = new Sparkline($('#graph_jual')[0], {
    width: 100,
    height: 100,
    lineColor: '#92c1dc',
    endColor: '#92c1dc'
  });
</script>