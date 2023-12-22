<?php
$data_role = $this->db->get("role");
$jumrole = $data_role->num_rows();
$role = $data_role->result();
?>
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
        <div class="col-sm-12">
          <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th rowspan="2">Status</th>
                  <th rowspan="2">Username</th>
                  <th rowspan="2">Nama</th>
                  <th rowspan="2">Nomor Hp</th>
                  <th rowspan="2">Alamat</th>
                  <th colspan="<?= $jumrole; ?>">Tingkatan</th>
                </tr>
                <tr>
                  <?php foreach ($role as $r) : ?>
                    <th width="5%"><?= $r->tingkatan; ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php $nox = 1;
                foreach ($data_user as $du) : ?>
                  <tr>
                    <td>
                      <?php if ($du->on_off == 1) : ?>
                        <span class="badge bg-success">Online</span>
                      <?php else : ?>
                        <span class="badge bg-dark">Offline</span>
                      <?php endif; ?>
                    </td>
                    <td><?= $du->username; ?></td>
                    <td><?= $du->nama; ?></td>
                    <td><?= $du->nohp; ?></td>
                    <td><?= $du->alamat; ?></td>
                    <?php $no = 1;
                    foreach ($role as $r) : ?>
                      <td class="text-center">
                        <?php if ($r->id_role == $du->id_role) {
                          $cek = "checked";
                        } else {
                          $cek = "";
                        } ?>
                        <input type="checkbox" class="form-control" name="id_rolex[]" id="id_rolex<?= $nox; ?>_<?= $r->id_role; ?>" <?= $cek; ?> onclick="ubah_tingkatan('<?= $nox; ?>', '<?= $no; ?>', '<?= $du->username; ?>', '<?= $du->nama; ?>', '<?= $du->id_role; ?>', '<?= $r->id_role; ?>')">
                        <input type="hidden" name="id_role" id="id_role" value="<?= $du->id_role; ?>">
                      </td>
                    <?php $no++;
                    endforeach; ?>
                  </tr>
                <?php $nox++;
                endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function() {
    initailizeSelect2_role();
  });

  function ubah_tingkatan(atas_bawah, role, username, nama, role_asal, role_tujuan) {
    document.getElementById("id_rolex" + atas_bawah + "_" + role).checked = true;
    document.getElementById("id_rolex" + atas_bawah + "_" + role_asal).checked = false;
    Swal.fire({
      html: '<span class="text-warning h4 font-weight-bold">UBAH TINGKATAN</span><br>Diberikan kepada <b>' + nama.toUpperCase() + '</b>?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, ubah tingkatan',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Privatex/ubah_role/'); ?>" + username + "?role_tujuan=" + role_tujuan + "&role_asal=" + role_asal,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">UBAH TINGKATAN</span><br><b>' + nama.toUpperCase() + '</b><br><br>Berhasil diubah',
              }).then((result) => {
                location.href = "<?= site_url('Privatex/role'); ?>";
              });
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">UBAH TINGKATAN</span><br><b>' + nama.toUpperCase() + '</b><br><br>Gagal diubah',
              });
              document.getElementById("id_rolex" + atas_bawah + "_" + role).checked = true;
              document.getElementById("id_rolex" + atas_bawah + "_" + role_asal).checked = false;
            }
          }
        });
      } else {
        document.getElementById("id_rolex" + atas_bawah + "_" + role_asal).checked = true;
        document.getElementById("id_rolex" + atas_bawah + "_" + role).checked = false;
      }
    });
  }
</script>