<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
    date_default_timezone_set('Asia/Jakarta');
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $menu = $this->db->get_where("menu", ["url" => "Master"])->row();
    $cek_akses = $this->db->get_where("akses_menu", ["id_role" => $user->id_role, "id_menu" => $menu->id])->num_rows();
    if ($cek_akses < 1) {
      redirect("Home");
    }
  }

  public function cabang()
  {
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Master Cabang",
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "cabang"    => $this->db->query("SELECT * FROM cabang ORDER BY kode_cabang ASC")->result(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Cabang/Data', $data);
  }

  public function cek_kode_cabang($kode_cabang)
  {
    $cek = $this->db->query("SELECT * FROM cabang WHERE kode_cabang = '$kode_cabang'")->num_rows();
    if ($cek > 0) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function cek_nama_cabang($nama_cabang)
  {
    $cek = $this->db->query("SELECT * FROM cabang WHERE nama_cabang = '$nama_cabang'")->num_rows();
    if ($cek > 0) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function tambah_cabang()
  {
    $kode_cabang      = $this->input->post("kode_cabang");
    $nama_cabang      = $this->input->post("nama_cabang");
    $kontak_cabang    = $this->input->post("kontak_cabang");
    $penanggungjawab  = $this->input->post("penanggungjawab");
    $tgl_mulai        = $this->input->post("tgl_mulai");
    $tgl_berakhir     = $this->input->post("tgl_berakhir");
    $alamat_cabang    = $this->input->post("alamat_cabang");
    $data = [
      'kode_cabang'     => strtoupper($kode_cabang),
      'nama_cabang'     => ucfirst($nama_cabang),
      'kontak_cabang'   => $kontak_cabang,
      'penanggungjawab' => $penanggungjawab,
      'tgl_mulai'       => $tgl_mulai,
      'tgl_berakhir'    => $tgl_berakhir,
      'alamat_cabang'   => $alamat_cabang,
    ];
    $cek = $this->db->insert("cabang", $data);
    if ($cek) {
      $username   = $this->session->userdata("username");
      $data_pesan = [
        'username'  => $username,
        'kegiatan'  => "Menambahkan Cabang Baru " . $nama_cabang . ", Dengan Kode " . $kode_cabang,
        'menu'      => "Master Cabang",
      ];
      $this->db->insert("activity_user", $data_pesan);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function update_cabang()
  {
    $kode_cabang      = $this->input->post("kode_cabang");
    $nama_cabang      = $this->input->post("nama_cabang");
    $kontak_cabang    = $this->input->post("kontak_cabang");
    $penanggungjawab  = $this->input->post("penanggungjawab");
    $tgl_mulai        = $this->input->post("tgl_mulai");
    $tgl_berakhir     = $this->input->post("tgl_berakhir");
    $alamat_cabang    = $this->input->post("alamat_cabang");
    $where = [
      'kode_cabang'   => $kode_cabang,
    ];
    $data = [
      'nama_cabang'     => ucfirst($nama_cabang),
      'kontak_cabang'   => $kontak_cabang,
      'penanggungjawab' => $penanggungjawab,
      'tgl_mulai'       => $tgl_mulai,
      'tgl_berakhir'    => $tgl_berakhir,
      'alamat_cabang'   => $alamat_cabang,
    ];
    $cek = $this->db->update("cabang", $data, $where);
    if ($cek) {
      $username   = $this->session->userdata("username");
      $data_pesan = [
        'username'  => $username,
        'kegiatan'  => "Mengubah Cabang Baru " . $nama_cabang . ", Dengan Kode " . $kode_cabang,
        'menu'      => "Master Cabang",
      ];
      $this->db->insert("activity_user", $data_pesan);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function hapus_cabang($id_cabang)
  {
    $cabang = $this->db->query("SELECT * FROM cabang WHERE id_cabang = '$id_cabang'")->row();
    $username = $this->session->userdata("username");
    $data_pesan = [
      'username' => $username,
      'kegiatan' => "Menghapus Cabang Baru " . $cabang->nama_cabang . ", Dengan Kode " . $cabang->kode_cabang,
      'menu' => "Master Cabang",
    ];
    $this->db->insert("activity_user", $data_pesan);
    $data = $this->db->query("DELETE FROM akses_cabang WHERE id_cabang = '$id_cabang'");
    $data = $this->db->query("DELETE FROM cabang WHERE id_cabang = '$id_cabang'");
    if ($data) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function anggota()
  {
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Master Anggota",
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "anggota"   => $this->db->query("SELECT u.*, (SELECT tingkatan FROM role WHERE id_role = u.id_role) as tingkatan FROM user u ORDER BY u.username ASC")->result(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Anggota/Data', $data);
  }

  public function tambah_anggota()
  {
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Tambah Anggota",
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "role"      => $this->db->query("SELECT * FROM role")->result(),
    ];
    $this->template->load('Template/Home', 'Anggota/Tambah', $data);
  }

  public function edit_anggota($id)
  {
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Tambah Anggota",
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "data_user" => $this->db->query("SELECT * FROM user WHERE id_user = '$id'")->row(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Anggota/Edit', $data);
  }

  public function edit_anggota_aksi($id)
  {
    $nama   = $this->input->post("nama");
    $nohp   = $this->input->post("nohp");
    $alamat = $this->input->post("alamat");
    $data = [
      'nama'    => $nama,
      'nohp'    => $nohp,
      'alamat'  => $alamat,
    ];
    $where = [
      'id_user' => $id,
    ];
    $cek = $this->db->update("user", $data, $where);
    if ($cek) {
      $user = $this->db->query("SELECT * FROM user WHERE id_user = '$id'")->row();
      $usernamex = $this->session->userdata("username");
      $data_pesan = [
        'username' => $usernamex,
        'kegiatan' => "Mengubah Anggota Baru " . $nama . ", Dengan Username " . $user->username,
        'menu' => "Master Anggota",
      ];
      $this->db->insert("activity_user", $data_pesan);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function tambah_anggota_aksi()
  {
    $config['upload_path'] = 'assets/user/';
    $config['allowed_types'] = 'jpg|png|jpeg';
    $config['max_size'] = '2048';
    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    $username = $this->input->post("username");
    $password = md5($this->input->post("password"));
    $nama = $this->input->post("nama");
    $id_role = $this->input->post("id_role");
    $nohp = $this->input->post("nohp");
    $alamat = $this->input->post("alamat");

    // upload image
    // cek jika foto tidak ada
    if ($_FILES['filefoto']['name']) {
      $this->upload->do_upload('filefoto');
      $gambar = $this->upload->data('file_name');
    } else {
      $gambar = "default.png";
    }

    $data = [
      'username'  => $username,
      'password'  => $password,
      'nama'      => $nama,
      'nohp'      => $nohp,
      'alamat'    => $alamat,
      'gambar'    => $gambar,
      'id_role'   => $id_role,
      'is_active' => 0,
      'on_off'    => 0,
    ];

    $cek = $this->db->insert("user", $data);
    if ($cek) {
      $usernamex = $this->session->userdata("username");
      $data_pesan = [
        'username' => $usernamex,
        'kegiatan' => "Menambahkan Anggota Baru " . $nama . ", Dengan Username " . $username,
        'menu' => "Master Anggota",
      ];
      $this->db->insert("activity_user", $data_pesan);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function hapus_anggota($id)
  {
    $anggota = $this->db->query("SELECT * FROM user WHERE id_user = '$id'")->row();
    $username = $this->session->userdata("username");
    $data_pesan = [
      'username' => $username,
      'kegiatan' => "Menghapus Anggota Baru " . $anggota->nama . ", Dengan Username " . $anggota->username,
      'menu' => "Master Anggota",
    ];
    $this->db->insert("activity_user", $data_pesan);
    $data = $this->db->query("DELETE FROM user WHERE id_user = '$id'");
    if ($data) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function barang()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_kategorix = $this->input->get("kode_kategori");
    if ($kode_kategorix == null || $kode_kategorix == 'null' || $kode_kategorix == '') {
      $barang = $this->db->query("SELECT b.*, (SELECT nama_satuan FROM satuan WHERE kode_satuan = b.satuan) as satuan FROM barang b WHERE kode_cabang = '$cabang' ORDER BY b.kode_barang ASC")->result();
    } else {
      $barang = $this->db->query("SELECT b.*, (SELECT nama_satuan FROM satuan WHERE kode_satuan = b.satuan) as satuan FROM barang b WHERE kode_cabang = '$cabang' AND kode_kategori = '$kode_kategorix' ORDER BY b.kode_barang ASC")->result();
    }
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Master Barang",
      "user"      => $user,
      "kode_kategori" => $kode_kategorix,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "kategori"  => $this->db->query("SELECT * FROM kategori WHERE kode_cabang = '$cabang'")->result(),
      "barang"    => $barang,
    ];
    $this->template->load('Template/Home', 'Barang/Data', $data);
  }

  public function tambah_barang()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_barang = $this->M_core->kode_barang($cabang);
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Tambah Barang",
      "user"      => $user,
      "cabang"    => $cabang,
      "kode"      => $kode_barang,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "barang"    => $this->db->query("SELECT * FROM barang ORDER BY kode_barang ASC")->result(),
    ];
    $this->template->load('Template/Home', 'Barang/Tambah', $data);
  }

  public function tambah_barang_aksi()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_kategori = $this->input->post("kode_kategori");
    $kode_barang = $this->input->post("kode_barang");
    $nama_barang = $this->input->post("nama_barang");
    $satuan = $this->input->post("satuan");
    $pilihan_profit = $this->input->post("pilihan_profit");
    $profit = preg_replace("/[^A-Za-z0-9\  ]/", "", $this->input->post("profit"));
    $harga_beli = preg_replace("/[^A-Za-z0-9\  ]/", "", $this->input->post("harga_beli"));
    if ($pilihan_profit == "persentase") {
      $profit_hasil = ($harga_beli * ($profit / 100));
      $hasil = ($harga_beli * ($profit / 100)) + $harga_beli;
    } else {
      $profit_hasil = $profit;
      $hasil = $profit + $harga_beli;
    }
    $pilihan_disc = $this->input->post("pilihan_diskon");
    $diskon = preg_replace("/[^A-Za-z0-9\  ]/", "", $this->input->post("diskon"));
    if ($pilihan_disc == "persentase") {
      $diskon_hasil = ceil($hasil * ($diskon / 100));
    } else {
      $diskon_hasil = ceil($diskon);
    }
    $harga_jual = preg_replace("/[^A-Za-z0-9\  ]/", "", $this->input->post("harga_jual"));

    $config['upload_path'] = 'assets/img/barang/';
    $config['allowed_types'] = 'jpg|png|jpeg';
    $config['max_size'] = '2048';
    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    if ($_FILES['filefoto']['name']) {
      $this->upload->do_upload('filefoto');
      $gambar = $this->upload->data('file_name');
      $data = [
        'kode_cabang' => $cabang,
        'gambar' => $gambar,
        'kode_kategori' => $kode_kategori,
        'kode_barang' => $kode_barang,
        'nama_barang' => ucfirst($nama_barang),
        'satuan1' => $satuan,
        'pilihan_profit' => $pilihan_profit,
        'profit' => $profit_hasil,
        'harga_beli' => $harga_beli,
        'harga_jual' => $harga_jual,
        'pilihan_disc' => $pilihan_disc,
        'disc' => $diskon_hasil,
      ];
    } else {
      $data = [
        'kode_cabang' => $cabang,
        'gambar' => 'default.jpg',
        'kode_kategori' => $kode_kategori,
        'kode_barang' => $kode_barang,
        'nama_barang' => ucfirst($nama_barang),
        'satuan' => $satuan,
        'pilihan_profit' => $pilihan_profit,
        'profit' => $profit_hasil,
        'harga_beli' => $harga_beli,
        'harga_jual' => $harga_jual,
        'pilihan_disc' => $pilihan_disc,
        'disc' => $diskon_hasil,
      ];
    }

    $cek = $this->db->insert("barang", $data);
    if ($cek) {
      $username = $this->session->userdata("username");
      $data_pesan = [
        'username' => $username,
        'kegiatan' => "Menambahkan Barang Baru " . $nama_barang . ", Dengan Kode " . $kode_barang,
        'menu' => "Master Barang",
      ];
      $this->db->insert("activity_user", $data_pesan);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function cek_nama_barang($nama)
  {
    $cabang = $this->session->userdata("cabang");
    $data = $this->db->query("SELECT * FROM barang WHERE nama_barang = '$nama' AND kode_cabang = '$cabang'")->num_rows();
    if ($data > 0) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function hapus_barang($id)
  {
    $barang = $this->db->query("SELECT * FROM barang WHERE id_barang = '$id'")->row();
    $this->db->query("DELETE FROM stok WHERE kode_barang = '$barang->kode_barang' AND kode_cabang = '$barang->kode_cabang'");
    $username = $this->session->userdata("username");
    $data_pesan = [
      'username' => $username,
      'kegiatan' => "Menghapus Barang " . $barang->nama_barang . ", Dengan Kode " . $barang->kode_barang,
      'menu' => "Master Barang",
    ];
    $this->db->insert("activity_user", $data_pesan);
    $cek = $this->db->query("DELETE FROM barang WHERE id_barang = '$id'");
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function edit_barang($id)
  {
    $cabang = $this->session->userdata("cabang");
    $kode_barang = $this->M_core->kode_barang($cabang);
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Ubah Barang",
      "user"      => $user,
      "cabang"    => $cabang,
      "kode"      => $kode_barang,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "barang"    => $this->db->query("SELECT * FROM barang WHERE id_barang = '$id'")->row(),
    ];
    $this->template->load('Template/Home', 'Barang/Ubah', $data);
  }

  public function edit_barang_aksi()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_kategori = $this->input->post("kode_kategori");
    $kode_barang = $this->input->post("kode_barang");
    $nama_barang = $this->input->post("nama_barang");
    $satuan = $this->input->post("satuan");
    $saldo_awal = preg_replace("/[^A-Za-z0-9\  ]/", "", $this->input->post("saldo_awal"));
    if ($saldo_awal == '') {
      $saldo = 0;
    } else {
      $saldo = $saldo_awal;
    }
    if ($saldo_awal == '') {
      $saldo = 0;
    } else {
      $saldo = $saldo_awal;
    }
    $pilihan_profit = $this->input->post("pilihan_profit");
    $profit = preg_replace("/[^A-Za-z0-9\  ]/", "", $this->input->post("profit"));
    $harga_beli = preg_replace("/[^A-Za-z0-9\  ]/", "", $this->input->post("harga_beli"));
    if ($pilihan_profit == "persentase") {
      $profit_hasil = ($harga_beli * ($profit / 100));
      $hasil = ($harga_beli * ($profit / 100)) + $harga_beli;
    } else {
      $profit_hasil = $profit;
      $hasil = $profit + $harga_beli;
    }
    $pilihan_disc = $this->input->post("pilihan_diskon");
    $diskon = preg_replace("/[^A-Za-z0-9\  ]/", "", $this->input->post("diskon"));
    if ($pilihan_disc == "persentase") {
      $diskon_hasil = ceil($hasil * ($diskon / 100));
    } else {
      $diskon_hasil = ceil($diskon);
    }
    $harga_jual = preg_replace("/[^A-Za-z0-9\  ]/", "", $this->input->post("harga_jual"));

    $config['upload_path'] = 'assets/img/barang/';
    $config['allowed_types'] = 'jpg|png|jpeg';
    $config['max_size'] = '2048';
    $this->load->library('upload', $config);
    $this->upload->initialize($config);

    if ($_FILES['filefoto']['name']) {
      $this->upload->do_upload('filefoto');
      $gambar = $this->upload->data('file_name');
      $data = [
        'kode_cabang' => $cabang,
        'gambar' => $gambar,
        'kode_kategori' => $kode_kategori,
        'kode_barang' => $kode_barang,
        'nama_barang' => ucfirst($nama_barang),
        'satuan' => $satuan,
        'saldo_awal' => $saldo,
        'pilihan_profit' => $pilihan_profit,
        'profit' => $profit_hasil,
        'harga_beli' => $harga_beli,
        'harga_jual' => $harga_jual,
        'pilihan_disc' => $pilihan_disc,
        'disc' => $diskon_hasil,
      ];
    } else {
      $data = [
        'kode_cabang' => $cabang,
        'kode_kategori' => $kode_kategori,
        'kode_barang' => $kode_barang,
        'nama_barang' => ucfirst($nama_barang),
        'satuan' => $satuan,
        'saldo_awal' => $saldo,
        'pilihan_profit' => $pilihan_profit,
        'profit' => $profit_hasil,
        'harga_beli' => $harga_beli,
        'harga_jual' => $harga_jual,
        'pilihan_disc' => $pilihan_disc,
        'disc' => $diskon_hasil,
      ];
    }
    $cek = $this->db->update("barang", $data, ["kode_barang" => $kode_barang]);
    if ($cek) {
      $barangx = $this->db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang' AND kode_cabang = '$cabang'");
      $barang = $barangx->row();

      if ($barangx->num_rows() > 0) {
        $this->db->query("DELETE FROM stok WHERE kode_barang = '$barang->kode_barang' AND kode_cabang = '$barang->kode_cabang'");
      }
      $data_stok = [
        'kode_cabang' => $cabang,
        'kode_barang' => $kode_barang,
        'terima' => $saldo_awal,
        'keluar' => 0,
        'saldo_akhir' => $saldo_awal,
      ];
      $this->db->insert("stok", $data_stok);

      $username = $this->session->userdata("username");
      $data_pesan = [
        'username' => $username,
        'kegiatan' => "Mengubah Barang " . $barang->nama_barang . ", Dengan Kode " . $barang->kode_barang,
        'menu' => "Master Barang",
      ];
      $this->db->insert("activity_user", $data_pesan);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function get_barang()
  {
    $cabang = $this->session->userdata("cabang");
    $kode_barang = $this->input->get("kode_barang");
    $data = $this->db->query("SELECT b.*, s.nama_satuan, s.kode_satuan FROM barang b JOIN satuan s ON b.satuan = s.kode_satuan WHERE b.kode_cabang = '$cabang' AND b.kode_barang = '$kode_barang'")->row();
    echo json_encode($data);
  }
}
