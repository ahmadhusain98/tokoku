<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Profile extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
  }

  public function index()
  {
    $now = date("Y-m-d");
    $userid = $this->session->userdata("username");
    $data_user = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $data = [
      "judul"     => "Data Diri",
      "user"      => $data_user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "in_out"    => $this->db->query("SELECT * FROM activity_log WHERE kode = '$data_user->username'")->row(),
      "aktifitas" => $this->db->query("SELECT * FROM activity_user WHERE username = '$data_user->username' AND waktu LIKE '%$now%' ORDER BY id_activity DESC")->result(),
      "jum_aktif" => $this->db->query("SELECT * FROM activity_user WHERE username = '$userid' AND waktu LIKE '%$now%'")->num_rows(),
      "followers" => $this->db->query("SELECT * FROM follow WHERE id_user_dari = '$data_user->id_user'")->num_rows(),
      "folling"   => $this->db->query("SELECT * FROM follow WHERE id_user_ke = '$data_user->id_user'")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$data_user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Home/Profile', $data);
  }

  public function aktifitas_user($date)
  {
    $userid = $this->session->userdata("username");
    $jum_aktif = $this->db->query("SELECT * FROM activity_user WHERE username = '$userid' AND waktu LIKE '%$date%'")->num_rows();
    $aktifitas = $this->db->query("SELECT * FROM activity_user WHERE username = '$userid' AND waktu LIKE '%$date%' ORDER BY id_activity DESC")->result();
    if ($aktifitas) :
?>
      <br>
      <span class="badge bg-danger float-right shadow">Banyaknya aktifitas : <?= $jum_aktif; ?></span>
      <br>
      <div class="card shadow">
        <div class="card-body">
          <div class="table-responsive">
            <?php foreach ($aktifitas as $au) { ?>
              <table width="100%">
                <tr>
                  <td width="14%" class="text-left"><span class="badge bg-success"><?= date("d m Y", strtotime($au->waktu)); ?></span></td>
                  <td width="20%" class="text-left"><?= $au->menu; ?></td>
                  <td width="46%" class="text-left"><?= $au->kegiatan; ?></td>
                  <td width="20%" class="text-right">Jam : <?= date("H:i", strtotime($au->waktu)); ?></td>
                </tr>
              </table>
              <hr>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php else : ?>
      <br>
      <div class="row">
        <div class="col">
          <span class="badge bg-danger float-right shadow">Banyaknya aktifitas : 0</span>
          <br>
          <div class="card shadow">
            <div class="card-body">
              <span class="text-center">Tidak ada aktifitas</span>
            </div>
          </div>
        </div>
      </div>
    <?php endif;
  }

  public function aktifitas_orang($date)
  {
    $userid = $this->input->get("username");
    $jum_aktif = $this->db->query("SELECT * FROM activity_user WHERE username = '$userid' AND waktu LIKE '%$date%'")->num_rows();
    $aktifitas = $this->db->query("SELECT * FROM activity_user WHERE username = '$userid' AND waktu LIKE '%$date%' ORDER BY id_activity DESC")->result();
    if ($aktifitas) :
    ?>
      <br>
      <span class="badge bg-danger float-right shadow">Banyaknya aktifitas : <?= $jum_aktif; ?></span>
      <br>
      <div class="card shadow">
        <div class="card-body">
          <div class="table-responsive">
            <?php foreach ($aktifitas as $au) { ?>
              <table width="100%">
                <tr>
                  <td width="14%" class="text-left"><span class="badge bg-success"><?= date("d m Y", strtotime($au->waktu)); ?></span></td>
                  <td width="20%" class="text-left"><?= $au->menu; ?></td>
                  <td width="46%" class="text-left"><?= $au->kegiatan; ?></td>
                  <td width="20%" class="text-right">Jam : <?= date("H:i", strtotime($au->waktu)); ?></td>
                </tr>
              </table>
              <hr>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php else : ?>
      <br>
      <div class="row">
        <div class="col">
          <span class="badge bg-danger float-right shadow">Banyaknya aktifitas : 0</span>
          <br>
          <div class="card shadow">
            <div class="card-body">
              <span class="text-center">Tidak ada aktifitas</span>
            </div>
          </div>
        </div>
      </div>
<?php endif;
  }

  public function perbarui()
  {
    $config['upload_path'] = 'assets/user/';
    $config['allowed_types'] = 'jpg|png|jpeg';
    $config['max_size'] = '2048';
    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    $username = $this->input->post("username");
    $nama     = $this->input->post("nama");
    $alamat   = $this->input->post("alamat");
    $nohp     = $this->input->post("nohp");

    if ($_FILES['filefoto']['name']) {
      $this->upload->do_upload('filefoto');
      $gambar = $this->upload->data('file_name');
      $data = [
        'nama' => $nama,
        'alamat' => $alamat,
        'nohp' => $nohp,
        'gambar' => $gambar,
      ];
    } else {
      $data = [
        'nama' => $nama,
        'alamat' => $alamat,
        'nohp' => $nohp,
      ];
    }

    $where = [
      "username" => $username,
    ];
    $statusku = $this->db->update("user", $data, $where);
    echo json_encode(["status" => 1]);
  }

  public function orang($id_user)
  {
    $now        = date("Y-m-d");
    $userid     = $this->session->userdata("username");
    $data_user  = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $orang      = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE u.id_user = '$id_user'")->row();
    $data = [
      "judul"     => "Data Diri",
      "user"      => $data_user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      'orang'     => $orang,
      "followers" => $this->db->query("SELECT * FROM follow WHERE id_user_dari = '$id_user'")->num_rows(),
      "folling"   => $this->db->query("SELECT * FROM follow WHERE id_user_ke = '$id_user'")->num_rows(),
      "in_out"    => $this->db->query("SELECT * FROM activity_log WHERE kode = '$orang->username'")->row(),
      "aktifitas" => $this->db->query("SELECT * FROM activity_user WHERE username = '$orang->username' AND waktu LIKE '%$now%'")->result(),
      "jum_aktif" => $this->db->query("SELECT * FROM activity_user WHERE username = '$orang->username' AND waktu LIKE '%$now%'")->num_rows(),
    ];
    $this->template->load('Template/Home', 'Profile/Orang', $data);
  }

  public function chat($key)
  {
    $userid     = $this->session->userdata("username");
    $data_user  = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $saya       = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $dia        = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE u.id_user = '$key'")->row();
    $chat       = $this->db->query("SELECT * FROM chat WHERE ke = '$dia->username' AND dari = '$userid' OR dari = '$dia->username' AND ke = '$userid'")->result();
    $data = [
      "judul"     => "Data Diri",
      "user"      => $data_user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      'saya'      => $saya,
      'dia'       => $dia,
      'chat'      => $chat,
      'userid'    => $userid,
      "followers" => $this->db->query("SELECT * FROM follow WHERE id_user_dari = '$dia->id_user'")->num_rows(),
      "folling"   => $this->db->query("SELECT * FROM follow WHERE id_user_ke = '$dia->id_user'")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$data_user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Profile/Chat', $data);
  }

  public function ubah_password($pass)
  {
    $username = $this->session->userdata("username");
    $password = md5($pass);
    $cek = $this->db->query("UPDATE user SET password = '$password' WHERE username = '$username'");
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }
}
