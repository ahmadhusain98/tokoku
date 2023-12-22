<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
    date_default_timezone_set('Asia/Jakarta');
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $menu = $this->db->get_where("menu", ["url" => "Menu"])->row();
    $cek_akses = $this->db->get_where("akses_menu", ["id_role" => $user->id_role, "id_menu" => $menu->id])->num_rows();
    if ($cek_akses < 1) {
      redirect("Home");
    }
  }

  public function index()
  {
    $cabang = $this->session->userdata("cabang");
    $data_cabang = $this->db->query("SELECT * FROM cabang WHERE kode_cabang = '$cabang'")->row();
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Menu Utama",
      "user"      => $user,
      "menu"      => $this->db->get("menu")->result(),
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "jum_anggota" => $this->db->query("SELECT * FROM user WHERE id_user IN (SELECT id_user FROM akses_cabang WHERE id_cabang = '$data_cabang->id_cabang') AND id_role = 2")->num_rows(),
    ];
    $this->template->load('Template/Home', 'Menu/Menu', $data);
  }

  public function get_data_menu($id)
  {
    $data = $this->db->get_where("menu", ["id" => $id])->row();
    echo json_encode($data);
  }

  public function get_nama_menu($nama_menu)
  {
    $data = $this->db->query("SELECT * FROM menu WHERE nama_menu = '$nama_menu'")->num_rows();
    if ($data > 0) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function simpan_menu()
  {
    $nama_menu = $this->input->post("nama_menu");
    $icon = $this->input->post('iconx');
    $url = $this->input->post("urlx");
    $data = [
      "nama_menu" => ucfirst($nama_menu),
      "icon" => $icon,
      "url" => $url,
    ];
    $cek = $this->db->insert("menu", $data);
    if ($cek) {
      $menu = $this->db->get_where("menu", ["nama_menu" => $nama_menu, "icon" => $icon, "url" => $url])->row();
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Menambahkan Menu " . $nama_menu . ", Dengan ID Menu " . $menu->id,
        'menu' => "Core Menu",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function update_menu()
  {
    $id = $this->input->post("id");
    $nama_menu = ucfirst($this->input->post("nama_menu"));
    $icon = $this->input->post('iconx');
    $url = $this->input->post("urlx");
    $cek = $this->db->query("UPDATE menu SET nama_menu = '$nama_menu', icon = '$icon', url = '$url' WHERE id = '$id'");
    if ($cek) {
      $menu = $this->db->get_where("menu", ["nama_menu" => $nama_menu, "icon" => $icon, "url" => $url])->row();
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Mengubah Menu " . $nama_menu . ", Dengan ID Menu " . $id,
        'menu' => "Core Menu",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function hapus_menu($id)
  {
    $menu = $this->db->query("SELECT * FROM menu WHERE id = '$id'")->row();
    $aktifitas = [
      'username' => $this->session->userdata("username"),
      'kegiatan' => "Menghapus Menu " . $menu->nama_menu . ", Dengan ID Menu " . $id,
      'menu' => "Core Menu",
    ];
    $this->db->insert("activity_user", $aktifitas);
    $cek = $this->db->query("DELETE FROM menu WHERE id = '$id'");
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function sub_menu()
  {
    $cabang = $this->session->userdata("cabang");
    $data_cabang = $this->db->query("SELECT * FROM cabang WHERE kode_cabang = '$cabang'")->row();
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $id_menux = $this->input->get("id_menu");
    if ($id_menux == null || $id_menux == 'null' || $id_menux == '') {
      $sub_menu = $this->db->query("SELECT * FROM sub_menu ORDER BY id ASC")->result();
    } else {
      $sub_menu = $this->db->query("SELECT * FROM sub_menu WHERE id_menu = '$id_menux' ORDER BY id ASC")->result();
    }
    $data = [
      "judul"     => "Sub Menu",
      "user"      => $user,
      "sub_menu"  => $sub_menu,
      "id_menu"   => $id_menux,
      "menu"      => $this->db->query("SELECT * FROM menu WHERE id IN (SELECT id_menu FROM sub_menu)")->result(),
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "jum_anggota" => $this->db->query("SELECT * FROM user WHERE id_user IN (SELECT id_user FROM akses_cabang WHERE id_cabang = '$data_cabang->id_cabang') AND id_role = 2")->num_rows(),
    ];
    $this->template->load('Template/Home', 'Menu/Sub_menu', $data);
  }

  public function get_data_sub_menu($id)
  {
    $data = $this->db->get_where("sub_menu", ["id" => $id])->row();
    echo json_encode($data);
  }

  public function get_nama_sub_menu($nama_menu)
  {
    $data = $this->db->query("SELECT * FROM sub_menu WHERE nama_menu = '$nama_menu'")->num_rows();
    if ($data > 0) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function simpan_sub_menu()
  {
    $id_menu = $this->input->post("id_menu");
    $nama_menu = $this->input->post("nama_menu");
    $icon = $this->input->post('iconx');
    $url = $this->input->post("urlx");
    $data = [
      "id_menu" => $id_menu,
      "nama_menu" => ucfirst($nama_menu),
      "icon" => $icon,
      "url" => $url,
    ];
    $cek = $this->db->insert("sub_menu", $data);
    if ($cek) {
      $sub_menu = $this->db->get_where("sub_menu", ["id_menu" => $id_menu, "nama_menu" => $nama_menu, "icon" => $icon, "url" => $url])->row();
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Menambahkan Sub Menu " . $nama_menu . ", Dengan ID Sub Menu " . $sub_menu->id,
        'menu' => "Core Sub Menu",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function update_sub_menu()
  {
    $id = $this->input->post("id");
    $id_menu = $this->input->post("id_menu");
    $nama_menu = ucfirst($this->input->post("nama_menu"));
    $icon = $this->input->post('iconx');
    $url = $this->input->post("urlx");
    $cek = $this->db->query("UPDATE sub_menu SET id_menu = '$id_menu', nama_menu = '$nama_menu', icon = '$icon', url = '$url' WHERE id = '$id'");
    if ($cek) {
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Mengubah Sub Menu " . $nama_menu . ", Dengan ID Sub Menu " . $id,
        'menu' => "Core Sub Menu",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function hapus_sub_menu($id)
  {
    $sub_menu = $this->db->query("SELECT * FROM sub_menu WHERE id = '$id'")->row();
    $aktifitas = [
      'username' => $this->session->userdata("username"),
      'kegiatan' => "Menghapus Sub Menu " . $sub_menu->nama_menu . ", Dengan ID Sub Menu " . $id,
      'menu' => "Core Menu",
    ];
    $this->db->insert("activity_user", $aktifitas);
    $cek = $this->db->query("DELETE FROM sub_menu WHERE id = '$id'");
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function akses_menu()
  {
    $cabang = $this->session->userdata("cabang");
    $data_cabang = $this->db->query("SELECT * FROM cabang WHERE kode_cabang = '$cabang'")->row();
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $menu = $this->db->query("SELECT * FROM menu ORDER BY id ASC")->result();
    $role = $this->db->query("SELECT * FROM role ORDER BY id_role ASC");
    $data = [
      "judul"       => "Akses Menu",
      "user"        => $user,
      "menu"        => $menu,
      "jumrole"     => $role->num_rows(),
      "role"        => $role->result(),
      "menu"        => $this->db->query("SELECT * FROM menu WHERE id IN (SELECT id_menu FROM akses_menu)")->result(),
      "pesan"       => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"    => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"       => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "jum_anggota" => $this->db->query("SELECT * FROM user WHERE id_user IN (SELECT id_user FROM akses_cabang WHERE id_cabang = '$data_cabang->id_cabang') AND id_role = 2")->num_rows(),
    ];
    $this->template->load('Template/Home', 'Menu/Akses_menu', $data);
  }

  public function ubah_akses($id_akses)
  {
    $id_role = $this->input->get("id_role");
    $id_menu = $this->input->get("id_menu");
    if ($id_akses == 0) {
      $data = [
        'id_menu' => $id_menu,
        'id_role' => $id_role,
      ];
      $cek = $this->db->insert("akses_menu", $data);
    } else {
      $akses = $this->db->query("SELECT * FROM akses_menu WHERE id_menu = '$id_menu' AND id_role = '$id_role' AND id = '$id_akses'")->row();
      if ($akses) {
        $menu = $this->db->get_where("menu", ["id" => $akses->id_menu])->row();
        $role = $this->db->get_where("role", ["id_role" => $akses->id_role])->row();
        $aktifitas = [
          'username' => $this->session->userdata("username"),
          'kegiatan' => "Menghapus Menghapus Akses " . $menu->nama_menu . ", Pada Tingkatan " . $role->id_role,
          'menu' => "Core Akses Menu",
        ];
        $this->db->insert("activity_user", $aktifitas);
        $cek = $this->db->query("DELETE FROM akses_menu WHERE id = '$id_akses'");
      } else {
        $data2 = [
          'id_menu' => $id_menu,
          'id_role' => $id_role,
        ];
        $cek = $this->db->insert("akses_menu", $data2);
        $menu = $this->db->get_where("menu", ["id" => $id_menu])->row();
        $role = $this->db->get_where("role", ["idid_role" => $id_role])->row();
        $aktifitas = [
          'username' => $this->session->userdata("username"),
          'kegiatan' => "Menghapus Memberikan Akses " . $menu->nama_menu . ", Pada Tingkatan " . $role->id_role,
          'menu' => "Core Akses Menu",
        ];
        $this->db->insert("activity_user", $aktifitas);
      }
    }
    if ($cek) {
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }

  public function cek_akses($id_menu, $id_role)
  {
    $cek = $this->db->get_where("akses_menu", ["id_menu" => $id_menu, "id_role" => $id_role])->row();
    $menu = $this->db->get_where("menu", ["id" => $id_menu])->row()->nama_menu;
    if ($cek) {
      echo json_encode(["status" => 1, "nama_menu" => $menu]);
    } else {
      echo json_encode(["status" => 0, "nama_menu" => $menu]);
    }
  }

  public function tambah_akses()
  {
    $id_menu = $this->input->post("id_menu");
    $id_role = $this->input->post("id_rolex");
    $data = [
      'id_menu' => $id_menu,
      'id_role' => $id_role,
    ];
    $cek = $this->db->insert("akses_menu", $data);
    $menu = $this->db->get_where("menu", ["id" => $id_menu])->row();
    $role = $this->db->get_where("role", ["id_role" => $id_role])->row();
    $aktifitas = [
      'username' => $this->session->userdata("username"),
      'kegiatan' => "Menghapus Memberikan Akses " . $menu->nama_menu . ", Pada Tingkatan " . $role->id_role,
      'menu' => "Core Akses Menu",
    ];
    $this->db->insert("activity_user", $aktifitas);
    if ($cek) {
      echo json_encode(["status" => 1, "nama_menu" => $menu->nama_menu]);
    } else {
      echo json_encode(["status" => 0, "nama_menu" => $menu->nama_menu]);
    }
  }
}
