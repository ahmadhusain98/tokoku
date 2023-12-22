<section class="content">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6" style="margin-bottom: 5px;">
                    <div class="card-title">
                        <div class="h3"><?= $judul; ?></div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-4" style="margin-bottom: 5px;">
                            <input type="date" name="dari" id="dari" title="Dari" value="<?= date('Y-m-d'); ?>" max="<?= date('Y-m-d'); ?>" class="form-control flat" onchange="cek_dari(this.value)">
                        </div>
                        <div class="col-sm-4" style="margin-bottom: 5px;">
                            <input type="date" name="sampai" id="sampai" title="Sampai" value="<?= date('Y-m-d'); ?>" class="form-control flat" onchange="cek_sampai(this.value)">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" style="width: 100%;" class="btn btn-danger btn-flat" title="Filter" onclick="filterdata_jual()"><i class="fa-solid fa-filter"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <a type="button" href="<?= site_url('Penjualan_barang/jual_entri'); ?>" title="Tambah" class="btn btn-flat btn-success float-right"><i class="fa-solid fa-plus"></i></a>
                        <br>
                        <br>
                        <table id="example1-jual" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th>Invoice</th>
                                    <th>Pembeli</th>
                                    <th>Penjual</th>
                                    <th>Gudang</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th width="13%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function cek_dari(dari) {
        var sampai = $("#sampai").val();
        if (dari > sampai) {
            Swal.fire({
                icon: 'error',
                title: 'FILTER DARI',
                text: 'Tidak boleh melebihi dari Tgl Sampai!',
            });
            $("#dari").val(sampai).change();
            return;
        }
    }

    function cek_sampai(sampai) {
        var dari = $("#dari").val();
        if (sampai < dari) {
            Swal.fire({
                icon: 'error',
                title: 'FILTER SAMPAI',
                text: 'Tidak boleh kurang dari Tgl Dari!',
            });
            $("#sampai").val(dari).change();
            return;
        }
    }

    function filterdata_jual() {
        var tgl1 = document.getElementById("dari").value;
        var tgl2 = document.getElementById("sampai").value;
        var id = 2;
        var str = id + '~' + tgl1 + '~' + tgl2;
        table_jual.ajax.url("<?= base_url('Penjualan_barang/jual_list/') ?>" + str).load();
    }

    function hapus(id, invoice) {
        Swal.fire({
            html: '<span class="text-danger h4 font-weight-bold">HAPUS DATA JUAL</span><br><b>' + invoice.toUpperCase() + '</b><br><br>Ingin dihapus?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus Jual',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('Penjualan_barang/hapus_jual/'); ?>" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status == 1) {
                            Swal.fire({
                                icon: 'success',
                                html: '<span class="text-success h4 font-weight-bold">HAPUS DATA JUAL</span><br><b>' + invoice.toUpperCase() + '</b><br><br>Berhasil dihapus!',
                            }).then((result) => {
                                location.href = "<?= site_url('Penjualan_barang/jual'); ?>";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                html: '<span class="text-danger h4 font-weight-bold">HAPUS DATA JUAL</span><br><b>' + invoice.toUpperCase() + '</b><br><br>Gagal dihapus!',
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