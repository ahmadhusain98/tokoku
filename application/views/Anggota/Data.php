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
          <div class="col-12">
            <div class="table-responsive">
              <a href="<?= site_url('Master/tambah_anggota'); ?>" type="button" title="Tambah Anggota" class="btn btn-flat btn-success float-right"><i class="fa-solid fa-plus"></i></a>
              <br>
              <br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr class="text-center">
                    <th>No</th>
                    <th>Profile</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Tingkatan</th>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($anggota as $a) : ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td class="text-center">
                        <img src="<?= base_url('assets/user/') . $a->gambar; ?>" style="width: 50px; height: 50px; border-radius: 25%;">
                      </td>
                      <td><?= $a->username; ?></td>
                      <td>
                        <?php if ($a->is_active == 1) : ?>
                          <span class="badge bg-success">Aktif</span>
                        <?php else : ?>
                          <span class="badge bg-dark">Non-aktif</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($a->id_role == 1) { ?>
                          <span class="badge bg-danger"><?= $a->tingkatan; ?></span>
                        <?php } else if ($a->id_role == 2) { ?>
                          <span class="badge bg-success"><?= $a->tingkatan; ?></span>
                        <?php } else { ?>
                          <span class="badge bg-primary"><?= $a->tingkatan; ?></span>
                        <?php } ?>
                      </td>
                      <td><?= $a->nama; ?></td>
                      <td><?= $a->nohp; ?></td>
                      <td><?= $a->alamat; ?></td>
                      <td class="text-center">
                        <a href="<?= site_url('Master/edit_anggota/') . $a->id_user; ?>" type="button" class="btn btn-sm btn-flat btn-warning" title="Ubah Member"><i class="fa-solid fa-eye-low-vision"></i></a>
                        <?php if ($a->on_off == 0) : ?>
                          <button type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus Member" onclick="hapus('<?= $a->id_user; ?>', '<?= $a->nama; ?>')"><i class="fa-solid fa-user-slash"></i></button>
                        <?php else : ?>
                          <button type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus Member" disabled><i class="fa-solid fa-user-slash"></i></button>
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
  </form>
</section>

<script>
  // hapus
  function hapus(id, nama) {
    Swal.fire({
      html: '<span class="text-danger h4 font-weight-bold">HAPUS ANGGOTA</span><br><b>' + nama.toUpperCase() + '</b><br><br>Ingin dihapus?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus anggota',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Master/hapus_anggota/'); ?>" + id,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">HAPUS ANGGOTA</span><br><b>' + nama.toUpperCase() + '</b><br><br>Berhasil dihapus!',
              }).then((result) => {
                location.href = "<?= site_url('Master/anggota'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">HAPUS ANGGOTA</span><br><b>' + nama.toUpperCase() + '</b><br><br>Gagal dihapus!',
              });
            }
          }
        });
      }
    });
  }
</script>