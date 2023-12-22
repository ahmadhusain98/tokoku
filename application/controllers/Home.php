<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
    date_default_timezone_set('Asia/Jakarta');
  }

  public function set_session()
  {
    $username = $this->session->userdata("username");
    $cabang = $this->session->userdata("cabang");
    $data = [
      'username' => $username,
      'cabang' => $cabang,
      'info' => 1,
    ];
    $this->session->unset_userdata($data);
    $this->session->set_userdata($data);
  }

  public function index()
  {
    $cabang = $this->session->userdata("cabang");
    $data_cabang = $this->db->query("SELECT * FROM cabang WHERE kode_cabang = '$cabang'")->row();
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Dashboard",
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "jum_anggota" => $this->db->query("SELECT * FROM user WHERE id_user IN (SELECT id_user FROM akses_cabang WHERE id_cabang = '$data_cabang->id_cabang') AND id_role = 2")->num_rows(),
    ];
    $this->template->load('Template/Home', 'Home/Dashboard', $data);
  }

  public function hapus_pesan($isinya)
  {
    $get_url = $this->input->get("url");
    $isi = str_replace("%20", " ", $isinya);
    $cek = $this->db->query("DELETE FROM pesan WHERE isi = '$isi'");
    if ($cek) {
      echo json_encode(["status" => 1, "url" => $get_url]);
    } else {
      if ($this->uri->segment(1)) {
        if ($this->uri->segment(2)) {
          $url = $this->uri->segment(1) . "/" . $this->uri->segment(2);
        } else {
          $url = $this->uri->segment(1);
        }
      } else {
        $url = $this->uri->segment(1);
      }
      echo json_encode(["status" => 0, "url" => $get_url]);
    }
  }

  public function update_user()
  {
    $username = $this->input->post("username");
    $nama = $this->input->post("nama");
    $nohp = $this->input->post("nohp");
    $alamat = $this->input->post("alamat");
    $data = [
      'nama'    => $nama,
      'nohp'    => $nohp,
      'alamat'  => $alamat,
    ];
    $where = [
      'username' => $username,
    ];
    $update = $this->db->update("user", $data, $where);
    if ($update) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }
}
