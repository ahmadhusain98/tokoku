<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
    date_default_timezone_set('Asia/Jakarta');
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $menu = $this->db->get_where("menu", ["url" => "Penjualan"])->row();
    $cek_akses = $this->db->get_where("akses_menu", ["id_role" => $user->id_role, "id_menu" => $menu->id])->num_rows();
    if ($cek_akses < 1) {
      redirect("Home");
    }
  }

  public function index()
  {
    $cabang = $this->session->userdata("cabang");
    $data_cabang = $this->db->query("SELECT * FROM cabang WHERE kode_cabang = '$cabang'")->row();
    $barang = $this->db->query("SELECT b.*, b.disc, (SELECT nama_satuan FROM satuan WHERE kode_satuan = b.satuan) as satuan, nama_kategori FROM barang b JOIN kategori USING (kode_kategori) WHERE b.kode_cabang = '$cabang' ORDER BY b.nama_barang ASC")->result();
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data = [
      "judul"     => "Transaksi",
      "user"      => $user,
      "barang"    => $barang,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "jum_anggota" => $this->db->query("SELECT * FROM user WHERE id_user IN (SELECT id_user FROM akses_cabang WHERE id_cabang = '$data_cabang->id_cabang') AND id_role = 2")->num_rows(),
    ];
    $this->template->load('Template/Home', 'Penjualan/Transaksi', $data);
  }

  public function isi($key = '')
  {
    $cabang = $this->session->userdata("cabang");
    $barang = $this->db->query("SELECT b.*, b.disc, (SELECT nama_satuan FROM satuan WHERE kode_satuan = b.satuan) as satuan, nama_kategori FROM barang b JOIN kategori USING (kode_kategori) WHERE b.kode_cabang = '$cabang' AND nama_barang LIKE '%$key%' OR satuan LIKE '%$key%' OR kode_barang LIKE '%$key%' OR kategori.nama_kategori LIKE '%$key%' ORDER BY b.nama_barang ASC")->result(); ?>
    <?php foreach ($barang as $b) : ?>
      <div class="col-lg-3 col-6 text-center mb-3">
        <div class="card shadow mb-3 h-100" onclick="detail('<?= $b->kode_barang; ?>')">
          <?php if ((int)$b->disc > 0) {
            $border = 'border-danger';
          } else {
            $border = '';
          } ?>
          <img src="<?= site_url('assets/img/barang/') . $b->gambar; ?>" class="img-thumbnail img-fluid <?= $border; ?>" alt="Gambar">
          <div class="card-body">
            <div class="row h-50">
              <div class="col-sm-12 text-left">
                <span title="<?= $b->nama_barang; ?>" class="h5 font-weight-bold"><?= mb_strimwidth($b->nama_barang, 0, 22, "..."); ?></span>
              </div>
            </div>
            <div class="row" style="margin-top: -10px;">
              <div class="col-sm-12 text-left">
                <span style="font-size: 10px;">Kategori : <?= $b->nama_kategori; ?></span>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 text-left" style="margin-bottom: 5px;;">
                <span class="font-weight-bold badge badge-warning" style="font-size: 18px; width: 100%">Rp. <?= number_format($b->harga_jual); ?></span>
              </div>
              <?php if ((int)$b->disc > 0) : ?>
                <div class="col-sm-6 text-left">
                  <span class="font-weight-bold badge badge-danger" style="font-size: 18px; width: 100%">Disc <?= number_format(((int)$b->disc / ((int)$b->harga_jual + (int)$b->disc)) * 100) . ' %'; ?></span>
                </div>
              <?php else : ?>
                <div class="col-sm-6"></div>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-12 text-left">
                <?php
                $terjual = $this->db->query("SELECT SUM(qty) as qty FROM order_pesanan WHERE kode_barang = '$b->kode_barang' AND status_order = 0")->row();
                if ($terjual) {
                  if ($terjual->qty > 0) {
                    $terjual = number_format($terjual->qty);
                  } else {
                    $terjual = number_format(0);
                  }
                } else {
                  $terjual = number_format(0);
                }
                ?>
                <span><i class="fa-solid fa-star"></i> 0 | Terjual <?= $terjual ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php
  }

  public function detail($kode)
  {
    $cabang         = $this->session->userdata("cabang");
    $data_cabang    = $this->db->query("SELECT * FROM cabang WHERE kode_cabang = '$cabang'")->row();
    $barang         = $this->db->query("SELECT b.*, b.disc, (SELECT nama_satuan FROM satuan WHERE kode_satuan = b.satuan) as satuan, nama_kategori, nama_satuan FROM barang b JOIN kategori USING (kode_kategori) JOIN satuan ON (kode_satuan = satuan) WHERE b.kode_cabang = '$cabang' AND b.kode_barang = '$kode'")->row();
    $user           = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data_jum       = $this->db->query("SELECT qty FROM order_pesanan WHERE kode_barang = '$barang->kode_barang' ORDER BY id ASC LIMIT 5")->result_array();
    $data = [
      "judul"       => "Detail Barang " . strtoupper($barang->nama_barang),
      "user"        => $user,
      "barang"      => $barang,
      "loop"        => $data_jum,
      "pesan"       => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"    => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"       => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
      "jum_anggota" => $this->db->query("SELECT * FROM user WHERE id_user IN (SELECT id_user FROM akses_cabang WHERE id_cabang = '$data_cabang->id_cabang') AND id_role = 2")->num_rows(),
    ];
    $this->template->load('Template/Home', 'Penjualan/Detail', $data);
  }

  public function harga_baru()
  {
    $satuan = $this->input->get("satuan");
    $kode_barang = $this->input->get("kode_barang");
    $takaran = $this->input->get("takaran");

    $barang = $this->db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang'")->row();
    $harga_jual = $barang->harga_jual;
    $qty = 1;
    $data = [
      'harga_baru' => ($harga_jual * $qty),
    ];
    echo json_encode($data);
  }

  public function isi_detail($key = '')
  {
    $cabang = $this->session->userdata("cabang");
    $selain = $this->input->get("selain");
    $barang = $this->db->query("SELECT b.*, b.disc, (SELECT nama_satuan FROM satuan WHERE kode_satuan = b.satuan) as satuan, nama_kategori FROM barang b JOIN kategori USING (kode_kategori) WHERE b.kode_cabang = '$cabang' AND b.kode_barang != '$selain' AND nama_barang LIKE '%$key%' OR satuan LIKE '%$key%' OR kode_barang LIKE '%$key%' OR kategori.nama_kategori LIKE '%$key%' ORDER BY b.nama_barang ASC")->result(); ?>
    <?php foreach ($barang as $b) : ?>
      <div class="col-lg-3 col-6 text-center mb-3">
        <div class="card shadow mb-3 h-100" onclick="detail('<?= $b->kode_barang; ?>')">
          <?php if ((int)$b->disc > 0) {
            $border = 'border-danger';
          } else {
            $border = '';
          } ?>
          <img src="<?= site_url('assets/img/barang/') . $b->gambar; ?>" class="img-thumbnail img-fluid <?= $border; ?>" alt="Gambar">
          <div class="card-body">
            <div class="row h-50">
              <div class="col-sm-12 text-left">
                <span title="<?= $b->nama_barang; ?>" class="h5 font-weight-bold"><?= mb_strimwidth($b->nama_barang, 0, 22, "..."); ?></span>
              </div>
            </div>
            <div class="row" style="margin-top: -10px;">
              <div class="col-sm-12 text-left">
                <span style="font-size: 10px;">Kategori : <?= $b->nama_kategori; ?></span>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6 text-left" style="margin-bottom: 5px;;">
                <span class="font-weight-bold badge badge-warning" style="font-size: 18px; width: 100%">Rp. <?= number_format($b->harga_jual); ?></span>
              </div>
              <?php if ((int)$b->disc > 0) : ?>
                <div class="col-sm-6 text-left">
                  <span class="font-weight-bold badge badge-danger" style="font-size: 18px; width: 100%">Disc <?= number_format(((int)$b->disc / ((int)$b->harga_jual + (int)$b->disc)) * 100) . ' %'; ?></span>
                </div>
              <?php else : ?>
                <div class="col-sm-6"></div>
              <?php endif; ?>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-12 text-left">
                <?php
                $terjual = $this->db->query("SELECT SUM(qty) as qty FROM order_pesanan WHERE kode_barang = '$b->kode_barang' AND status_order = 0")->row();
                if ($terjual) {
                  if ($terjual->qty > 0) {
                    $terjual = number_format($terjual->qty);
                  } else {
                    $terjual = number_format(0);
                  }
                } else {
                  $terjual = number_format(0);
                }
                ?>
                <span><i class="fa-solid fa-star"></i> 0 | Terjual <?= $terjual ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
<?php
  }

  public function pesan_barang($qty)
  {
    $cabang       = $this->session->userdata("cabang");
    $kode_order   = $this->M_core->kode_order($cabang);
    $kode_barang  = $this->input->post("selain");
    $status_antar = $this->input->get("status_antar");
    if ($status_antar > 1) {
      $biaya_tambahan = 2000;
    } else {
      $biaya_tambahan = 0;
    }
    $data = [
      'kode_cabang'     => $cabang,
      'kode_order'      => $kode_order,
      'username'        => $this->session->userdata("username"),
      'kode_barang'     => $kode_barang,
      'qty'             => $qty,
      'status_order'    => 0,
      'tgl_order'       => date("Y-m-d"),
      'jam_order'       => date("H:i:s"),
      'status_antar'    => $status_antar,
      'biaya_tambahan'  => $biaya_tambahan,
    ];
    $cek = $this->db->insert("order_pesanan", $data);
    if ($cek) {
      $this->db->query("UPDATE stok SET keluar = keluar + " . (int)$qty . ", saldo_akhir = saldo_akhir - " . (int)$qty . " WHERE kode_barang = '$kode_barang' AND kode_cabang = '$cabang'");
      $this->db->query("UPDATE barang SET saldo_awal = saldo_awal - " . (int)$qty . " WHERE kode_barang = '$kode_barang' AND kode_cabang = '$cabang'");
      $barang = $this->db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang' AND kode_cabang = '$cabang'")->row();
      $aktifitas = [
        'username' => $this->session->userdata("username"),
        'kegiatan' => "Melakukan Order Barang " . $barang->nama_barang . ", Dengan Kode " . $kode_barang,
        'menu' => "Penjualan",
      ];
      $this->db->insert("activity_user", $aktifitas);
      echo json_encode(["status" => 1]);
    } else {
      echo json_encode(["status" => 0]);
    }
  }
}
