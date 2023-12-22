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
          <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
              <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="pt-2 px-3">
                  <h3 class="card-title">PENGATURAN AKTIFASI AKUN</h3>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Akun Aktif</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Akun Belum Aktif <?php if ($jumba > 0) { ?><sup class="badge bg-danger"><?= $jumba; ?></sup><?php } ?></a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr class="text-center">
                          <th>Status</th>
                          <th>Username</th>
                          <th>Nama</th>
                          <th>Nomor Hp</th>
                          <th>Alamat</th>
                          <th>Tingkatan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1;
                        foreach ($akun_aktif as $aa) : ?>
                          <tr>
                            <td>
                              <?php if ($aa->on_off == 1) : ?>
                                <span class="badge bg-success">Online</span>
                              <?php else : ?>
                                <span class="badge bg-dark">Offline</span>
                              <?php endif; ?>
                            </td>
                            <td><?= $aa->username; ?></td>
                            <td><?= $aa->nama; ?></td>
                            <td><?= $aa->nohp; ?></td>
                            <td><?= $aa->alamat; ?></td>
                            <td>
                              <?php if ($aa->id_role == 1) : ?>
                                <span class="badge bg-danger"><?= $aa->tingkatan; ?></span>
                              <?php else : ?>
                                <span class="badge bg-primary"><?= $aa->tingkatan; ?></span>
                              <?php endif; ?>
                            </td>
                            <td class="text-center">
                              <?php if ($aa->on_off < 1) : ?>
                                <span type="button" class="badge" title="Non-aktifkan" onclick="nonaktif('<?= $aa->username; ?>')">
                                  <input type="hidden" name="t_aktif" id="t_aktif">
                                  <i class="fa-solid fa-toggle-on fa-2x text-success"></i>
                                </span>
                              <?php else : ?>
                                <span type="button" class="badge" title="Di kunci" onclick="info('<?= $aa->username; ?>')">
                                  <input type="hidden" name="t_aktif" id="t_aktif">
                                  <i class="fa-solid fa-toggle-on fa-2x text-dark"></i>
                                </span>
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php $no++;
                        endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                  <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-striped">
                      <thead>
                        <tr class="text-center">
                          <th>Status</th>
                          <th>Username</th>
                          <th>Nama</th>
                          <th>Nomor Hp</th>
                          <th>Alamat</th>
                          <th>Tingkatan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1;
                        foreach ($akun_baktif as $ab) : ?>
                          <tr>
                            <td>
                              <?php if ($ab->on_off == 1) : ?>
                                <span class="badge bg-success">Online</span>
                              <?php else : ?>
                                <span class="badge bg-dark">Offline</span>
                              <?php endif; ?>
                            </td>
                            <td><?= $ab->username; ?></td>
                            <td><?= $ab->nama; ?></td>
                            <td><?= $ab->nohp; ?></td>
                            <td><?= $ab->alamat; ?></td>
                            <td>
                              <?php if ($ab->id_role == 1) : ?>
                                <span class="badge bg-danger"><?= $ab->tingkatan; ?></span>
                              <?php else : ?>
                                <span class="badge bg-primary"><?= $ab->tingkatan; ?></span>
                              <?php endif; ?>
                            </td>
                            <td class="text-center">
                              <?php if ($ab->on_off < 1) : ?>
                                <span type="button" class="badge" title="Non-aktifkan" onclick="aktif('<?= $ab->username; ?>')">
                                  <input type="hidden" name="t_aktif" id="t_aktif">
                                  <i class="fa-solid fa-toggle-off fa-2x text-danger"></i>
                                </span>
                              <?php else : ?>
                                <span type="button" class="badge" title="Non-aktifkan" onclick="info('<?= $ab->username; ?>')">
                                  <input type="hidden" name="t_aktif" id="t_aktif">
                                  <i class="fa-solid fa-toggle-off fa-2x text-dark"></i>
                                </span>
                              <?php endif; ?>
                            </td>
                          </tr>
                        <?php $no++;
                        endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function nonaktif(username) {
    Swal.fire({
      html: '<span class="text-warning h4 font-weight-bold">AKTIFASI AKUN</span><br><b>' + username.toUpperCase() + '</b><br><br>Yakin ingin menonaktifkan akun ini?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, nonaktifkan',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Privatex/nonaktif/'); ?>" + username,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">AKTIFASI AKUN</span><br><b>' + username.toUpperCase() + '</b><br><br>Berhasil dinonaktifkan',
              }).then((result) => {
                location.href = "<?= site_url('Privatex/akun'); ?>";
              })
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">AKTIFASI AKUN</span><br><b>' + username.toUpperCase() + '</b><br><br>Gagal dinonaktifkan',
                text: 'Gagal dinonaktifkan',
              })
            }
          }
        });
      }
    })
  }

  function aktif(username) {
    Swal.fire({
      html: '<span class="text-warning h4 font-weight-bold">AKTIFASI AKUN</span><br><b>' + username.toUpperCase() + '</b><br><br>Yakin ingin mengaktikan akun ini?',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, aktifkan',
      cancelButtonText: 'Tidak'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "<?= site_url('Privatex/aktif/'); ?>" + username,
          type: "POST",
          dataType: "JSON",
          success: function(data) {
            if (data.status == 1) {
              Swal.fire({
                icon: 'success',
                html: '<span class="text-success h4 font-weight-bold">AKTIFASI AKUN</span><br><b>' + username.toUpperCase() + '</b><br><br>Berhasil diaktifkan',
              }).then((result) => {
                location.href = "<?= site_url('Privatex/akun'); ?>";
              })
            } else {
              Swal.fire({
                icon: 'error',
                html: '<span class="text-danger h4 font-weight-bold">AKTIFASI AKUN</span><br><b>' + username.toUpperCase() + '</b><br><br>Gagal diaktifkan',
              })
            }
          }
        });
      }
    })
  }

  function info(param) {
    Swal.fire({
      icon: 'warning',
      html: '<span class="text-primary h4 font-weight-bold">AKTIFASI AKUN</span><br><b>' + param.toUpperCase() + '</b><br><br>Sedang dalam kondisi online!',
    })
  }
</script>