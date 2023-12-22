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
                <?php foreach($akses_cabang as $ac) : ?>
                  <tr>
                    <td>
                      <?php if ($ac->on_off == 1) : ?>
                        <span class="badge bg-success">Online</span>
                      <?php else : ?>
                        <span class="badge bg-dark">Offline</span>
                      <?php endif; ?>
                    </td>
                    <td><?= $ac->username; ?></td>
                    <td><?= $ac->nama; ?></td>
                    <td><?= $ac->nohp; ?></td>
                    <td><?= $ac->alamat; ?></td>
                    <td><?= $ac->tingkatan; ?></td>
                    <td class="text-center">
                      <a href="<?= site_url('Privatex/akses_cabang/').$ac->id_user; ?>" type="button" class="btn btn-sm btn-flat btn-danger" title="Ubah Akses Cabang" style="width: 100%;"><i class="fa-solid fa-eye-low-vision"></i></a>
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