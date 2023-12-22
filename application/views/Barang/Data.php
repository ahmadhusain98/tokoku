<section class="content">
  <form method="POST" id="form-cabang">
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
            <div class="row mb-2">
              <div class="col-sm-12">
                <select name="groupby" id="groupby" class="select2_all" data-placeholder="Group By Kategori..." style="width: 40%" onchange="get_kategori(this.value)">
                  <option value="">Group By Kategori...</option>
                  <?php foreach ($kategori as $k) : ?>
                    <?php if ($kode_kategori == $k->kode_kategori) {
                      $select = 'selected';
                    } else {
                      $select = '';
                    } ?>
                    <option value="<?= $k->kode_kategori ?>" <?= $select; ?>><?= $k->nama_kategori; ?></option>
                  <?php endforeach; ?>
                </select>
                <a href="<?= site_url('Master/tambah_barang'); ?>" type="button" title="Tambah Anggota" class="btn btn-flat btn-success float-right"><i class="fa-solid fa-plus"></i></a>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped" style="font-size: 14px; width: 100%;">
                    <thead>
                      <tr class="text-center">
                        <th>No</th>
                        <th>Kode</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Beli</th>
                        <th>Jual</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1;
                      foreach ($barang as $b) : ?>
                        <?php $saldo = $this->db->query("SELECT saldo_akhir FROM stok WHERE kode_cabang = '$b->kode_cabang' AND kode_barang = '$b->kode_barang'")->row(); ?>
                        <?php $kategori = $this->db->query("SELECT * FROM kategori WHERE kode_cabang = '$b->kode_cabang' AND kode_kategori = '$b->kode_kategori'")->row(); ?>
                        <tr>
                          <td class="text-right"><?= $no++; ?></td>
                          <td><?= $b->kode_barang; ?></td>
                          <td>
                            <img src="<?= site_url('assets/img/barang/') . $b->gambar; ?>" alt="gambar" style="width: 50px;">
                          </td>
                          <td><?= $b->nama_barang; ?></td>
                          <td><?= $kategori->nama_kategori; ?></td>
                          <td><?= $b->satuan; ?></td>
                          <td>
                            Rp. <span class="text-right"><?= number_format($b->harga_beli); ?></span>
                          </td>
                          <td>
                            Rp. <span class="text-right"><?= number_format($b->harga_jual); ?></span>
                          </td>
                          <td class="text-center" width="10%">
                            <a href="<?= site_url('Master/edit_barang/') . $b->id_barang; ?>" type="button" class="btn btn-sm btn-flat btn-warning" title="Ubah Barang"><i class="fa-solid fa-eye-low-vision"></i></a>
                            <button type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus Barang" onclick="hapus('<?= $b->id_barang; ?>', '<?= $b->nama_barang; ?>')"><i class="fa-solid fa-ban"></i></button>
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
      </div>
    </div>
  </form>
</section>

<script>
  function get_kategori(kategori) {
    location.href = "<?= site_url('Master/barang/?kode_kategori=') ?>" + kategori;
  }
</script>

<script>
  function hapus(id, nama) {
    Swal.fire({
      html: '<span class="text-danger font-weight-bold h4">HAPUS</span><br><b>' + nama.toUpperCase() + "</b><br><br>Yakin ingin menghapus barang ini ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus barang',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Master/hapus_barang/'); ?>" + id,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success font-weight-bold h4">HAPUS BARANG</span><br><b>' + nama.toUpperCase() + "</b><br><br>Berhasil dilakukan",
              }).then((result) => {
                location.href = "<?= site_url('Master/barang'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger font-weight-bold h4">HAPUS BARANG</span><br><b>' + nama.toUpperCase() + "</b><br><br>Gagal dilakukan",
              });
            }
          }
        });
      }
    });
  }
</script>