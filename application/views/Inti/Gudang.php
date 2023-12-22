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
                        <button type="button" onclick="tambah()" title="Tambah Gudang" class="btn btn-flat btn-success float-right"><i class="fa-solid fa-plus"></i></button>
                        <br>
                        <br>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th>Kode Gudang</th>
                                    <th>Nama Gudang</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($gudang as $g) : ?>
                                    <tr>
                                        <td class="text-right"><?= $no++; ?></td>
                                        <td><?= $g->kode_gudang; ?></td>
                                        <td><?= $g->nama_gudang; ?></td>
                                        <td class="text-center">
                                            <button type="button" style="margin-bottom: 5px;" class="btn btn-sm btn-flat btn-warning" title="Ubah Gudang" onclick="ubah_gudang('<?= $g->id_gudang; ?>', '<?= $g->kode_gudang; ?>', '<?= $g->nama_gudang; ?>')"><i class="fa-solid fa-eye-low-vision"></i></button>
                                            <?php if ($this->db->query("SELECT * FROM stok WHERE kode_gudang = '$g->kode_gudang' AND kode_cabang = '" . $this->session->userdata("cabang") . "'")->num_rows() < 1) : ?>
                                                <button type="button" style="margin-bottom: 5px;" class="btn btn-flat btn-sm btn-danger" title="Hapus Gudang" onclick="hapus_gudang('<?= $g->id_gudang; ?>', '<?= $g->nama_gudang; ?>')"><i class="fa-solid fa-ban"></i></button>
                                            <?php else : ?>
                                                <button type="button" style="margin-bottom: 5px;" class="btn btn-flat btn-sm btn-danger" title="Hapus Gudang" disabled><i class="fa-solid fa-ban"></i></button>
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
    <div class="modal-dialog  modal-dialog-centered modal-sm">
        <div class="modal-content" style="border-top: solid 3px red; border-bottom: solid 3px #0069d9;">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Gudang Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="tutup()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="form-modal-tambah">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="kode_gudang" name="kode_gudang" placeholder="AUTO" value="" readonly>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa-solid fa-code-fork"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="nama_gudang" name="nama_gudang" placeholder="Nama Gudang..." onkeyup="ubah_nama(this.value)">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa-regular fa-building"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-flat float-right" id="btnsave" onclick="simpan()">Tambahkan Gudang</button>
                    <button type="button" class="btn btn-warning btn-flat float-right" id="btnupdate" onclick="update()">Ubah Gudang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function tambah() {
        $("#modal_tambah").modal("show");
        $(".modal-title").text("Tambah Gudang Baru");
        $("#btnupdate").hide();
        $("#btnsave").show();
        $("#kode_gudang").val('');
        $("#nama_gudang").val('');
    }

    function ubah_nama(nama) {
        str = nama.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
        $("#nama_gudang").val(str);
    }

    function tutup() {
        $("#modal_tambah").modal("hide");
    }

    function ubah_gudang(id_gudang, kode_gudang, nama_gudang) {
        $("#modal_tambah").modal("show");
        $(".modal-title").text("Ubah Satuan Baru");
        $("#btnsave").hide();
        $("#btnupdate").show();
        $("#kode_gudang").val(kode_gudang);
        $("#nama_gudang").val(nama_gudang);
    }
</script>

<script>
    function simpan() {
        var kode_gudang = $("#kode_gudang").val();
        var nama_gudang = $("#nama_gudang").val();
        if (nama_gudang == '' || nama_gudang == null) {
            $("#modal_tambah").modal("hide");
            Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">TAMBAH GUDANG</span><br><br>Data belum lengkap!',
            }).then((result) => {
                $("#modal_tambah").modal("show");
                $("#btnupdate").hide();
            });
        } else {
            $.ajax({
                url: "<?= site_url('Inti/get_nama_gudang/') ?>" + nama_gudang,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    if (data.status == 1) {
                        $("#nama_gudang").val('');
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                            icon: 'error',
                            html: '<span class="text-danger h4 font-weight-bold">TAMBAH GUDANG</span><br><b>' + nama_gudang.toUpperCase() + '</b><br><br>Sudah digunakan!',
                        }).then((result) => {
                            $("#modal_tambah").modal("show");
                            $(".modal-title").text("Tambah Gudang Baru");
                            $("#btnsave").show();
                            $("#btnupdate").hide();
                            $("#kode_gudang").val(kode_gudang);
                            $("#nama_gudang").val('');
                        });
                        return;
                    } else {
                        $.ajax({
                            url: "<?= site_url('Inti/simpan_gudang') ?>",
                            type: "POST",
                            data: ($('#form-modal-tambah').serialize()),
                            dataType: "JSON",
                            success: function(data) {
                                if (data.status == 1) {
                                    $("#modal_tambah").modal("hide");
                                    Swal.fire({
                                        icon: 'success',
                                        html: '<span class="text-success h4 font-weight-bold">TAMBAH GUDANG</span><br><b>' + nama_gudang.toUpperCase() + '</b><br><br>Berhasil ditambahkan!',
                                    }).then((result) => {
                                        location.href = "<?= site_url('Inti/gudang'); ?>";
                                    });
                                } else {
                                    $("#modal_tambah").modal("hide");
                                    Swal.fire({
                                        icon: 'error',
                                        html: '<span class="text-danger h4 font-weight-bold">TAMBAH GUDANG</span><br><b>' + nama_gudang.toUpperCase() + '</b><br><br>Gagal ditambahkan!',
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
        var kode_gudang = $("#kode_gudang").val();
        var nama_gudang = $("#nama_gudang").val();
        if (nama_gudang == '' || nama_gudang == null) {
            Swal.fire({
                icon: 'error',
                title: 'NAMA',
                text: 'Tidak boleh kosong!',
            });
        } else {
            $.ajax({
                url: "<?= site_url('Inti/get_nama_gudang/') ?>" + nama_gudang,
                type: "POST",
                dataType: "JSON",
                success: function(data) {
                    if (data.status == 1) {
                        $("#nama_gudang").val('');
                        $("#modal_tambah").modal("hide");
                        Swal.fire({
                            icon: 'error',
                            html: '<span class="text-danger h4 font-weight-bold">UBAH GUDANG</span><br><b>' + nama_gudang.toUpperCase() + '</b><br><br>Sudah digunakan!',
                        }).then((result) => {
                            $("#modal_tambah").modal("show");
                            $(".modal-title").text("Ubah Gudang Baru");
                            $("#btnsave").hide();
                            $("#btnupdate").show();
                            $("#kode_gudang").val(kode_gudang);
                            $("#nama_gudang").val('');
                        });
                        return;
                    } else {
                        Swal.fire({
                            html: '<span class="text-warning h4 font-weight-bold">UBAH GUDANG</span><br><b>' + nama_gudang.toUpperCase() + '</b><br><br>Ingin diubah?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, ubah satuan',
                            cancelButtonText: 'Tidak'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (nama_gudang == '' || nama_gudang == null) {
                                    $("#modal_tambah").modal("hide");
                                    Swal.fire({
                                        icon: 'error',
                                        html: '<span class="text-danger h4 font-weight-bold">UBAH GUDANG</span><br><br>Data belum lengkap!',
                                    }).then((result) => {
                                        $("#modal_tambah").modal("show");
                                        $("#btnsave").hide();
                                        $("#btnupdate").show();
                                    });
                                } else {
                                    $.ajax({
                                        url: "<?= site_url('Inti/update_gudang'); ?>",
                                        type: "POST",
                                        data: ($('#form-modal-tambah').serialize()),
                                        dataType: "JSON",
                                        success: function(data) {
                                            if (data.status == 1) {
                                                $("#modal_tambah").modal("hide");
                                                Swal.fire({
                                                    icon: 'success',
                                                    html: '<span class="text-success h4 font-weight-bold">UBAH GUDANG</span><br><b>' + nama_gudang.toUpperCase() + '</b><br><br>Berhasil diubah!',
                                                }).then((result) => {
                                                    location.href = "<?= site_url('Inti/gudang'); ?>";
                                                });
                                            } else {
                                                $("#modal_tambah").modal("hide");
                                                Swal.fire({
                                                    icon: 'error',
                                                    html: '<span class="text-danger h4 font-weight-bold">UBAH GUDANG</span><br><b>' + nama_gudang.toUpperCase() + '</b><br><br>Gagal diubah!',
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

    function hapus_gudang(id_gudang, nama_gudang) {
        Swal.fire({
            html: '<span class="text-danger h4 font-weight-bold">HAPUS GUDANG</span><br><b>' + nama_gudang.toUpperCase() + '</b><br><br>Ingin dihapus?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus satuan',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('Inti/hapus_gudang/'); ?>" + id_gudang,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status == 1) {
                            Swal.fire({
                                icon: 'success',
                                html: '<span class="text-success h4 font-weight-bold">HAPUS GUDANG</span><br><b>' + nama_gudang.toUpperCase() + '</b><br><br>Berhasil dihapus!',
                            }).then((result) => {
                                location.href = "<?= site_url('Inti/gudang'); ?>";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                html: '<span class="text-danger h4 font-weight-bold">HAPUS GUDANG</span><br><b>' + nama_gudang.toUpperCase() + '</b><br><br>Gagal dihapus!',
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