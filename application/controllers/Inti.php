<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inti extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
    date_default_timezone_set('Asia/Jakarta');
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $menu = $this->db->get_where("menu", ["url" => "Inti"])->row();
    $cek_akses = $this->db->get_where("akses_menu", ["id_role" => $user->id_role, "id_menu" => $menu->id])->num_rows();
    if ($cek_akses < 1) {
      redirect("Home");
    }
  }

  // ==================================================================================================SATUAN

  public function satuan()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_satuan = $this->M_core->kode_satuan($cabang);
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Satuan",
      "user"      => $user,
      "kode"      => $kode_satuan,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "satuan"    => $this->db->query("SELECT * FROM satuan WHERE kode_cabang = '$cabang'")->result(),
    ];
    $this->template->load('Template/Home', 'Inti/Satuan', $data);
  }

  public function get_nama_satuan($nama)
  {
    $cabang = $this->session->userdata("cabang");
    $data = $this->db->query("SELECT * FROM satuan WHERE kode_cabang = '$cabang' AND nama_satuan = '$nama'")->num_rows();
    if ($data > 0) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function simpan_satuan()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_satuan = $this->M_core->kode_satuan($cabang);
    $nama_satuan = $this->input->post("nama_satuan");
    $data = [
      "kode_cabang" => $cabang,
      "kode_satuan" => $kode_satuan,
      "nama_satuan" => ucfirst($nama_satuan),
    ];
    $cek = $this->db->insert("satuan", $data);
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Menambahkan satuan " . $nama_satuan . ", Dengan Kode " . $kode_satuan,
        'menu' => "Core Satuan",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function update_satuan()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_satuan = $this->input->post("kode_satuan");
    $nama_satuan = ucfirst($this->input->post("nama_satuan"));
    $cek = $this->db->query("UPDATE satuan SET nama_satuan = '$nama_satuan' WHERE kode_cabang = '$cabang' AND kode_satuan = '$kode_satuan'");
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Mengubah satuan " . $nama_satuan . ", Dengan Kode " . $kode_satuan,
        'menu' => "Core Satuan",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function hapus_satuan($id)
  {
    $satuan = $this->db->query("SELECT * FROM satuan WHERE id_satuan = '$id'")->row();
    $aktifitas = [
      'username' => $this->session->userdata("username"),
      'kegiatan' => "Menghapus satuan " . $satuan->nama_satuan . ", Dengan Kode " . $satuan->kode_satuan,
      'menu' => "Core Satuan",
    ];
    $this->db->insert("activity_user", $aktifitas);
    $cek = $this->db->query("DELETE FROM satuan WHERE id_satuan = '$id'");
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  // ==================================================================================================KATEGORI

  public function kategori()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_kategori = $this->M_core->kode_kategori($cabang);
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Kategori",
      "user"      => $user,
      "kode"      => $kode_kategori,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "kategori"  => $this->db->query("SELECT * FROM kategori WHERE kode_cabang = '$cabang'")->result(),
    ];
    $this->template->load('Template/Home', 'Inti/Kategori', $data);
  }

  public function get_nama_kategori($nama)
  {
    $cabang = $this->session->userdata("cabang");
    $data = $this->db->query("SELECT * FROM kategori WHERE kode_cabang = '$cabang' AND nama_kategori = '$nama'")->num_rows();
    if ($data > 0) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function simpan_kategori()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_kategori = $this->M_core->kode_kategori($cabang);
    $nama_kategori = $this->input->post("nama_kategori");
    $data = [
      "kode_cabang" => $cabang,
      "kode_kategori" => $kode_kategori,
      "nama_kategori" => ucfirst($nama_kategori),
    ];
    $cek = $this->db->insert("kategori", $data);
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Menambahkan kategori " . $nama_kategori . ", Dengan Kode " . $kode_kategori,
        'menu' => "Core Kategori",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function update_kategori()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_kategori = $this->input->post("kode_kategori");
    $nama_kategori = ucfirst($this->input->post("nama_kategori"));
    $cek = $this->db->query("UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE kode_cabang = '$cabang' AND kode_kategori = '$kode_kategori'");
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Mengubah kategori " . $nama_kategori . ", Dengan Kode " . $kode_kategori,
        'menu' => "Core Kategori",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function hapus_kategori($id)
  {
    $kategori = $this->db->query("SELECT * FROM kategori WHERE id_kategori = '$id'")->row();
    $aktifitas = [
      'username' => $this->session->userdata("username"),
      'kegiatan' => "Menghapus kategori " . $kategori->nama_kategori . ", Dengan Kode " . $kategori->kode_kategori,
      'menu' => "Core Kategori",
    ];
    $this->db->insert("activity_user", $aktifitas);
    $cek = $this->db->query("DELETE FROM kategori WHERE id_kategori = '$id'");
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  // ==================================================================================================SUPPLIER

  public function supplier()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_supplier = $this->M_core->kode_supplier($cabang);
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Supplier",
      "user"      => $user,
      "kode"      => $kode_supplier,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "supplier"  => $this->db->query("SELECT * FROM supplier WHERE kode_cabang = '$cabang'")->result(),
    ];
    $this->template->load('Template/Home', 'Inti/Supplier', $data);
  }

  public function get_nama_supplier($nama)
  {
    $cabang = $this->session->userdata("cabang");
    $data = $this->db->query("SELECT * FROM supplier WHERE kode_cabang = '$cabang' AND nama_supplier = '$nama'")->num_rows();
    if ($data > 0) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function simpan_supplier()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_supplier = $this->M_core->kode_supplier($cabang);
    $nama_supplier = $this->input->post("nama_supplier");
    $no_hp = $this->input->post("no_hp");
    $email = $this->input->post("email");
    $alamat = $this->input->post("alamat");
    $wali = $this->input->post("wali");
    $data = [
      "kode_cabang" => $cabang,
      "kode_supplier" => $kode_supplier,
      "nama_supplier" => ucfirst($nama_supplier),
      "wali" => ucfirst($wali),
      "nohp_supplier" => $no_hp,
      "email_supplier" => $email,
      "alamat" => $alamat,
    ];
    $cek = $this->db->insert("supplier", $data);
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Menambahkan supplier " . $nama_supplier . ", Dengan Kode " . $kode_supplier,
        'menu' => "Core Supplier",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function update_supplier()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_supplier = $this->input->post("kode_supplier");
    $nama_supplier = ucfirst($this->input->post("nama_supplier"));
    $no_hp = $this->input->post("no_hp");
    $email = $this->input->post("email");
    $alamat = $this->input->post("alamat");
    $wali = $this->input->post("wali");
    $cek = $this->db->query("UPDATE supplier SET nama_supplier = '$nama_supplier', wali = '$wali', nohp_supplier = '$no_hp', email_supplier = '$email', alamat = '$alamat' WHERE kode_cabang = '$cabang' AND kode_supplier = '$kode_supplier'");
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Mengubah supplier " . $nama_supplier . ", Dengan Kode " . $kode_supplier,
        'menu' => "Core Supplier",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function hapus_supplier($id)
  {
    $supplier = $this->db->query("SELECT * FROM supplier WHERE id_supplier = '$id'")->row();
    $aktifitas = [
      'username' => $this->session->userdata("username"),
      'kegiatan' => "Menghapus supplier " . $supplier->nama_supplier . ", Dengan Kode " . $supplier->kode_supplier,
      'menu' => "Core Supplier",
    ];
    $this->db->insert("activity_user", $aktifitas);
    $cek = $this->db->query("DELETE FROM supplier WHERE id_supplier = '$id'");
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  // ==================================================================================================PPN

  public function ppn()
  {
    $cabang = $this->session->userdata("cabang");
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "PPN",
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "ppn"  => $this->db->query("SELECT * FROM ppn")->result(),
    ];
    $this->template->load('Template/Home', 'Inti/Ppn', $data);
  }

  public function get_nama_ppn()
  {
    $nama = $this->input->get("nama");
    $data = $this->db->query("SELECT * FROM ppn WHERE nama_ppn = '$nama'")->num_rows();
    if ($data > 0) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function simpan_ppn()
  {
    $nama_ppn = $this->input->post("nama_ppn");
    $value_ppn = $this->input->post("value_ppn");
    $data = [
      "nama_ppn" => ucfirst($nama_ppn),
      "value_ppn" => $value_ppn,
    ];
    $cek = $this->db->insert("ppn", $data);
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Menambahkan ppn " . $nama_ppn . ", Dengan Value " . $value_ppn,
        'menu' => "Core PPN",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function update_ppn()
  {
    $id_ppn = $this->input->post("id_ppn");
    $nama_ppn = ucfirst($this->input->post("nama_ppn"));
    $value_ppn = $this->input->post("value_ppn");
    $cek = $this->db->query("UPDATE ppn SET nama_ppn = '$nama_ppn', value_ppn = '$value_ppn' WHERE id_ppn = '$id_ppn'");
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Mengubah PPN " . $nama_ppn . ", Dengan Value " . $value_ppn,
        'menu' => "Core PPN",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function hapus_ppn($id)
  {
    $ppn = $this->db->query("SELECT * FROM ppn WHERE id_ppn = '$id'")->row();
    $aktifitas = [
      'username' => $this->session->userdata("username"),
      'kegiatan' => "Menghapus PPN " . $ppn->nama_ppn . ", Dengan Value " . $ppn->value_ppn,
      'menu' => "Core PPN",
    ];
    $this->db->insert("activity_user", $aktifitas);
    $cek = $this->db->query("DELETE FROM ppn WHERE id_ppn = '$id'");
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  // ==================================================================================================GUDANG

  public function gudang()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_gudang = $this->M_core->kode_gudang($cabang);
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Gudang",
      "user"      => $user,
      "kode"      => $kode_gudang,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "gudang"    => $this->db->query("SELECT * FROM gudang WHERE kode_cabang = '$cabang'")->result(),
    ];
    $this->template->load('Template/Home', 'Inti/Gudang', $data);
  }

  public function get_nama_gudang($nama)
  {
    $cabang = $this->session->userdata("cabang");
    $data = $this->db->query("SELECT * FROM gudang WHERE kode_cabang = '$cabang' AND nama_gudang = '$nama'")->num_rows();
    if ($data > 0) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function simpan_gudang()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_gudang = $this->M_core->kode_gudang($cabang);
    $nama_gudang = $this->input->post("nama_gudang");
    $data = [
      "kode_cabang" => $cabang,
      "kode_gudang" => $kode_gudang,
      "nama_gudang" => ucfirst($nama_gudang),
    ];
    $cek = $this->db->insert("gudang", $data);
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Menambahkan gudang " . $nama_gudang . ", Dengan Kode " . $kode_gudang,
        'menu' => "Core gudang",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function update_gudang()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_gudang = $this->input->post("kode_gudang");
    $nama_gudang = ucfirst($this->input->post("nama_gudang"));
    $cek = $this->db->query("UPDATE gudang SET nama_gudang = '$nama_gudang' WHERE kode_cabang = '$cabang' AND kode_gudang = '$kode_gudang'");
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Mengubah gudang " . $nama_gudang . ", Dengan Kode " . $kode_gudang,
        'menu' => "Core gudang",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function hapus_gudang($id)
  {
    $gudang = $this->db->query("SELECT * FROM gudang WHERE id_gudang = '$id'")->row();
    $aktifitas = [
      'username' => $this->session->userdata("username"),
      'kegiatan' => "Menghapus gudang " . $gudang->nama_gudang . ", Dengan Kode " . $gudang->kode_gudang,
      'menu' => "Core gudang",
    ];
    $this->db->insert("activity_user", $aktifitas);
    $cek = $this->db->query("DELETE FROM gudang WHERE id_gudang = '$id'");
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }
}
