<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peoples extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
    date_default_timezone_set('Asia/Jakarta');
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $menu = $this->db->get_where("menu", ["url" => "Peoples"])->row();
    $cek_akses = $this->db->get_where("akses_menu", ["id_role" => $user->id_role, "id_menu" => $menu->id])->num_rows();
    if ($cek_akses < 1) {
      redirect("Home");
    }
  }

  public function index()
  {
    $userid = $this->session->userdata("username");
    $data_user = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $data = [
      "judul"     => "Dapatkan Teman",
      "user"      => $data_user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "orang"     => $this->db->query("SELECT u.*, r.tingkatan FROM user u JOIN role r ON u.id_role = r.id_role WHERE u.id_user != '$data_user->id_user' AND is_active = 1 AND u.id_user NOT IN (SELECT id_user_ke FROM follow)")->result(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$data_user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Peoples/Orang', $data);
  }

  public function isi($key = '')
  {
    $userid = $this->session->userdata("username");
    $user = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $data_user = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $data = $this->db->query("SELECT u.*, r.tingkatan FROM user u JOIN role r ON u.id_role = r.id_role WHERE u.id_user != '$data_user->id_user' AND is_active = 1 AND (u.username LIKE '%$key%' OR u.nama LIKE '%$key%' OR u.alamat LIKE '%$key%' OR u.nohp LIKE '%$key%' OR r.tingkatan LIKE '%$key%')")->result(); ?>
    <div class="row">
      <?php
      foreach ($data as $d) :
      ?>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
          <div class="card d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
              <?= strtoupper($d->tingkatan); ?>
            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col-7">
                  <h2 class="lead"><b><?= $d->nama; ?></b></h2>
                  <p class="text-muted text-sm"><b>Tentang: </b>
                    <br>
                    <?php
                    $followers = $this->db->query("SELECT * FROM follow WHERE id_user_ke = '$d->id_user'")->num_rows();
                    $following = $this->db->query("SELECT * FROM follow WHERE id_user_dari = '$d->id_user'")->num_rows();
                    echo "Followers : " . $followers . "<br>";
                    echo "Following : " . $following . "<br>";
                    $cabang = $this->db->query("SELECT * FROM cabang WHERE id_cabang IN (SELECT id_cabang FROM akses_cabang WHERE id_user = '$d->id_user')")->result();
                    echo "<br>Cabang : ";
                    foreach ($cabang as $c) :
                      echo $c->nama_cabang . ', ';
                    endforeach;
                    ?>
                  </p>
                  <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Alamat: <?= $d->alamat; ?></li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Kontak: <?= $d->nohp; ?></li>
                  </ul>
                </div>
                <div class="col-5 text-center">
                  <?php if ($d->on_off == 1) {
                    $cekborder = "style='border: 3px solid green;'";
                  } else {
                    $cekborder = "style='border: 3px solid black;'";
                  } ?>
                  <img src="<?= base_url('assets/user/') . $d->gambar; ?>" alt="user-avatar" class="img-circle img-fluid" <?= $cekborder; ?>>
                  <?php if ($d->on_off == 1) {
                    echo "Online";
                  } else {
                    echo "Offline";
                  } ?>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="text-right">
                <a href="<?= site_url('Profile/chat/') . $d->id_user; ?>" type="button" class="btn btn-sm bg-danger btn-flat">
                  Pesan
                </a>
                <?php if ($this->db->query("SELECT * FROM follow WHERE id_user_ke = '$d->id_user' AND id_user_dari = '$user->id_user'")->num_rows() > 0) { ?>
                  <button type="button" class="btn btn-sm bg-dark btn-flat" onclick="unfollow('<?= $d->id_user; ?>', '<?= $d->nama; ?>')">
                    Unfollow
                  </button>
                <?php } else if ($this->db->query("SELECT * FROM follow WHERE id_user_dari = '$d->id_user' AND id_user_ke = '$user->id_user'")->num_rows() > 0) { ?>
                  <button type="button" class="btn btn-sm bg-secondary btn-flat" onclick="follow('<?= $d->id_user; ?>', '<?= $d->nama; ?>')">
                    Follow Back
                  </button>
                <?php } else { ?>
                  <button type="button" class="btn btn-sm bg-teal btn-flat" onclick="follow('<?= $d->id_user; ?>', '<?= $d->nama; ?>')">
                    Follow
                  </button>
                <?php } ?>
                <a href="<?= site_url('Profile/orang/') . $d->id_user; ?>" class="btn btn-sm btn-primary btn-flat" type="button">
                  Profile
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php
      endforeach;
      ?>
    </div>
  <?php
  }

  public function isi_kosong()
  {
    $userid = $this->session->userdata("username");
    $user = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $data_user = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $data = $this->db->query("SELECT u.*, r.tingkatan FROM user u JOIN role r ON u.id_role = r.id_role WHERE u.id_user != '$data_user->id_user' AND is_active = 1")->result(); ?>
    <div class="row">
      <?php
      foreach ($data as $d) :
      ?>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
          <div class="card d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
              <?= strtoupper($d->tingkatan); ?>
            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col-7">
                  <h2 class="lead"><b><?= $d->nama; ?></b></h2>
                  <p class="text-muted text-sm"><b>Tentang: </b>
                    <br>
                    <?php
                    $followers = $this->db->query("SELECT * FROM follow WHERE id_user_ke = '$d->id_user'")->num_rows();
                    $following = $this->db->query("SELECT * FROM follow WHERE id_user_dari = '$d->id_user'")->num_rows();
                    echo "Followers : " . $followers . "<br>";
                    echo "Following : " . $following . "<br>";
                    $cabang = $this->db->query("SELECT * FROM cabang WHERE id_cabang IN (SELECT id_cabang FROM akses_cabang WHERE id_user = '$d->id_user')")->result();
                    echo "<br>Cabang : ";
                    foreach ($cabang as $c) :
                      echo $c->nama_cabang . ', ';
                    endforeach;
                    ?>
                  </p>
                  <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Alamat: <?= $d->alamat; ?></li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Kontak: <?= $d->nohp; ?></li>
                  </ul>
                </div>
                <div class="col-5 text-center">
                  <?php if ($d->on_off == 1) {
                    $cekborder = "style='border: 3px solid green;'";
                  } else {
                    $cekborder = "style='border: 3px solid black;'";
                  } ?>
                  <img src="<?= base_url('assets/user/') . $d->gambar; ?>" alt="user-avatar" class="img-circle img-fluid" <?= $cekborder; ?>>
                  <?php if ($d->on_off == 1) {
                    echo "Online";
                  } else {
                    echo "Offline";
                  } ?>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="text-right">
                <a href="<?= site_url('Profile/chat/') . $d->id_user; ?>" type="button" class="btn btn-sm bg-danger btn-flat">
                  Pesan
                </a>
                <?php if ($this->db->query("SELECT * FROM follow WHERE id_user_ke = '$d->id_user' AND id_user_dari = '$user->id_user'")->num_rows() > 0) { ?>
                  <button type="button" class="btn btn-sm bg-dark btn-flat" onclick="unfollow('<?= $d->id_user; ?>', '<?= $d->nama; ?>')">
                    Unfollow
                  </button>
                <?php } else if ($this->db->query("SELECT * FROM follow WHERE id_user_dari = '$d->id_user' AND id_user_ke = '$user->id_user'")->num_rows() > 0) { ?>
                  <button type="button" class="btn btn-sm bg-secondary btn-flat" onclick="follow('<?= $d->id_user; ?>', '<?= $d->nama; ?>')">
                    Follow Back
                  </button>
                <?php } else { ?>
                  <button type="button" class="btn btn-sm bg-teal btn-flat" onclick="follow('<?= $d->id_user; ?>', '<?= $d->nama; ?>')">
                    Follow
                  </button>
                <?php } ?>
                <a href="<?= site_url('Profile/orang/') . $d->id_user; ?>" class="btn btn-sm btn-primary btn-flat" type="button">
                  Profile
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php
      endforeach;
      ?>
    </div>
  <?php
  }

  public function follow($id_user_ke)
  {
    $userid       = $this->session->userdata("username");
    $data_user    = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $id_user_dari = $data_user->id_user;
    $data = [
      'id_user_dari'  => $id_user_dari,
      'id_user_ke'    => $id_user_ke,
    ];
    $cek = $this->db->insert("follow", $data);
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function unfollow($id_user_ke)
  {
    $userid       = $this->session->userdata("username");
    $data_user    = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $id_user_dari = $data_user->id_user;
    $cek = $this->db->query("DELETE FROM follow WHERE id_user_ke = '$id_user_ke' AND id_user_dari = '$id_user_dari'");
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function teman()
  {
    $userid = $this->session->userdata("username");
    $data_user = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $data = [
      "judul"     => "Daftar Teman",
      "user"      => $data_user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "orang"     => $this->db->query("SELECT u.*, r.tingkatan FROM user u JOIN role r ON u.id_role = r.id_role WHERE u.id_user != '$data_user->id_user' AND is_active = 1 AND u.id_user IN (SELECT id_user_ke FROM follow)")->result(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$data_user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Peoples/Teman', $data);
  }

  public function isi_teman($key = '')
  {
    $userid = $this->session->userdata("username");
    $user = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $data_user = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $data = $this->db->query("SELECT u.*, r.tingkatan FROM user u JOIN role r ON u.id_role = r.id_role WHERE u.id_user != '$data_user->id_user' AND (u.username LIKE '%$key%' OR u.nama LIKE '%$key%' OR u.alamat LIKE '%$key%' OR u.nohp LIKE '%$key%' OR r.tingkatan LIKE '%$key%') AND u.id_user IN (SELECT id_user_ke FROM follow)")->result(); ?>
    <div class="row">
      <?php
      foreach ($data as $d) :
      ?>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
          <div class="card d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
              <?= strtoupper($d->tingkatan); ?>
            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col-7">
                  <h2 class="lead"><b><?= $d->nama; ?></b></h2>
                  <p class="text-muted text-sm"><b>Tentang: </b>
                    <br>
                    <?php
                    $followers = $this->db->query("SELECT * FROM follow WHERE id_user_ke = '$d->id_user'")->num_rows();
                    $following = $this->db->query("SELECT * FROM follow WHERE id_user_dari = '$d->id_user'")->num_rows();
                    echo "Followers : " . $followers . "<br>";
                    echo "Following : " . $following . "<br>";
                    $cabang = $this->db->query("SELECT * FROM cabang WHERE id_cabang IN (SELECT id_cabang FROM akses_cabang WHERE id_user = '$d->id_user')")->result();
                    echo "<br>Cabang : ";
                    foreach ($cabang as $c) :
                      echo $c->nama_cabang . ', ';
                    endforeach;
                    ?>
                  </p>
                  <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Alamat: <?= $d->alamat; ?></li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Kontak: <?= $d->nohp; ?></li>
                  </ul>
                </div>
                <div class="col-5 text-center">
                  <?php if ($d->on_off == 1) {
                    $cekborder = "style='border: 3px solid green;'";
                  } else {
                    $cekborder = "style='border: 3px solid black;'";
                  } ?>
                  <img src="<?= base_url('assets/user/') . $d->gambar; ?>" alt="user-avatar" class="img-circle img-fluid" <?= $cekborder; ?>>
                  <?php if ($d->on_off == 1) {
                    echo "Online";
                  } else {
                    echo "Offline";
                  } ?>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="text-right">
                <a href="<?= site_url('Profile/chat/') . $d->id_user; ?>" type="button" class="btn btn-sm bg-danger btn-flat">
                  Pesan
                </a>
                <?php if ($this->db->query("SELECT * FROM follow WHERE id_user_ke = '$d->id_user' AND id_user_dari = '$user->id_user'")->num_rows() > 0) { ?>
                  <button type="button" class="btn btn-sm bg-dark btn-flat" onclick="unfollow('<?= $d->id_user; ?>', '<?= $d->nama; ?>')">
                    Unfollow
                  </button>
                <?php } else if ($this->db->query("SELECT * FROM follow WHERE id_user_dari = '$d->id_user' AND id_user_ke = '$user->id_user'")->num_rows() > 0) { ?>
                  <button type="button" class="btn btn-sm bg-secondary btn-flat" onclick="follow('<?= $d->id_user; ?>', '<?= $d->nama; ?>')">
                    Follow Back
                  </button>
                <?php } else { ?>
                  <button type="button" class="btn btn-sm bg-teal btn-flat" onclick="follow('<?= $d->id_user; ?>', '<?= $d->nama; ?>')">
                    Follow
                  </button>
                <?php } ?>
                <a href="<?= site_url('Profile/orang/') . $d->id_user; ?>" class="btn btn-sm btn-primary btn-flat" type="button">
                  Profile
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php
      endforeach;
      ?>
    </div>
  <?php
  }

  public function isi_kosong_teman()
  {
    $userid = $this->session->userdata("username");
    $user = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $data_user = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $data = $this->db->query("SELECT u.*, r.tingkatan FROM user u JOIN role r ON u.id_role = r.id_role WHERE u.id_user != '$data_user->id_user' AND u.id_user IN (SELECT id_user_ke FROM follow)")->result(); ?>
    <div class="row">
      <?php
      foreach ($data as $d) :
      ?>
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
          <div class="card d-flex flex-fill">
            <div class="card-header text-muted border-bottom-0">
              <?= strtoupper($d->tingkatan); ?>
            </div>
            <div class="card-body pt-0">
              <div class="row">
                <div class="col-7">
                  <h2 class="lead"><b><?= $d->nama; ?></b></h2>
                  <p class="text-muted text-sm"><b>Tentang: </b>
                    <br>
                    <?php
                    $followers = $this->db->query("SELECT * FROM follow WHERE id_user_ke = '$d->id_user'")->num_rows();
                    $following = $this->db->query("SELECT * FROM follow WHERE id_user_dari = '$d->id_user'")->num_rows();
                    echo "Followers : " . $followers . "<br>";
                    echo "Following : " . $following . "<br>";
                    $cabang = $this->db->query("SELECT * FROM cabang WHERE id_cabang IN (SELECT id_cabang FROM akses_cabang WHERE id_user = '$d->id_user')")->result();
                    echo "<br>Cabang : ";
                    foreach ($cabang as $c) :
                      echo $c->nama_cabang . ', ';
                    endforeach;
                    ?>
                  </p>
                  <ul class="ml-4 mb-0 fa-ul text-muted">
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> Alamat: <?= $d->alamat; ?></li>
                    <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Kontak: <?= $d->nohp; ?></li>
                  </ul>
                </div>
                <div class="col-5 text-center">
                  <?php if ($d->on_off == 1) {
                    $cekborder = "style='border: 3px solid green;'";
                  } else {
                    $cekborder = "style='border: 3px solid black;'";
                  } ?>
                  <img src="<?= base_url('assets/user/') . $d->gambar; ?>" alt="user-avatar" class="img-circle img-fluid" <?= $cekborder; ?>>
                  <?php if ($d->on_off == 1) {
                    echo "Online";
                  } else {
                    echo "Offline";
                  } ?>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <div class="text-right">
                <a href="<?= site_url('Profile/chat/') . $d->id_user; ?>" type="button" class="btn btn-sm bg-danger btn-flat">
                  Pesan
                </a>
                <?php if ($this->db->query("SELECT * FROM follow WHERE id_user_ke = '$d->id_user' AND id_user_dari = '$user->id_user'")->num_rows() > 0) { ?>
                  <button type="button" class="btn btn-sm bg-dark btn-flat" onclick="unfollow('<?= $d->id_user; ?>', '<?= $d->nama; ?>')">
                    Unfollow
                  </button>
                <?php } else if ($this->db->query("SELECT * FROM follow WHERE id_user_dari = '$d->id_user' AND id_user_ke = '$user->id_user'")->num_rows() > 0) { ?>
                  <button type="button" class="btn btn-sm bg-secondary btn-flat" onclick="follow('<?= $d->id_user; ?>', '<?= $d->nama; ?>')">
                    Follow Back
                  </button>
                <?php } else { ?>
                  <button type="button" class="btn btn-sm bg-teal btn-flat" onclick="follow('<?= $d->id_user; ?>', '<?= $d->nama; ?>')">
                    Follow
                  </button>
                <?php } ?>
                <a href="<?= site_url('Profile/orang/') . $d->id_user; ?>" class="btn btn-sm btn-primary btn-flat" type="button">
                  Profile
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php
      endforeach;
      ?>
    </div>
  <?php
  }

  public function pesan()
  {
    $userid     = $this->session->userdata("username");
    $user       = $this->db->get_where("user", ["username" => $userid])->row();
    $daftar     = $this->db->query("SELECT u.* FROM user u JOIN follow f ON u.id_user = f.id_user_ke WHERE f.id_user_dari = '$user->id_user'");
    $data_user  = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $data = [
      "judul"     => "Pesan",
      'user'      => $user,
      "daftar"    => $daftar,
      "user"      => $data_user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "orang"     => $this->db->query("SELECT u.*, r.tingkatan FROM user u JOIN role r ON u.id_role = r.id_role WHERE u.id_user != '$data_user->id_user' AND is_active = 1 AND u.id_user IN (SELECT id_user_ke FROM follow)")->result(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$data_user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Peoples/Pesan', $data);
  }

  public function daftar_teman($key = '')
  {
    $userid     = $this->session->userdata("username");
    $user       = $this->db->get_where("user", ["username" => $userid])->row();
    $daftar     = $this->db->query("SELECT u.* FROM user u JOIN follow f ON u.id_user = f.id_user_ke WHERE f.id_user_dari = '$user->id_user' AND (u.username LIKE '%$key%' OR u.nama LIKE '%$key%' OR u.nohp LIKE '%$key%' OR u.alamat LIKE '%$key%')")->result();
  ?>
    <div class="row">
      <?php
      foreach ($daftar as $d) :
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
          <div class="card shadow flat" style="border: 1px solid <?= $status_color; ?>;" title="<?= $on_off3; ?>">
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
      <?php endforeach; ?>
    </div>
    </div>
  <?php
  }

  public function profile_target($username = '')
  {
    $target = $this->db->get_where("user", ["username" => $username])->row();
  ?>
    <div class="row">
      <div class="col-sm-10">
        <table border="1" style="width: 100%;">
          <tr>
            <td rowspan="2">
              <img src="<?= base_url('assets/user/') . $target->gambar; ?>" alt="user-avatar" class="img-fluid" style="width: 10vh;">
            </td>
            <td style="padding: 10px;">
              <span style="font-size: 12px;">
                <?php
                if ($target->nama == "") {
                  echo "Tanpa Nama";
                } else {
                  echo $target->nama;
                }
                ?>
              </span>
            </td>
          </tr>
          <tr>
            <td style="padding: 10px;">
              <span style="font-size: 8px;"><?= $target->username; ?></span>
            </td>
          </tr>
        </table>
      </div>
      <div class="col-sm-2"></div>
    </div>
<?php
  }
}
