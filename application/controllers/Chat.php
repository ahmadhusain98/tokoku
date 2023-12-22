<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chat extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
  }

  public function kirim()
  {
    setlocale(LC_ALL, 'id_ID.utf8');
    $userid = $this->session->userdata("username");
    $tujuan = $this->input->get("tujuan");
    $pesan = $this->input->get("pesan");
    $data = [
      'dari' => $userid,
      'ke' => $tujuan,
      'pesan' => $pesan,
    ];
    $x = $this->db->insert("chat", $data);
    if ($x) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function header_pesan($key)
  {
    setlocale(LC_ALL, 'id_ID.utf8');
    $userid = $this->session->userdata("username");
    $saya = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE username = '$userid'")->row();
    $dia = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE u.id_user = '$key'")->row();
    echo json_encode([
      "userid" => $userid,
      "dia" => $dia->gambar,
      "saya" => $saya->gambar,
    ]);
  }

  public function isi_pesan($key)
  {
    setlocale(LC_ALL, 'id_ID.utf8');
    $userid = $this->session->userdata("username");
    $dia = $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) AS tingkatan FROM user u WHERE u.id_user = '$key'")->row();
    $chat = $this->db->query("SELECT *, SUBSTRING(tgl, 1, 10) AS tgl, SUBSTRING(tgl, 12, 5) AS jam FROM chat WHERE ke = '$dia->username' AND dari = '$userid' OR dari = '$dia->username' AND ke = '$userid'")->result();
    echo json_encode($chat);
  }
}
