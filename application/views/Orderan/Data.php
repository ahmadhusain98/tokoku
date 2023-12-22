<section class="content">
  <div class="row">
    <div class="col-sm-8" style="margin-bottom: 5px;">
      <div class="card mb-3 h-100">
        <div class="card-body">
          <div class="table-responsive">
            <table border="0" width="100%" cellspacing="5" cellpadding="5" class="table table-bordered table-striped table-hover table-responsive" id="table-standar">
              <thead>
                <tr class="text-center">
                  <th style="width: 5%;">Hapus</th>
                  <th>Barang</th>
                  <th>Qty</th>
                  <th>Harga</th>
                  <th>Sub Total</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                $total = 0;
                foreach ($orderan as $or) : ?>
                  <tr id="tr_<?= $no; ?>">
                    <td class="text-center">
                      <button type="button" title="Hapus <?= $or->nama_barang; ?>" class="btn btn-danger btn-flat" id="btnhapus<?= $no; ?>" onclick="hapusOrderan(<?= $no; ?>)"><i class="fa fa-ban"></i></button>
                    </td>
                    <td style="width: 20%;" class="text-center">
                      <div class="row">
                        <div class="col text-center">
                          <img src="<?= site_url('assets/img/barang/') . $or->gambar; ?>" alt="gambar" style="width: 50px;">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col text-center">
                          <span><?= $or->nama_barang; ?></span>
                        </div>
                      </div>
                    </td>
                    <td style="width: 15%">
                      <input type="text" id="qty<?= $no; ?>" name="qty[]" class="form-control text-right" value="<?= number_format($or->qty); ?>" onkeyup="ubah_total(this.value, <?= $no; ?>); format_currency(<?= $no; ?>)">
                    </td>
                    <td>
                      Rp. <span class="float-right" id="harga_jual<?= $no; ?>"><?= number_format($or->harga_jual); ?></span>
                    </td>
                    <td>
                      <input type="hidden" name="subtotal[]" id="subtotal<?= $no; ?>" value="<?= number_format($or->harga_jual * $or->qty); ?>">
                      Rp. <span class="float-right font-weight-bold" id="sub_total<?= $no; ?>"><?= number_format($or->harga_jual * $or->qty); ?></span>
                    </td>
                  </tr>
                <?php $total += ($or->harga_jual * $or->qty);
                  $no++;
                endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="card mb-3 h-100">
        <div class="card-body">
          <div class="h4 font-weight-bold text-danger">
            TOTAL
            <a class="btn btn-flat btn-danger float-right" href="<?= site_url('Penjualan'); ?>" type="button" title="Kembali"><i class="fa-solid fa-backward"></i></a>
          </div>
          <div style="font-size: 50px; font-weight: bold">Rp. <span id="total_"><?= number_format($total); ?></span></div>
          <hr>
          <div class="card mb-3 card-flat" style="background-color: #f4f6f9;">
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-sm-3">Tanggal</div>
                <div class="col-sm-md-9">
                  <input type="date" name="tgl_trx" id="tgl_trx" class="form-control" value="<?= date('Y-m-d'); ?>" readonly>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-3">Jam</div>
                <div class="col-sm-md-9">
                  <input type="time" name="tgl_trx" id="tgl_trx" class="form-control" value="<?= date('H:i:s'); ?>" readonly>
                </div>
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-danger btn-flat p-2 btn-sm" style="width: 49%;" onclick="hapusSemua()">Batalkan &nbsp;&nbsp;&nbsp;<i class="fa-regular fa-thumbs-down"></i></button>
          <button type="button" class="btn btn-success p-2 btn-sm btn-flat" style="width: 49%;" title="Mulai Proses Transaksi">Proses &nbsp;&nbsp;&nbsp;<i class="fa-regular fa-thumbs-up"></i></button>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function ubah_total(param, id) {
    var qtyx = $("#qty" + id).val();
    if (qtyx == '') {
      qtyx = 0;
      $("#qty" + id).val(0);
      $("#sub_total" + id).text(formatRupiah(0));
      $("#subtotal" + id).val(formatRupiah(0));
    } else {
      qtyx = qtyx;
      var qty = Number(parseInt(qtyx.replaceAll(',', '')));
      var harga_jualx = $("#harga_jual" + id).text();
      var harga_jual = Number(parseInt(harga_jualx.replaceAll(',', '')));
      var sub_total = qty * harga_jual;
      $("#sub_total" + id).text(formatRupiah(sub_total));
      $("#subtotal" + id).val(formatRupiah(sub_total));
      total();
    }
  }

  function format_currency(id) {
    if ($("#qty" + id).val() == '') {
      var qty = 0;
    } else {
      var qty = Number(parseInt(($("#qty" + id).val()).replaceAll(',', '')));
    }
    $("#qty" + id).val(formatRupiah(qty));

    if ($("#harga_jual" + id).text() == '') {
      var harga_jual = 0;
    } else {
      var harga_jual = Number(parseInt(($("#harga_jual" + id).text()).replaceAll(',', '')));
    }
    $("#harga_jual" + id).text(formatRupiah(harga_jual));

  }

  function total() {
    var table = document.getElementById("table-standar");
    var rowCount = table.rows.length;
    var tot = 0;
    for (var i = 1; i < rowCount; i++) {
      var row = table.rows[i];
      sub_total_ = row.cells[4].children[0].value;
      var sub_total = Number(sub_total_.replace(/[^0-9\.]+/g, ""));
      tot += sub_total;
    }
    $("#total_").text(formatRupiah(tot));
  }

  function hapusOrderan(param) {
    $("#tr_" + param).remove();
    total();
  }

  function hapusSemua() {
    Swal.fire({
      title: 'BATALKAN',
      text: "Yakin ingin membatalkan pesanan ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, batalkan',
      cancelButtonText: 'Tetap memesan'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Orderan/Batalkan_pesanan'); ?>",
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                title: 'BATALKAN',
                text: 'Berhasil dilakukan',
              }).then((result) => {
                location.href = "<?= site_url('Orderan'); ?>";
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'BATALKAN',
                text: 'Gagal dilakukan',
              })
            }
          }
        });
      }
    })
  }
</script>