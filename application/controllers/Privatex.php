<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Privatex extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $menu = $this->db->get_where("menu", ["url" => "Privatex"])->row();
    $cek_akses = $this->db->get_where("akses_menu", ["id_role" => $user->id_role, "id_menu" => $menu->id])->num_rows();
    if ($cek_akses < 1) {
      redirect("Home");
    }
  }

  public function akun()
  {
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"       => "Aktifasi Akun",
      "user"        => $user,
      "pesan"       => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"    => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "akun_aktif"  => $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) as tingkatan FROM user u WHERE u.is_active = 1")->result(),
      "akun_baktif" => $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) as tingkatan FROM user u WHERE u.is_active = 0")->result(),
      "jumba"       => $this->db->query("SELECT u.* FROM user u WHERE u.is_active = 0")->num_rows(),
      "teman"       => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Private/Akun', $data);
  }

  public function nonaktif($username)
  {
    $data = $this->db->query("UPDATE user SET is_active = 0 WHERE username = '$username'");
    if ($data) {
      $this->db->query("DELETE FROM pesan WHERE kode = '$username'");
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Menonaktikan user " . $username,
        'menu' => "Aktifasi Akun",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function aktif($username)
  {
    $data = $this->db->query("UPDATE user SET is_active = 1 WHERE username = '$username'");
    if ($data) {
      $this->db->query("DELETE FROM pesan WHERE kode = '$username'");
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Mengaktifkan user " . $username,
        'menu' => "Aktifasi Akun",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function cabang()
  {
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"         => "Aktifasi Cabang",
      "user"          => $user,
      "pesan"         => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"      => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "akses_cabang"  => $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) as tingkatan FROM user u WHERE u.is_active = 1")->result(),
      "teman"         => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Private/Cabang', $data);
  }

  public function akses_cabang($id_user)
  {
    $now = date("Y-m-d");
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"             => "Memberi Akses Cabang",
      "user"              => $user,
      "pesan"             => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"          => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      'data_user'         => $this->db->query("SELECT u.* FROM user u WHERE u.id_user = '$id_user'")->row(),
      'cabang'            => $this->db->get_where("cabang", ["tgl_berakhir >= " => $now])->result(),
      'cabang_user'       => $this->db->query("SELECT ac.id_cabang, c.nama_cabang, c.kontak_cabang, c.kode_cabang FROM akses_cabang ac JOIN cabang c ON ac.id_cabang = c.id_cabang WHERE ac.id_user = '$id_user'")->result(),
      'jum_cabang_user'   => $this->db->query("SELECT ac.id_cabang, c.nama_cabang, c.kontak_cabang, c.kode_cabang FROM akses_cabang ac JOIN cabang c ON ac.id_cabang = c.id_cabang WHERE ac.id_user = '$id_user'")->num_rows(),
      "teman"             => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Private/Cabang_akses', $data);
  }

  public function add_cabang($id_cabang)
  {
    $id_user = $this->input->get("id_user");
    $data = [
      'id_user' => $id_user,
      'id_cabang' => $id_cabang,
    ];
    $cek = $this->db->insert("akses_cabang", $data);
    if ($cek) {
      $cabang = $this->db->query("SELECT * FROM cabang WHERE id_cabang = '$id_cabang'")->row();
      $user = $this->db->query("SELECT * FROM user WHERE id_user = '$id_user'")->row();
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Memberikan akses cabang " . $cabang->kode_cabang . " ke user " . $user->username,
        'menu' => "Akses Cabang",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(1);
    } else {
      echo json_encode(0);
    }
  }

  public function del_cabang($id_cabang)
  {
    $id_user = $this->input->get("id_user");
    $where = [
      'id_user' => $id_user,
      'id_cabang' => $id_cabang,
    ];
    $cek = [
      $this->db->where($where),
      $this->db->delete("akses_cabang"),
    ];
    if ($cek) {
      $cabang = $this->db->query("SELECT * FROM cabang WHERE id_cabang = '$id_cabang'")->row();
      $user = $this->db->query("SELECT * FROM user WHERE id_user = '$id_user'")->row();
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Menghapus akses cabang " . $cabang->kode_cabang . " ke user " . $user->username,
        'menu' => "Akses Cabang",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(1);
    } else {
      echo json_encode(0);
    }
  }

  public function role()
  {
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"       => "Tingkatan User",
      "user"        => $user,
      "pesan"       => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"    => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "data_user"   => $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE u.is_active = 1")->result(),
      "teman"       => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Private/Role', $data);
  }

  public function ubah_role($username)
  {
    $role_asal = $this->input->get("role_asal");
    $role_tujuan = $this->input->get("role_tujuan");
    $asal = $this->db->get_where("role", ["id_role" => $role_asal])->row()->tingkatan;
    $tujuan = $this->db->get_where("role", ["id_role" => $role_tujuan])->row()->tingkatan;
    $cek = $this->db->query("UPDATE user SET id_role = '$role_tujuan' WHERE username = '$username'");
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Merubah Tingkatan User " . $username . " dari " . $asal . " menjadi " . $tujuan,
        'menu' => "Akses Cabang",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function master_role()
  {
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"       => "Tingkatan User",
      "user"        => $user,
      "pesan"       => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"    => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "data_user"   => $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE u.is_active = 1")->result(),
      "teman"       => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "role"        => $this->db->get("role")->result(),
    ];
    $this->template->load('Template/Home', 'Private/Master_role', $data);
  }

  public function get_tingkatan($nama)
  {
    $data = $this->db->query("SELECT * FROM role WHERE tingkatan = '$nama'")->num_rows();
    if ($data > 0) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function simpan_tingkatan()
  {
    $tingkatan = $this->input->post("tingkatan");
    $data = [
      "tingkatan" => ucfirst($tingkatan),
    ];
    $cek = $this->db->insert("role", $data);
    if ($cek) {
      $role = $this->db->get_where("role", ["tingkatan" => $tingkatan])->row()->id_role;
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Menambahkan Tingkatan " . $tingkatan . ", Dengan ID Tingkatan " . $role,
        'menu' => "Core Tingkatan",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function update_tingkatan()
  {
    $id_role = $this->input->post("id_role");
    $tingkatan = ucfirst($this->input->post("tingkatan"));
    $cek = $this->db->query("UPDATE role SET tingkatan = '$tingkatan' WHERE id_role = '$id_role'");
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Mengubah Tingkatan " . $tingkatan . ", Dengan ID Tingkatan " . $id_role,
        'menu' => "Core Tingkatan",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function hapus_tingkatan($id)
  {
    $tingkatan = $this->db->query("SELECT * FROM role WHERE id_role = '$id'")->row();
    $aktifitas = [
      'username' => $this->session->userdata("username"),
      'kegiatan' => "Menghapus Tingkatan " . $tingkatan->tingkatan . ", Dengan ID Tingkatan " . $id,
      'menu' => "Core Tingkatan",
    ];
    $this->db->insert("activity_user", $aktifitas);
    $cek = $this->db->query("DELETE FROM role WHERE id_role = '$id'");
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  // ================================================================================================ Garansi

  public function garansi()
  {
    $cabang = $this->session->userdata("cabang");
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"         => "Garansi",
      "user"          => $user,
      "cabang"        => $cabang,
      "pesan"         => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"      => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "garansi"       => $this->db->query("SELECT g.id, g.kode_barang, b.nama_barang, s.nama_satuan, g.masa_garansi FROM garansi g JOIN barang b ON g.kode_barang = b.kode_barang JOIN satuan s ON b.satuan = s.kode_satuan WHERE g.kode_cabang = '$cabang'")->result(),
      "teman"         => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Private/Garansi', $data);
  }

  public function simpan_garansi($par)
  {
    $cabang = $this->session->userdata("cabang");
    $kode_barang = $this->input->post("kode_barang");
    $masa_garansi = $this->input->post("masa_garansi");

    if ($par == 1) {
      $id = "";
    } else {
      $id = $this->input->post("id");
    }

    $data = [
      'id'            => $id,
      'kode_cabang'   => $cabang,
      'kode_barang'   => $kode_barang,
      'masa_garansi'  => date("Y-m-d", strtotime($masa_garansi)),
    ];

    if ($par > 1) {
      $cek = $this->db->update("garansi", $data, ["id" => $id]);
    } else {
      $cek_barang = $this->db->get_where("garansi", ["kode_barang" => $kode_barang, "kode_cabang" => $cabang])->row();
      if ($cek_barang) {
        $cek = $this->db->update("garansi", $data, ["id" => $id]);
      } else {
        $cek = $this->db->insert("garansi", $data);
      }
    }

    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }
}
