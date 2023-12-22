<section class="content">
    <form method="POST" id="form-jual">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-11" style="margin-bottom: 5px;">
                        <h3 class="card-title"><?= $judul; ?></h3>
                    </div>
                    <div class="col-sm-1">
                        <a type="button" href="<?= site_url('Penjualan_barang/jual'); ?>" title="Kembali" class="btn btn-flat btn-danger float-right"><i class="fa-solid fa-backward"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <div class="card shadow border-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Form Data Jual</h3>
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
                                                        <input type="text" name="invoice" id="invoice" placeholder="AUTO" readonly class="form-control">
                                                    </div>
                                                </div>
                                            </div>
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
                                                                <input type="date" id="tgl_jual" name="tgl_jual" class="form-control" value="<?= date('Y-m-d'); ?>" <?= $dis; ?>>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input type="time" id="jam_jual" name="jam_jual" class="form-control" value="<?= date('H:i:s'); ?>" <?= $dis; ?>>
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
                                                        <label>Gudang <sup class="text-danger">*</sup></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select name="kode_gudang" id="kode_gudang" class="form-control select2_gudang" data-placeholder="Gudang" style="width: 100%;" onchange="get_barang(this.value)"></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label>PPN <sup class="text-danger" id="sup_ppn">*</sup></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="row">
                                                            <div class="col-sm-2" style="margin-bottom: 5px;">
                                                                <input type="checkbox" name="cekppn" id="cekppn" class="form-control" onclick="ppncek(); total();">
                                                                <input type="hidden" name="cek_ppn" id="cek_ppn" value="0">
                                                            </div>
                                                            <div class="col-sm-10" id="c_ppn">
                                                                <select name="id_ppn" id="id_ppn" class="form-control select2_ppn" data-placeholder="PPN" onchange="get_ppn(this.value)" style="width: 100%;"></select>
                                                                <input type="hidden" name="kode_ppn" id="kode_ppn">
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
                                                        <label>Pembeli <sup class="text-danger">*</sup></label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select name="kode_pembeli" id="kode_pembeli" class="form-control select2_pembeli" data-placeholder="Pembeli" style="width: 100%;" onchange="pembeli(this.value)"></select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label>Alamat</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <textarea name="alamat" id="alamat" class="form-control" placeholder="Alamat AUTO" readonly></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow border-danger">
                                <div class="card-header">
                                    <h3 class="card-title">Detail Data Jual</h3>
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
                                                <table class="table table-striped table-hover" id="jual_detail">
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
                                                    <tbody id="bodyTable">
                                                        <tr id="tr_1">
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-warning btn-flat" id="btnHapus1" name="btnHapus[]" onclick="hapusBaris(1)" title="Hapus Baris"><i class="fa-solid fa-eraser"></i></button>
                                                            </td>
                                                            <td>
                                                                <select name="kode_barang[]" id="kode_barang1" class="form-control select2_barang_jual" data-placeholder="Cari Barang" onchange="showbarang(this.value, 1)"></select>
                                                                <input type="hidden" name="nama_barang[]" id="nama_barang1" class="form-control" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="kode_satuan[]" id="kode_satuan1" class="form-control" readonly>
                                                                <input type="text" name="satuan_barang[]" id="satuan_barang1" class="form-control" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="date" name="tgl_expire[]" id="tgl_expire1" class="form-control" value="<?= date('Y-m-d', strtotime('+2 Year')) ?>" min="<?= date('Y-m-d', strtotime('+2 Year')) ?>" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="qty_barang[]" id="qty_barang1" class="form-control text-right" onchange="totalline(1)" value="1" min="1">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="harga_barang[]" id="harga_barang1" class="form-control text-right" readonly value="0">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="discpr_barang[]" id="discpr_barang1" class="form-control text-right" onchange="total_discpr(1)" value="0">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="discrp_barang[]" id="discrp_barang1" class="form-control text-right" onchange="totalline(1)" value="0">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="total_barang[]" id="total_barang1" class="form-control text-right" readonly value="0">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8" style="margin-bottom: 5px;">
                                            <button type="button" class="btn btn-success btn-flat" id="btnTambah" onclick="tambah()" title="Tambah Baris"><i class="fa-solid fa-plus"></i></button>
                                            <button type="button" class="btn btn-danger btn-flat" id="btnHapusSemua" onclick="hapusSemua()" title="Hapus Semua Baris"><i class="fa-regular fa-trash-can"></i></button>
                                            <button type="button" class="btn btn-primary btn-flat float-right" id="btnSimpan" onclick="simpan()" title="Simpan Data PO">Simpan <i class="fa-solid fa-save"></i></button>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card border-danger">
                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-3">
                                                            <label>Subtotal</label>
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
        initailizeSelect2_pembeli();
        initailizeSelect2_barang_jual(cabang, '');
        $("#c_ppn").hide();
        $("#sup_ppn").hide();
        // $("#btnHapus1").attr("disabled", true);
        // $("#kode_barang1").attr("disabled", true);
        // $("#btnTambah").attr("disabled", true);
        // $("#btnHapusSemua").attr("disabled", true);
        $("#btnSimpan").attr("disabled", true);
    });

    function get_barang(gudang) {
        var cabang = '<?= $cabang; ?>';
        initailizeSelect2_barang_jual(cabang, gudang);
        $("#btnHapus1").attr("disabled", false);
        $("#kode_barang1").attr("disabled", false);
        $("#btnTambah").attr("disabled", false);
        $("#btnHapusSemua").attr("disabled", false);
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

    function pembeli(kode) {
        $.ajax({
            url: "<?= site_url('Penjualan_barang/get_pembeli/'); ?>" + kode,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                if (data.status == 0) {
                    $("#kode_pembeli").empty();
                    $("#alamat").val("");
                    Swal.fire({
                        icon: 'error',
                        title: 'PEMBELI',
                        text: 'Tidak tidak ditemukan!',
                    });
                } else {
                    $("#alamat").val(data.alamat);
                }
            }
        })
    }

    function showbarang(kode, id) {
        var gudang = $("#kode_gudang").val();
        $.ajax({
            url: "<?= site_url('Penjualan_barang/get_barang/'); ?>" + kode + "?gudang=" + gudang,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                $("#nama_barang" + id).val(data.nama_barang);
                $("#tgl_expire" + id).val(data.tgl_expire);
                $("#kode_satuan" + id).val(data.kode_satuan);
                $("#satuan_barang" + id).val(data.nama_satuan);
                $("#harga_barang" + id).val(formatRupiah(data.harga_jual));
                totalline(id);
            }
        });
    }

    var idrow = 2;

    function tambah() {
        var table = $("#jual_detail");
        table.append(`<tr id="tr_${idrow}">
            <td class="text-center">
                <button type="button" class="btn btn-warning btn-flat" id="btnHapus${idrow}" name="btnHapus[]" onclick="hapusBaris(${idrow})" title="Hapus Baris"><i class="fa-solid fa-eraser"></i></button>
            </td>
            <td>
                <select name="kode_barang[]" id="kode_barang${idrow}" class="form-control select2_barang_jual" data-placeholder="Cari Barang" onchange="showbarang(this.value, ${idrow})"></select>
                <input type="hidden" name="nama_barang[]" id="nama_barang${idrow}" class="form-control" readonly>
            </td>
            <td>
                <input type="hidden" name="kode_satuan[]" id="kode_satuan${idrow}" class="form-control" readonly>
                <input type="text" name="satuan_barang[]" id="satuan_barang${idrow}" class="form-control" readonly>
            </td>
            <td>
                <input type="date" name="tgl_expire[]" id="tgl_expire${idrow}" class="form-control" value="<?= date('Y-m-d', strtotime('+2 Year')) ?>" min="<?= date('Y-m-d', strtotime('+2 Year')) ?>" readonly>
            </td>
            <td>
                <input type="text" name="qty_barang[]" id="qty_barang${idrow}" class="form-control text-right" onchange="totalline(${idrow})" value="1" min="1">
            </td>
            <td>
                <input type="text" name="harga_barang[]" id="harga_barang${idrow}" class="form-control text-right" readonly value="0">
            </td>
            <td>
                <input type="text" name="discpr_barang[]" id="discpr_barang${idrow}" class="form-control text-right" onchange="total_discpr(${idrow})" value="0">
            </td>
            <td>
                <input type="text" name="discrp_barang[]" id="discrp_barang${idrow}" class="form-control text-right" onchange="totalline(${idrow})" value="0">
            </td>
            <td>
                <input type="text" name="total_barang[]" id="total_barang${idrow}" class="form-control text-right" readonly value="0">
            </td>
        </tr>`);
        var cabang = '<?= $cabang; ?>';
        var gudang = $("#kode_gudang").val()
        initailizeSelect2_supplier(cabang);
        initailizeSelect2_gudang(cabang);
        initailizeSelect2_ppn();
        initailizeSelect2_pembeli();
        initailizeSelect2_barang_jual(cabang, gudang);
        idrow++;
    }

    function hapusBaris(param) {
        $("#tr_" + param).remove();
        total();
    }

    function hapusSemua() {
        $("#bodyTable").empty();
        tambah();
        total();
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
        $("#discpr_barang" + id).val(formatRupiah(0));
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
        var table = document.getElementById("jual_detail");
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

        if (total_semua < 1) {
            $("#btnSimpan").attr("disabled", true);
        } else {
            $("#btnSimpan").attr("disabled", false);
        }
    }
</script>

<script>
    function simpan() {
        $("#btnSimpan").attr("disabled", true);
        var gudang = $("#kode_gudang").val();
        if (gudang == "" || gudang == null) {
            $("#btnSimpan").attr("disabled", false);
            Swal.fire({
                icon: 'error',
                title: 'GUDANG',
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
                $("#btnSimpan").attr("disabled", false);
                Swal.fire({
                    icon: 'error',
                    title: 'PPN',
                    text: 'Tidak boleh kosong!',
                });
                return;
            }
        }
        var pembeli = $("#kode_pembeli").val();
        if (pembeli == "" || pembeli == null) {
            $("#btnSimpan").attr("disabled", false);
            Swal.fire({
                icon: 'error',
                title: 'PEMBELI',
                text: 'Tidak boleh kosong!',
            });
            return;
        }
        $.ajax({
            url: "<?= site_url('Penjualan_barang/simpan/1') ?>",
            type: "POST",
            data: ($('#form-jual').serialize()),
            dataType: "JSON",
            success: function(data) {
                $("#btnSimpan").attr("disabled", false);
                if (data.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        html: '<span class="text-success h4 font-weight-bold">TAMBAH DATA JUAL</span><br><b>' + (data.invoice).toUpperCase() + '</b><br><br>Berhasil ditambahkan!',
                    }).then((result) => {
                        location.href = "<?= site_url('Penjualan_barang/jual'); ?>";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        html: '<span class="text-danger h4 font-weight-bold">TAMBAH DATA JUAL</span><br><br>Gagal ditambahkan!',
                    });
                }
            }
        })
    }
</script>