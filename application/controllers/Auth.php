<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
    date_default_timezone_set('Asia/Jakarta');
  }

  public function index()
  {
    $data = [
      'judul' => "Selamat Datang",
    ];
    $this->template->load('Template/Auth', 'Auth/Login', $data);
  }

  public function cekusername_reg($username)
  {
    $data = $this->db->query("SELECT * FROM user WHERE username = '$username'")->num_rows();
    if ($data > 0) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function regist()
  {
    $data = [
      'judul' => "Daftarkan Diri",
    ];
    $this->template->load('Template/Auth', 'Auth/Regist', $data);
  }

  public function register()
  {
    $username = $this->input->post("username");
    $password = md5($this->input->post("password"));
    $jk       = $this->input->post("jk");
    if ($jk == "P") {
      $gambar = "pria.png";
    } else {
      $gambar = "wanita.png";
    }
    $data = [
      'username'  => $username,
      'password'  => $password,
      'jk'        => $jk,
      'id_role'   => 2,
      'gambar'    => $gambar,
    ];
    $insert = $this->db->insert("user", $data);
    if ($insert) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function cekuseraktifasi()
  {
    $username = $this->input->post("username");
    $data     = $this->db->query("SELECT * FROM user WHERE username = '$username'")->num_rows();
    if ($data > 0) {
      echo json_encode(["status" => 1, "username" => $username]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function cekpengajuan($username)
  {
    $data = $this->db->query("SELECT * FROM pesan WHERE kode = '$username'")->num_rows();
    if ($data < 1) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function minta($username)
  {
    $data = [
      "kode"  => $username,
      "isi"   => "Meminta Aktifasi",
    ];
    $insert = $this->db->insert("pesan", $data);
    if ($insert) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function cekuser($username)
  {
    $data = $this->db->query("SELECT * FROM user WHERE username = '$username'")->num_rows();
    if ($data < 1) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function cekatifuser($username)
  {
    $data = $this->db->query("SELECT * FROM user WHERE username = '$username'")->row();
    if ($data->is_active < 1) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function cekpass_log()
  {
    $date       = date("Y-m-d");
    $jam        = date("H:i:s");
    $username   = $this->input->post("username");
    $cabang     = $this->input->post("cabang");
    $cek        = $this->db->query("SELECT * FROM user WHERE username = '$username'")->row();
    $password   = md5($this->input->post("password"));
    if ($cek->password == $password) {
      $data = [
        'username'  => $username,
        'cabang'    => $cabang,
        'info'      => 0,
        'id_role'   => $cek->id_role,
      ];
      $this->session->set_userdata($data);
      $cek_log = $this->db->query("SELECT * FROM activity_log WHERE kode = '$cek->username'")->num_rows();
      if ($cek_log > 0) {
        $this->db->query("UPDATE activity_log SET tgl_masuk = '$date', jam_masuk = '$jam' WHERE kode = '$cek->username'");
      } else {
        $data_pesan = [
          'kode'      => $cek->username,
          'isi'       => "Login / Logout",
          'tgl_masuk' => $date,
          'jam_masuk' => $jam,
        ];
        $this->db->insert("activity_log", $data_pesan);
      }
      $aktifitas = [
        'username'  => $username,
        'kegiatan'  => "Melakukan Login di Cabang " . $cabang,
        'menu'      => "Login",
      ];
      $this->db->insert("activity_user", $aktifitas);
      $this->db->query("UPDATE user SET on_off = '1' WHERE username = '$cek->username'");
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function cekua()
  {
    $username = $this->input->post("username");
    $cek      = $this->db->query("SELECT * FROM user WHERE username = '$username'")->row();
    if ($cek) {
      if ((int)$cek->is_active > 0) {
        echo json_encode(["status" => 0]);
      } else {
        echo json_encode(["status" => 1]);
      }
    } else {
      echo json_encode(["status" => 1]);
    }
  }

  public function keluar($username)
  {
    $cabang   = $this->session->userdata("cabang");
    $date     = date("Y-m-d");
    $jam      = date("H:i:s");
    $cek      = $this->db->query("UPDATE user SET on_off = '0' WHERE username = '$username'");
    if ($cek) {
      $this->db->query("UPDATE activity_log SET tgl_keluar = '$date', jam_keluar = '$jam' WHERE kode = '$username'");
      $aktifitas = [
        'username'  => $username,
        'kegiatan'  => "Melakukan Logout di Cabang " . $cabang,
        'menu'      => "Logout",
      ];
      $this->db->insert("activity_user", $aktifitas);
      $this->session->sess_destroy();
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  function cekcabang($username)
  {
    $now        = date("Y-m-d");
    $user       = $this->db->query("SELECT * FROM user WHERE username = '$username'")->row();
    $id_user    = $user->id_user;
    $data       = $this->db->query("SELECT * FROM cabang WHERE id_cabang IN (SELECT id_cabang FROM akses_cabang WHERE id_user = '$id_user') AND tgl_berakhir >= '$now'")->result();
    echo json_encode($data);
  }
}
