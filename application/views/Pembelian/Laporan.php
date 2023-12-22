<section class="content">
    <form method="POST" id="formLaporanBeli">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="h3"><?= $judul; ?></div>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label>Jenis Laporan</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select name="kode_laporan" id="kode_laporan" class="form-control select2_all" data-placeholder="Pilih Laporan...">
                                            <option value="">Pilih Laporan...</option>
                                            <optgroup label="Pre Order (PO)">
                                                <option value="1">1) Laporan PO</option>
                                                <option value="2">2) Laporan PO Detail</option>
                                            </optgroup>
                                            <optgroup label="Penerimaan Barang (PB)">
                                                <option value="3">3) Laporan Penerimaan</option>
                                                <option value="4">4) Laporan Penerimaan Detail</option>
                                            </optgroup>
                                            <optgroup label="Retur Penerimaan Barang (RPB)">
                                                <option value="5">5) Laporan Retur Penerimaan</option>
                                                <option value="6">6) Laporan Retur Penerimaan Detail</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label>Periode</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6" style="gap: 5px;">
                                                <input type="date" name="dari" id="dari" class="form-control" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>">
                                            </div>
                                            <div class="col-sm-6" style="gap: 5px;">
                                                <input type="date" name="sampai" id="sampai" class="form-control" value="<?= date('Y-m-d') ?>" onchange="cekperiode(this.value)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <label>Supplier</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select name="kode_supplier" id="kode_supplier" class="form-control select2_supplier" data-placeholder="Supplier" style="width: 100%;"></select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Gudang</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <select name="kode_gudang" id="kode_gudang" class="form-control select2_gudang" data-placeholder="Gudang" style="width: 100%;"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-4" style="gap: 5px;">
                                        <button type="button" style="width: 100%;" class="btn btn-danger" onclick="_cetak(1)">Cetak PDF <i class="fa fa-file-pdf"></i></button>
                                    </div>
                                    <div class="col-sm-4" style="gap: 5px;">
                                        <button type="button" style="width: 100%;" class="btn btn-primary" onclick="_cetak(2)">Export Excel <i class="fa fa-file-excel"></i></button>
                                    </div>
                                    <div class="col-sm-4" style="gap: 5px;">
                                        <button type="button" style="width: 100%;" class="btn btn-secondary" onclick="resete()">Reset <i class="fa fa-undo"></i></button>
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
    });

    function cekperiode(param) {
        var dari = $("#dari").val();
        if (param < dari) {
            $("#sampai").val(dari);
            Swal.fire({
                icon: 'error',
                title: 'PERIODE SAMPAI',
                text: 'Tidak boleh kurang dari periode dari!',
            });
            return;
        }
    }

    function resete() {
        $("#kode_laporan").val("").change();
        $("#dari").val("<?= date('Y-m-d') ?>");
        $("#sampai").val("<?= date('Y-m-d') ?>");
        $("#kode_supplier").val("").change();
        $("#kode_gudang").val("").change();
    }

    function _cetak(par) {
        var laporan = $("#kode_laporan").val();
        var kode_supplier = $("#kode_supplier").val();
        var kode_gudang = $("#kode_gudang").val();
        var dari = $("#dari").val();
        var sampai = $("#sampai").val();
        if (laporan == "" || laporan == null) {
            Swal.fire({
                icon: 'error',
                title: 'JENIS LAPORAN',
                text: 'Tidak boleh kosong!',
            });
            return;
        }
        var baseUrl = "<?= site_url() ?>";
        var param = "?laporan=" + laporan + "&kode_supplier=" + kode_supplier + "&kode_gudang=" + kode_gudang + "&dari=" + dari + "&sampai=" + sampai;

        window.open(baseUrl + "Pembelian/laporan_pembelian/" + par + param, "_blank");
    }
</script>