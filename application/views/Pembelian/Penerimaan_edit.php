<?php
$invoice = $header->invoice;
$tgl_terima = date("Y-m-d", strtotime($header->tgl_terima));
$jam_terima = date("H:i:s", strtotime($header->jam_terima));
$supplier = $header->kode_supplier;
$gudang = $header->kode_gudang;
$sup = $this->db->query("SELECT kode_supplier AS id, concat(nama_supplier) AS text FROM supplier WHERE kode_supplier = '$supplier'")->row();
$gud = $this->db->query("SELECT kode_gudang AS id, concat(nama_gudang) AS text FROM gudang WHERE kode_gudang = '$gudang'")->row();
if ($header->invoice_po == "" || $header->invoice_po == null) {
  $data_po = "";
  $cekpo = "";
  $cek_po = 0;
} else {
  $data_po = $this->db->query("SELECT invoice AS id, concat(invoice, ' | ', tgl_pembelian, ' | ', jam_pembelian) AS text FROM po_h WHERE invoice = '$header->invoice_po'")->row();
  $cekpo = "checked";
  $cek_po = 1;
}
if ($header->ppn > 0) {
  $cekppn = "checked";
  $cek_ppn = 1;
  $ppn = $this->db->query("SELECT id_ppn AS id, concat(nama_ppn) AS text FROM ppn WHERE id_ppn = '$header->ppn'")->row();
} else {
  $cekppn = "";
  $cek_ppn = 0;
  $ppn = "";
}
if ($header->ppn > 0) {
  $kode_ppn = $this->db->get_where("ppn", ["id_ppn" => $header->ppn])->row()->value_ppn;
} else {
  $kode_ppn = 0;
}
?>
<section class="content">
  <form method="POST" id="form-terima">
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
            <div class="table-responsive">
              <a type="button" href="<?= site_url('Pembelian/terima'); ?>" title="Kembali" class="btn btn-flat btn-danger float-right"><i class="fa-solid fa-backward"></i></a>
              <br>
              <br>
              <div class="card shadow border-primary">
                <div class="card-header">
                  <h3 class="card-title">Form Data Terima</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <div class="row mb-3">
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-sm-3">
                            <label>Invoice</label>
                          </div>
                          <div class="col-sm-9">
                            <input type="text" name="invoice" id="invoice" placeholder="AUTO" readonly class="form-control" value="<?= $invoice; ?>">
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-sm-3">
                            <label>PO <sup class="text-danger" id="sup_po">*</sup></label>
                          </div>
                          <div class="col-sm-9">
                            <div class="row">
                              <div class="col-sm-2" style="margin-bottom: 5px;">
                                <input type="checkbox" name="cekpo" id="cekpo" class="form-control" onclick="pocek();" <?= $cekpo; ?>>
                                <input type="hidden" name="cek_po" id="cek_po" value=" <?= $cek_po; ?>">
                              </div>
                              <div class="col-sm-10" id="c_po">
                                <select name="kode_po" id="kode_po" class="form-control select2_po" data-placeholder="PO (Pre Order)" onchange="get_data_po(this.value)" style="width: 100%;">
                                  <?php if ($data_po) : ?>
                                    <option value="<?= $data_po->id; ?>"><?= $data_po->text; ?></option>
                                  <?php endif; ?>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-sm-3">
                            <label>Tanggal</label>
                          </div>
                          <div class="col-sm-9">
                            <?php if ($this->session->userdata("id_role") < 2) {
                              $dis = "";
                            } else {
                              $dis = "readonly";
                            } ?>
                            <div class="row">
                              <div class="col-sm-6" style="margin-bottom: 5px;">
                                <input type="date" id="tgl_terima" name="tgl_terima" class="form-control" value="<?= $tgl_terima; ?>" <?= $dis; ?>>
                              </div>
                              <div class="col-sm-6">
                                <input type="time" id="jam_terima" name="jam_terima" class="form-control" value="<?= $jam_terima; ?>" <?= $dis; ?>>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-sm-3">
                            <label>Supplier <sup class="text-danger">*</sup></label>
                          </div>
                          <div class="col-sm-5">
                            <select name="kode_supplier" id="kode_supplier" class="form-control select2_supplier" data-placeholder="Supplier" style="width: 100%;">
                              <?php if ($sup) : ?>
                                <option value="<?= $sup->id; ?>"><?= $sup->text; ?></option>
                              <?php endif; ?>
                            </select>
                          </div>
                          <div class="col-sm-4">
                            <select name="kode_gudang" id="kode_gudang" class="form-control select2_gudang" data-placeholder="Gudang" style="width: 100%;">
                              <?php if ($gud) : ?>
                                <option value="<?= $gud->id; ?>"><?= $gud->text; ?></option>
                              <?php endif; ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row md-3">
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-sm-3">
                            <label>PPN <sup class="text-danger" id="sup_ppn">*</sup></label>
                          </div>
                          <div class="col-sm-9">
                            <div class="row">
                              <div class="col-sm-2" style="margin-bottom: 5px;">
                                <input type="checkbox" <?= $cekppn; ?> name="cekppn" id="cekppn" class="form-control" onclick="ppncek(); total();">
                                <input type="hidden" name="cek_ppn" id="cek_ppn" value="<?= $cek_ppn; ?>">
                              </div>
                              <div class="col-sm-10" id="c_ppn">
                                <select name="id_ppn" id="id_ppn" class="form-control select2_ppn" data-placeholder="PPN" onchange="get_ppn(this.value);" style="width: 100%;">
                                  <?php if ($ppn) : ?>
                                    <option value="<?= $ppn->id; ?>"><?= $ppn->text; ?></option>
                                  <?php endif; ?>
                                </select>
                                <input type="hidden" name="kode_ppn" id="kode_ppn" value="<?= $kode_ppn; ?>">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-sm-3">
                            <label>Alasan <sup class="text-danger">*</sup></label>
                          </div>
                          <div class="col-sm-9">
                            <textarea name="alasan" id="alasan" class="form-control"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card shadow border-danger">
                <div class="card-header">
                  <h3 class="card-title">Detail Data Terima</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="table-responsive">
                        <table class="table table-striped table-hover" id="terima_detail">
                          <thead class="bg-danger">
                            <tr class="text-center">
                              <th style="width: 5%;">Hapus</th>
                              <th style="width: 16%;">Barang</th>
                              <th style="width: 10%;">Satuan</th>
                              <th style="width: 10%;">Expire</th>
                              <th style="width: 10%;">Qty</th>
                              <th style="width: 10%;">Harga</th>
                              <th style="width: 12%;">Disc (%)</th>
                              <th style="width: 12%;">Disc (Rp)</th>
                              <th style="width: 15%;">Total</th>
                            </tr>
                          </thead>
                          <tbody id="datatable_body">
                            <?php
                            $no = 1;
                            foreach ($detail as $d) :
                            ?>
                              <tr id="tr_<?= $no; ?>">
                                <td class="text-center">
                                  <button type="button" class="btn btn-warning btn-flat" id="btnHapus<?= $no; ?>" name="btnHapus[]" onclick="hapusBaris(<?= $no; ?>)" title="Hapus Baris"><i class="fa-solid fa-eraser"></i></button>
                                </td>
                                <td>
                                  <select name="kode_barang[]" id="kode_barang<?= $no; ?>" class="form-control select2_barang" data-placeholder="Cari Barang" onchange="showbarang(this.value, <?= $no; ?>)">
                                    <?php
                                    $barang = $this->db->query("SELECT kode_barang AS id, concat(nama_barang, ' | ', satuan, ' | ', harga_beli) AS text FROM barang WHERE kode_barang = '$d->kode_barang'")->row();
                                    ?>
                                    <option value="<?= $barang->id; ?>"><?= $barang->text; ?></option>
                                  </select>
                                  <input type="hidden" name="nama_barang[]" id="nama_barang<?= $no; ?>" class="form-control" readonly value="<?= $d->nama; ?>">
                                </td>
                                <td>
                                  <?php
                                  $satuan = $this->db->query("SELECT kode_satuan AS id, concat(nama_satuan) AS text FROM satuan WHERE kode_satuan = '$d->satuan'")->row();
                                  ?>
                                  <input type="hidden" name="kode_satuan[]" id="kode_satuan<?= $no; ?>" class="form-control" readonly value="<?= $satuan->id; ?>">
                                  <input type="text" name="satuan_barang[]" id="satuan_barang<?= $no; ?>" class="form-control" readonly value="<?= $satuan->text; ?>">
                                </td>
                                <td>
                                  <input type="date" name="tgl_expire[]" id="tgl_expire<?= $no; ?>" class="form-control" value="<?= date('Y-m-d', strtotime($d->tgl_expire)) ?>" min="<?= date('Y-m-d', strtotime('+2 Year')) ?>">
                                </td>
                                <td>
                                  <input type="text" name="qty_barang[]" id="qty_barang<?= $no; ?>" class="form-control text-right" onchange="totalline(<?= $no; ?>)" value="<?= number_format($d->qty); ?>" min="1">
                                </td>
                                <td>
                                  <input type="text" name="harga_barang[]" id="harga_barang<?= $no; ?>" class="form-control text-right" readonly value="<?= number_format($d->harga); ?>">
                                </td>
                                <td>
                                  <input type="text" name="discpr_barang[]" id="discpr_barang<?= $no; ?>" class="form-control text-right" onchange="total_discpr(<?= $no; ?>)" value="<?= number_format($d->disc_pr); ?>">
                                </td>
                                <td>
                                  <input type="text" name="discrp_barang[]" id="discrp_barang<?= $no; ?>" class="form-control text-right" onchange="total_discrp(<?= $no; ?>)" value="<?= number_format($d->disc_rp); ?>">
                                </td>
                                <td>
                                  <input type="text" name="total_barang[]" id="total_barang<?= $no; ?>" class="form-control text-right" readonly value="<?= number_format($d->total); ?>">
                                </td>
                              </tr>
                            <?php $no++;
                            endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-8" style="margin-bottom: 5px;">
                      <button type="button" class="btn btn-success btn-flat" id="btnTambah" onclick="tambah()" title="Tambah Baris"><i class="fa-solid fa-plus"></i></button>
                      <button type="button" class="btn btn-danger btn-flat" id="btnHapusSemua" onclick="hapusSemua()" title="Hapus Semua Baris"><i class="fa-regular fa-trash-can"></i></button>
                      <button type="button" class="btn btn-primary btn-flat float-right" id="btnSimpan" onclick="simpan()" title="Ubah Data Pembelian">Update <i class="fa-solid fa-save"></i></button>
                    </div>
                    <div class="col-sm-4">
                      <div class="card border-danger">
                        <div class="card-body">
                          <div class="row mb-3">
                            <div class="col-sm-3">
                              <label>Sub Total</label>
                            </div>
                            <div class="col-sm-9">
                              <input type="text" class="form-control flat text-right" name="sub_total" id="sub_total" value="0" readonly>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-sm-3">
                              <label>Diskon</label>
                            </div>
                            <div class="col-sm-9">
                              <input type="text" class="form-control flat text-right" name="diskon" id="diskon" value="0" readonly>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-sm-3">
                              <label>PPN</label>
                            </div>
                            <div class="col-sm-9">
                              <input type="text" class="form-control flat text-right" name="ppn_rp" id="ppn_rp" value="0" readonly>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-sm-3">
                              <label>Total</label>
                            </div>
                            <div class="col-sm-9">
                              <input type="text" class="form-control flat text-right" name="total_semua" id="total_semua" value="0" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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
    var cabang = '<?= $cabang; ?>';
    initailizeSelect2_supplier(cabang);
    initailizeSelect2_gudang(cabang);
    initailizeSelect2_ppn();
    initailizeSelect2_barang(cabang);
    initailizeSelect2_po(cabang);
    ppncek();
    $("#sup_ppn").hide();
    total();
  });

  function ppncek() {
    if (document.getElementById("cekppn").checked == true) {
      $("#cek_ppn").val(1);
      $("#sup_ppn").show();
      $("#c_ppn").show(200);
    } else {
      $("#cek_ppn").val(0);
      $("#sup_ppn").hide();
      $("#c_ppn").hide(200);
    }
  }

  function get_ppn(id) {
    $.ajax({
      url: "<?= site_url('Select2_master/get_ppn/'); ?>" + id,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $("#kode_ppn").val(data);
        total();
      }
    });
  }

  function pocek() {
    if (document.getElementById("cekpo").checked == true) {
      $("#cek_po").val(1);
      $("#sup_po").show();
      $("#c_po").show(200);
    } else {
      $("#cek_po").val(0);
      $("#sup_po").hide();
      $("#c_po").hide(200);
      hapusSemua();
    }
  }

  function ppncek() {
    if (document.getElementById("cekppn").checked == true) {
      $("#cek_ppn").val(1);
      $("#sup_ppn").show();
      $("#c_ppn").show(200);
    } else {
      $("#cek_ppn").val(0);
      $("#sup_ppn").hide();
      $("#c_ppn").hide(200);
    }
  }

  var idrow = <?= $jumdata + 1; ?>;
  var arr = [1];

  function tambah() {
    var tablex = document.getElementById("terima_detail");
    var idrow = tablex.rows.length;
    var table = $("#terima_detail");
    table.append(`<tr id="tr_` + idrow + `">
      <td class="text-center">
        <button type="button" class="btn btn-warning btn-flat" id="btnHapus` + idrow + `" name="btnHapus[]" onclick="hapusBaris(` + idrow + `)" title="Hapus Baris"><i class="fa-solid fa-eraser"></i></button>
      </td>
      <td>
        <select name="kode_barang[]" id="kode_barang` + idrow + `" class="form-control select2_barang" data-placeholder="Cari Barang" onchange="showbarang(this.value, ` + idrow + `)"></select>
        <input type="hidden" name="nama_barang[]" id="nama_barang` + idrow + `" class="form-control" readonly>
      </td>
      <td>
        <input type="hidden" name="kode_satuan[]" id="kode_satuan` + idrow + `" class="form-control" readonly>
        <input type="text" name="satuan_barang[]" id="satuan_barang` + idrow + `" class="form-control" readonly>
      </td>
      <td>
        <input type="date" name="tgl_expire[]" id="tgl_expire` + idrow + `" class="form-control" value="<?= date('Y-m-d', strtotime('+2 Year')) ?>" min="<?= date('Y-m-d', strtotime('+2 Year')) ?>">
      </td>
      <td>
        <input type="text" name="qty_barang[]" id="qty_barang` + idrow + `" class="form-control text-right" onchange="totalline(` + idrow + `)" value="1" min="1">
      </td>
      <td>
        <input type="text" name="harga_barang[]" id="harga_barang` + idrow + `" class="form-control text-right" readonly value="0">
      </td>
      <td>
        <input type="text" name="discpr_barang[]" id="discpr_barang` + idrow + `" class="form-control text-right" onchange="total_discpr(` + idrow + `)" value="0">
      </td>
      <td>
        <input type="text" name="discrp_barang[]" id="discrp_barang` + idrow + `" class="form-control text-right" onchange="total_discrp(` + idrow + `)" value="0">
      </td>
      <td>
        <input type="text" name="total_barang[]" id="total_barang` + idrow + `" class="form-control text-right" readonly value="0">
      </td>
    </tr>`);
    var cabang = '<?= $cabang; ?>';
    initailizeSelect2_supplier(cabang);
    initailizeSelect2_gudang(cabang);
    initailizeSelect2_ppn();
    initailizeSelect2_barang(cabang);
    idrow++;
  }

  function hapusBaris(param) {
    $("#tr_" + param).remove();
    total();
  }

  function hapusSemua() {
    $("#datatable_body").empty();
    tambah();
    total();
  }

  function showbarang(kode, id) {
    $.ajax({
      url: "<?= site_url('Master/get_barang/?kode_barang='); ?>" + kode,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $("#nama_barang" + id).val(data.nama_barang);
        $("#kode_satuan" + id).val(data.kode_satuan);
        $("#satuan_barang" + id).val(data.nama_satuan);
        $("#harga_barang" + id).val(formatRupiah(data.harga_beli));
        totalline(id);
      }
    });
  }

  function totalline(id) {
    var qty_ = $("#qty_barang" + id).val();
    var qty = Number(parseInt(qty_.replaceAll(",", "")));
    var harga_ = $("#harga_barang" + id).val();
    var harga = Number(parseInt(harga_.replaceAll(",", "")));
    var discpr_ = $("#discpr_barang" + id).val();
    var discpr = Number(parseInt(discpr_.replaceAll(",", "")));
    var discrp_ = $("#discrp_barang" + id).val();
    var discrp = Number(parseInt(discrp_.replaceAll(",", "")));
    var total_barang = qty * harga - discrp;
    // $("#discpr_barang" + id).val(formatRupiah(0));
    $("#discrp_barang" + id).val(formatRupiah(discrp));
    $("#qty_barang" + id).val(formatRupiah(qty));
    $("#total_barang" + id).val(formatRupiah(total_barang));
    total();
  }

  function total_discpr(id) {
    var qty_ = $("#qty_barang" + id).val();
    var qty = Number(parseInt(qty_.replaceAll(",", "")));
    var harga_ = $("#harga_barang" + id).val();
    var harga = Number(parseInt(harga_.replaceAll(",", "")));
    var discpr_ = $("#discpr_barang" + id).val();
    var discpr = Number(parseInt(discpr_.replaceAll(",", "")));
    if (discpr > 100) {
      dis = 100;
    } else {
      dis = discpr;
    }
    var discrp = (qty * harga) * (discpr / 100);
    var total_barang = (qty * harga) - discrp;
    $("#discpr_barang" + id).val(formatRupiah(dis));
    $("#discrp_barang" + id).val(formatRupiah(discrp));
    $("#qty_barang" + id).val(formatRupiah(qty));
    $("#total_barang" + id).val(formatRupiah(total_barang));
    total();
  }

  function total_discrp(id) {
    var qty_ = $("#qty_barang" + id).val();
    var qty = Number(parseInt(qty_.replaceAll(",", "")));
    var harga_ = $("#harga_barang" + id).val();
    var harga = Number(parseInt(harga_.replaceAll(",", "")));
    var discrp_ = $("#discrp_barang" + id).val();
    var discrp = Number(parseInt(discrp_.replaceAll(",", "")));
    var total_barang = (qty * harga) - discrp;
    $("#discpr_barang" + id).val(formatRupiah(0));
    $("#discrp_barang" + id).val(formatRupiah(discrp));
    $("#qty_barang" + id).val(formatRupiah(qty));
    $("#total_barang" + id).val(formatRupiah(total_barang));
    total();
  }

  function total() {
    var ppn = $("#cek_ppn").val();
    if (ppn > 0) {
      var cekppn = $("#kode_ppn").val();
      if (cekppn == "" || cekppn == null) {
        var pajak = 0;
      } else {
        var pajak = $("#kode_ppn").val();
      }
    } else {
      var pajak = 0;
    }
    var table = document.getElementById("terima_detail");
    var rowCount = table.rows.length;
    var sub_total = 0;
    var sub_diskon = 0;
    var kena_pajak = 0;
    for (var i = 1; i < rowCount; i++) {
      var row = table.rows[i];
      var total_barang_ = row.cells[8].children[0].value;
      var total_barang = Number(total_barang_.replace(/[^0-9\.]+/g, ""));
      var discrp_barang_ = row.cells[7].children[0].value;
      var discrp_barang = Number(discrp_barang_.replace(/[^0-9\.]+/g, ""));
      sub_diskon += discrp_barang;
      sub_total += (total_barang + discrp_barang);
      kena_pajak += (total_barang * (pajak / 100));
    }
    var total_semua = ((sub_total - sub_diskon) + kena_pajak);
    $("#sub_total").val(formatRupiah(sub_total));
    $("#diskon").val(formatRupiah(sub_diskon));
    $("#ppn_rp").val(formatRupiah(kena_pajak));
    $("#total_semua").val(formatRupiah(total_semua));
  }
</script>

<script>
  var arr = [1];

  function get_data_po(invoice_po) {
    $.ajax({
      url: "<?= site_url('Pembelian/ambil_data_po/'); ?>" + invoice_po,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $("#kode_supplier").append(`<option value="` + data.kode_supplier + `">` + data.nama_supplier + `</option>`);
        if (data.pajak == 1) {
          document.getElementById("cekppn").checked = true;
          $("#sup_ppn").show();
          $("#cek_ppn").val(1);
          get_ppn(data.ppn);
          $("#id_ppn").append(`<option value="` + data.ppn + `">` + data.nama_ppn + `</option>`);
        } else {
          document.getElementById("cekppn").checked = false;
          $("#sup_ppn").hide();
          $("#cek_ppn").val(0);
        }
        ppncek();
        get_detail_po(invoice_po);
      }
    });
  }

  function get_detail_po(invoice_po) {
    $.ajax({
      url: "<?= site_url('Pembelian/ambil_detail_po/'); ?>" + invoice_po,
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        hapusSemua();
        var no = 0;
        var opt = data;
        var body = $("#terima_detail");
        $("#datatable_body").empty();
        $(opt).each(function() {
          body.append(`<tr id="tr_` + no + `">
            <td class="text-center">
              <button type="button" class="btn btn-warning btn-flat" id="btnHapus` + no + `" name="btnHapus[]" onclick="hapusBaris(` + no + `)" title="Hapus Baris"><i class="fa-solid fa-eraser"></i></button>
            </td>
            <td>
              <select name="kode_barang[]" id="kode_barang` + no + `" class="form-control select2_barang" data-placeholder="Cari Barang" onchange="showbarang(this.value, ` + no + `)">
                <option value="` + opt[no].kode_barang + `">` + opt[no].text + `</option>
              </select>
              <input type="hidden" name="nama_barang[]" id="nama_barang` + no + `" class="form-control" readonly value="` + opt[no].nama + `">
            </td>
            <td>
              <input type="hidden" name="kode_satuan[]" id="kode_satuan` + no + `" class="form-control" readonly value="` + opt[no].kode_satuan + `">
              <input type="text" name="satuan_barang[]" id="satuan_barang` + no + `" class="form-control" readonly value="` + opt[no].nama_satuan + `">
            </td>
            <td>
              <input type="date" name="tgl_expire[]" id="tgl_expire` + idrow + `" class="form-control" value="<?= date('Y-m-d', strtotime('+2 Year')) ?>" min="<?= date('Y-m-d', strtotime('+2 Year')) ?>">
            </td>
            <td>
              <input type="text" name="qty_barang[]" id="qty_barang` + no + `" class="form-control text-right" onchange="totalline(` + no + `)" value="` + formatRupiah(opt[no].qty) + `" min="1">
            </td>
            <td>
              <input type="text" name="harga_barang[]" id="harga_barang` + no + `" class="form-control text-right" readonly value="` + formatRupiah(opt[no].harga) + `">
            </td>
            <td>
              <input type="text" name="discpr_barang[]" id="discpr_barang` + no + `" class="form-control text-right" onchange="total_discpr(` + no + `)" value="` + formatRupiah(opt[no].disc_pr) + `">
            </td>
            <td>
              <input type="text" name="discrp_barang[]" id="discrp_barang` + no + `" class="form-control text-right" onchange="total_discrp(` + no + `)" value="` + formatRupiah(opt[no].disc_rp) + `">
            </td>
            <td>
              <input type="text" name="total_barang[]" id="total_barang` + no + `" class="form-control text-right" readonly value="` + formatRupiah(opt[no].total) + `">
            </td>
          </tr>`);
          $("#tgl_expire" + no).val(opt[no].tgl_expire).change();
          totalline(no);
          var cabang = '<?= $cabang; ?>';
          initailizeSelect2_supplier(cabang);
          initailizeSelect2_gudang(cabang);
          initailizeSelect2_ppn();
          initailizeSelect2_barang(cabang);
          initailizeSelect2_po(cabang);
          no++;
        });
      }
    });
  }

  function ppncek() {
    if (document.getElementById("cekppn").checked == true) {
      $("#cek_ppn").val(1);
      $("#sup_ppn").show();
      $("#c_ppn").show(200);
    } else {
      $("#cek_ppn").val(0);
      $("#sup_ppn").hide();
      $("#c_ppn").hide(200);
    }
  }
</script>

<script>
  function simpan() {
    if (document.getElementById("cekpo").checked == true) {
      var status_po = 1;
    } else {
      var status_po = 0;
    }
    if (status_po == 1) {
      var inv_po = $("#kode_po").val();
      if (inv_po == "" || inv_po == null) {
        Swal.fire({
          icon: 'error',
          title: 'PO',
          text: 'Tidak boleh kosong!',
        });
        return;
      }
    }
    var supplier = $("#kode_supplier").val();
    if (supplier == "" || supplier == null) {
      Swal.fire({
        icon: 'error',
        title: 'SUPPLIER',
        text: 'Tidak boleh kosong!',
      });
      return;
    }
    if (document.getElementById("cekppn").checked == true) {
      var pajak = 1;
    } else {
      var pajak = 0;
    }
    if (pajak == 1) {
      var ppn = $("#kode_ppn").val();
      if (ppn == "" || ppn == null) {
        Swal.fire({
          icon: 'error',
          title: 'PPN',
          text: 'Tidak boleh kosong!',
        });
        return;
      }
    }
    if ($("#alasan").val() == "") {
      Swal.fire({
        icon: 'error',
        title: 'ALASAN',
        text: 'Tidak boleh kosong!',
      });
      return;
    }
    $.ajax({
      url: "<?= site_url('Pembelian/simpan_terima/2') ?>",
      type: "POST",
      data: ($('#form-terima').serialize()),
      dataType: "JSON",
      success: function(data) {
        if (data.status == 1) {
          Swal.fire({
            icon: 'success',
            html: '<span class="text-success h4 font-weight-bold">UBAH DATA PEMBELIAN</span><br><b>' + (data.invoice).toUpperCase() + '</b><br><br>Berhasil diubah!',
          }).then((result) => {
            location.href = "<?= site_url('Pembelian/terima'); ?>";
          });
        } else {
          Swal.fire({
            icon: 'error',
            html: '<span class="text-danger h4 font-weight-bold">UBAH DATA PEMBELIAN</span><br><br>Gagal diubah!',
          });
        }
      }
    })
  }
</script>