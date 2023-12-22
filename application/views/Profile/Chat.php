<?php
setlocale(LC_ALL, 'id_ID.utf8');
if ($dia->is_active == 1) {
  $status = 'Aktif';
} else {
  $status = '';
}
if ($dia->on_off == 1) {
  $on_off = 'border-success';
} else {
  $on_off = '';
}
?>
<section class="content">
  <form action="#" id="form-chat" method="post">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3">
          <div class="card card-primary card-outline w-100">
            <div class="card-body box-profile">
              <div class="text-center">
                <img id="preview_img" class="profile-user-img img-fluid img-circle <?= $on_off; ?>" src="<?= base_url('assets/user/') . $dia->gambar; ?>" alt="User profile picture">
              </div>
              <h3 class="profile-username text-center"><?= strtoupper($dia->nama); ?></h3>
              <p class="text-muted text-center"><?= $dia->tingkatan; ?></p>
              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Pengikut</b> <a class="float-right">
                    <?php if ($folling > 0) {
                      echo $folling;
                    } else {
                      echo 0;
                    } ?>
                  </a>
                </li>
                <li class="list-group-item">
                  <b>Mengikuti</b> <a class="float-right">
                    <?php if ($followers > 0) {
                      echo $followers;
                    } else {
                      echo 0;
                    } ?>
                  </a>
                </li>
                <li class="list-group-item">
                  <b>Bergabung</b> <a class="float-right"><?= date("d M Y", strtotime($dia->is_create)); ?></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="card card-danger card-outline w-100">
            <div class="card-header">
              <h3 class="card-title">
                <?php if ($dia->on_off == 1) {
                  $cekborder = "style='border: 3px solid green; width: 50px;'";
                } else {
                  $cekborder = "style='border: 3px solid black; width: 50px;'";
                } ?>
                <table border="0">
                  <tr>
                    <td rowspan="2">
                      <img src="<?= base_url('assets/user/') . $dia->gambar; ?>" alt="user-avatar" class="rounded img-fluid" <?= $cekborder; ?>>
                    </td>
                    <td>
                      <span style="margin-left: 10px;"><?= strtoupper($dia->nama . " (" . $dia->username . ")"); ?></span>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-right">
                      <span style="font-size: 9px;">
                        <?php if ($dia->on_off == 1) {
                          echo "Online";
                        } else {
                          echo "Offline";
                        } ?>
                      </span>
                    </td>
                  </tr>
                </table>
              </h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body box-profile">
              <div id='isi_pesan' style="height: 300px; overflow-y: scroll;"></div>
            </div>
            <div class=" card-footer">
              <div class="input-group">
                <input type="hidden" name="id_kepada" id="id_kepada" value="<?= $dia->id_user; ?>">
                <input type="hidden" name="kepada" id="kepada" value="<?= $dia->username; ?>">
                <input type="text" name="message" placeholder="Type Message ..." class="form-control" id="message">
                <span class="input-group-append">
                  <button type="button" class="btn btn-success" title="Kirim" onclick="kirim()"><i class="fa-regular fa-paper-plane"></i></button>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>

<script>
  var id_tujuan = "<?= $dia->id_user; ?>";

  $(document).ready(function() {
    isiPesan();
    // setInterval(isiPesan, 500);
    // setInterval(function() {
    //   isiPesan();
    // }, 5000);
  });


  // isiPesan();

  function isiPesan() {
    var params = id_tujuan;
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: "<?= site_url('Chat/header_pesan/'); ?>" + params,
      success: function(data) {
        var dia = data.dia;
        var saya = data.saya;
        var userid = data.userid;
        var dataHandler = $("#isi_pesan");
        dataHandler.html("");
        $.ajax({
          type: "GET",
          data: "",
          url: "<?= site_url('Chat/isi_pesan/'); ?>" + params,
          success: function(hasil) {
            var objResult = JSON.parse(hasil);
            $.each(objResult, function(key, val) {
              var barisBaru = $("<div class='p-2'>");
              if (userid == val.ke) {
                barisBaru.html("<div class='direct-chat-msg'><div class='direct-chat-infos clearfix'><span class='direct-chat-timestamp'>" + val.tgl + " [" + val.jam + "]</span></div><img class='direct-chat-img' src='<?= base_url('assets/user/'); ?>" + dia + "' alt='user-avatar' class='rounded img-fluid'><div class='direct-chat-text'>" + val.pesan + "</div></div>");
              } else {
                barisBaru.html("<div class='direct-chat-msg right'><div class='direct-chat-infos clearfix'><span class='direct-chat-timestamp'>" + val.tgl + " [" + val.jam + "]</span></div><img class='direct-chat-img' src='<?= base_url('assets/user/'); ?>" + saya + "' alt='user-avatar' class='rounded img-fluid'><div class='direct-chat-text'>" + val.pesan + "</div></div>");
              }
              dataHandler.append(barisBaru);
            });
            var element = document.getElementById("isi_pesan");
            element.scrollTop = element.scrollHeight;
          }
        });
      }
    });
  }

  function kirim() {
    var id = $("#id_kepada").val();
    var tujuan = $("#kepada").val();
    var pesan = $("#message").val();
    param = "?tujuan=" + tujuan + "&pesan=" + pesan;
    $.ajax({
      url: "<?= site_url('Chat/kirim') ?>" + param,
      // data: $('#form-chat').serialize(),
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        if (data.status == 1) {
          location.href = "<?= site_url('Profile/chat/'); ?>" + id;
          // $("#message").val('');
        }
      }
    });
  }
</script>