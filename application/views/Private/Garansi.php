section class="content">
<form method="POST" id="form-garansi">
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
                        <div class="row">
                            <div class="col-sm-7"></div>
                            <div class="col-sm-5">
                                <div class="row">
                                    <div class="col-sm-4 mb-2">
                                        <input type="hidden" name="id" id="id" value="0">
                                        <select name="kode_barang" id="kode_barang" class="form-control select2_barang" data-placeholder="Cari Barang"></select>
                                    </div>
                                    <div class="col-sm-4 mb-2">
                                        <input type="date" name="masa_garansi" id="masa_garansi" class="form-control" value="<?= date('Y-m-d', strtotime('+1 Year')) ?>">
                                    </div>
                                    <div class="col-sm-4 text-right mb-2">
                                        <button type="button" style="border-radius: 0px;" class="btn btn-primary" title="Proses" onclick="tambah()"><i class="fa-solid fa-bars-progress"></i></button>
                                        <button type="button" style="border-radius: 0px;" class="btn btn-secondary" title="Reset" onclick="reset_()"><i class="fa-solid fa-mattress-pillow"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Satuan</th>
                                    <th>Masa Garansi Hingga</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($garansi as $g) : ?>
                                    <tr>
                                        <td class="text-right"><?= $no++; ?></td>
                                        <td><?= $g->kode_barang; ?></td>
                                        <td><?= $g->nama_barang; ?></td>
                                        <td><?= $g->nama_satuan; ?></td>
                                        <td class="text-center"><?= date('d-m-Y', strtotime($g->masa_garansi)); ?></td>
                                        <td class="text-center">
                                            <button type="button" style="margin-bottom: 5px;" class="btn btn-sm btn-flat btn-warning" title="Ubah Satuan" onclick="ubah_satuan('<?= $g->id; ?>', '<?= $g->kode_barang; ?>', '<?= $g->nama_barang; ?>', '<?= $g->masa_garansi; ?>')"><i class="fa-solid fa-eye-low-vision"></i></button>
                                            <button type="button" style="margin-bottom: 5px;" class="btn btn-flat btn-sm btn-danger" title="Hapus Satuan" onclick="hapus_satuan('<?= $g->id; ?>', '<?= $g->nama_barang; ?>', '<?= $g->masa_garansi; ?>')"><i class="fa-solid fa-ban"></i></button>
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
</form>
</section>

<script>
    $(document).ready(function() {
        var cabang = '<?= $cabang; ?>';
        initailizeSelect2_barang(cabang);
    });

    function reset_() {
        $("#id").val(0);
        $("#kode_barang").empty();
        $("#masa_garansi").val("<?= date('Y-m-d', strtotime('+1 Year')) ?>");
    }

    function tambah() {
        var kode_barang = $("#kode_barang").val();
        if (kode_barang == "" || kode_barang == null) {
            Swal.fire({
                icon: 'error',
                title: 'BARANG',
                text: 'Tidak boleh kosong!',
            });
            return;
        }
        proses()
    }

    function ubah_satuan(id, kode_barang, nama_barang, masa_garansi) {
        $("#id").val(id);
        $("#kode_barang").append(`<option value="${kode_barang}" selected>${nama_barang}</option>`);
        $("#masa_garansi").val(masa_garansi).change();
    }

    function proses() {
        var id = $("#id").val();
        console.log(id)
        var kode_barang = $("#kode_barang").val()
        if (Number(id) > 0) {
            par = 2;
            message = "UPDATE";
        } else {
            par = 1;
            message = "TAMBAH";
        }
        $.ajax({
            url: "<?= site_url('Privatex/simpan_garansi/') ?>" + par,
            type: "POST",
            data: ($('#form-garansi').serialize()),
            dataType: "JSON",
            success: function(data) {
                if (data.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        html: '<span class="text-success h4 font-weight-bold">' + message + ' DATA BARANG GARANSI</span><br><b>' + (kode_barang).toUpperCase() + '</b><br><br>Berhasil diproses!',
                    }).then((result) => {
                        location.href = "<?= site_url('Privatex/garansi'); ?>";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        html: '<span class="text-danger h4 font-weight-bold">' + message + ' DATA BARANG GARANSI</span><br><br>Gagal diproses!',
                    });
                    return;
                }
            }
        })
    }
</script>