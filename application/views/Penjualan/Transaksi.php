<section class="content">
  <div class="row justify-content-center" id="body-card">
    <?php
    if ($barang) :
      foreach ($barang as $b) :
    ?>
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
      <?php
      endforeach;
    else :
      ?>
      <div class="col-sm-12 text-center mb-3" style="height: 100%;">
        <div class="h5 m-auto">
          Tidak ada Barang yang dijual
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<script>
  function cari(par) {
    var params = par.toLowerCase();
    if (params != '' || params != null || params != 'null') {
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("body-card").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "<?php echo base_url(); ?>Penjualan/isi/" + params, true);
      xhttp.send();
    } else {
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("body-card").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "<?php echo base_url(); ?>Penjualan/isi_kosong/", true);
      xhttp.send();
    }
  }
</script>

<script>
  function detail(kode) {
    location.href = "<?= site_url('Penjualan/detail/') ?>" + kode;
  }
</script>