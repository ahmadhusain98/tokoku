<section class="content">
  <form action="#" id="form-pesan" method="post">
    <div class="container-fluid">
      <div class="row" style="height: 100%;">
        <div class="col-sm-3">
          <div class="card shadow" style="height: 100%;">
            <div class="card-header">
              <div>
                <div class="input-group shadow">
                  <input type="text" name="cari_teman" id="cari_teman" class="form-control flat" placeholder="Cari Teman..." style="border-radius: 0px;" autofocus onkeyup="cari_temanku(this.value)">
                  <button class="btn btn-outline-secondary" type="button" style="border-radius: 0px;" title="Cari"><i class='fa-solid fa-magnifying-glass'></i></button>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div id="body-card">
                <div class="row">
                  <?php
                  $no = 1;
                  foreach ($daftar->result() as $d) :
                    if ($d->on_off == 1) {
                      $on_off = 'border-success';
                      $status_color = 'green';
                      $on_off2 = '<i class="fa-solid fa-circle text-success"></i>';
                      $on_off3 = "Online";
                    } else {
                      $on_off = '';
                      $status_color = 'black';
                      $on_off2 = '<i class="fa-solid fa-circle text-dark"></i>';
                      $on_off3 = "Offline";
                    }
                  ?>
                    <div class="col-sm-12">
                      <div class="card shadow flat" style="border: 1px solid <?= $status_color; ?>;" title="<?= $on_off3; ?>" onclick="pilih_target('<?= $d->username; ?>')">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-sm-3">
                              <img id="preview_img" style="width: 50px;" class="img-fluid img-circle <?= $on_off; ?>" src="<?= base_url('assets/user/') . $d->gambar; ?>" alt="User profile picture">
                            </div>
                            <div class="col-sm-9">
                              <div class="row">
                                <div class="col-sm-12">
                                  <span style="font-size: 12px;">
                                    <?php
                                    if ($d->nama == "") {
                                      echo "Tanpa Nama";
                                    } else {
                                      echo strtoupper($d->nama);
                                    }
                                    ?>
                                  </span>
                                  <input type="hidden" name="target" id="target<?= $no; ?>" value="<?= $d->username; ?>">
                                  <input type="hidden" name="ke" id="ke<?= $no; ?>" value="<?= $no; ?>">
                                  <sup class="float-right">
                                    <span style="font-size: 8px; color:  <?= $status_color; ?>"><?= $d->username; ?></span>&nbsp;&nbsp;
                                    <span style="font-size: 10px;"></span><?= $on_off2; ?>
                                  </sup>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php $no++;
                  endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="card shadow" style="height: 100%;">
            <div class="card-header">
              <div id="chat-dengan">
                <div class="row">
                  <div id="profile_target">
                    <div class="col-sm-12">
                      <div class="h3">Profile Tujuan</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div id="isi_pesan">
                <div class="card" style="border-radius: 0px;">
                  <div class="card-body">
                    <div class="h4 text-secondary">Isi Pesan...</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col-sm-11">
                  <textarea name="pesannya" id="pesannya" class="form-control"></textarea>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-success btn-flat" title="Kirim">Kirim</button>
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
  function cari_temanku(par) {
    var params = par.toLowerCase();
    if (params != '' || params != null || params != 'null') {
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("body-card").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "<?= base_url(); ?>Peoples/daftar_teman/" + params, true);
      xhttp.send();
    }
  }

  function pilih_target(params) {
    if (params != '' || params != null || params != 'null') {
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("profile_target").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "<?= base_url(); ?>Peoples/profile_target/" + params, true);
      xhttp.send();
    }
  }
</script>