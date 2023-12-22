<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orderan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
    date_default_timezone_set('Asia/Jakarta');
  }

  public function index()
  {
    $cabang   = $this->session->userdata("cabang");
    $username = $this->session->userdata("username");
    $orderan  = $this->db->query("SELECT SUM(qty) as qty, (SELECT nama_barang FROM barang WHERE kode_barang = o.kode_barang) as nama_barang, (SELECT harga_jual FROM barang WHERE kode_barang = o.kode_barang) as harga_jual, (SELECT gambar FROM barang WHERE kode_barang = o.kode_barang) as gambar FROM order_pesanan o WHERE kode_cabang = '$cabang' AND username = '$username' GROUP BY kode_barang ORDER BY o.kode_order ASC")->result();
    $user     = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Orderan Ku",
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "orderan"   => $orderan,
    ];
    $this->template->load('Template/Home', 'Orderan/Data', $data);
  }

  public function Batalkan_pesanan()
  {
    $username = $this->session->userdata("username");
    $cabang   = $this->session->userdata("cabang");
    $cek = $this->db->query("DELETE FROM order_pesanan WHERE kode_cabang = '$cabang' AND username = '$username'");
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }
}
