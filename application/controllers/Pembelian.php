<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    setlocale(LC_ALL, 'id_ID.utf8');
    date_default_timezone_set('Asia/Jakarta');
    $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $menu = $this->db->get_where("menu", ["url" => "Pembelian"])->row();
    $cek_akses = $this->db->get_where("akses_menu", ["id_role" => $user->id_role, "id_menu" => $menu->id])->num_rows();
    if ($cek_akses < 1) {
      redirect("Home");
    }
    $this->load->model("M_po");
    $this->load->model("M_terima");
    $this->load->model("M_retur");
  }

  public function po()
  {
    $cabang = $this->session->userdata("cabang");
    $user   = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data   = [
      "judul"     => "PO (Pre Order)",
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Pembelian/Po', $data);
  }

  public function po_list($param)
  {
    $cabang   = $this->session->userdata("cabang");
    $dat      = explode("~", $param);
    if ($dat[0] == 1) {
      $bulan = date("n");
      $tahun = date("Y");
      $list  = $this->M_po->get_datatables(1, $bulan, $tahun, $cabang);
    } else {
      $bulan  = date('Y-m-d', strtotime($dat[1]));
      $tahun  = date('Y-m-d', strtotime($dat[2]));
      $list   = $this->M_po->get_datatables(2, $bulan, $tahun, $cabang);
    }
    $data     = [];
    $no       = 1;
    foreach ($list as $rd) {
      $row    = [];
      $row[]  = $no;
      $row[]  = $rd->invoice;
      $row[]  = $rd->nama_supplier;
      $row[]  = $rd->nama_gudang;
      $nama   = $this->db->query("SELECT * FROM user WHERE username = '$rd->pengaju'")->row()->nama;
      $row[]  = $rd->tgl_pembelian;
      $row[]  = $rd->jam_pembelian;
      $row[]  = $nama;
      $row[]  = "<div>Rp <span class='float-right'>" . number_format($rd->total) . "</span></div>";
      $cek    = $this->db->query("SELECT * FROM pembelian_h WHERE invoice_po = '$rd->invoice'")->num_rows();
      if ($cek > 0) {
        $row[] = '<div class="text-center">
          <button style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-warning" title="Ubah" disabled>
            <i class="fa-solid fa-eye-low-vision"></i>
          </button>
          <button style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus" disabled>
            <i class="fa-solid fa-ban"></i>
          </button>
          <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-secondary" target="_blank" href="' . base_url("Pembelian/po_cetak/" . $rd->invoice . "") . '" title="Cetak" >
            <i class="fa-solid fa-fill-drip"></i>
          </a>
        </div>';
      } else {
        $row[] = '<div class="text-center">
          <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-warning" href="' . base_url("Pembelian/po_edit/" . $rd->id . "") . '" title="Ubah">
            <i class="fa-solid fa-eye-low-vision"></i>
          </a>
          <a style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $rd->id . "'" . ",'" . $rd->invoice . "'" . ')">
            <i class="fa-solid fa-ban"></i>
          </a>
          <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-secondary" target="_blank" href="' . base_url("Pembelian/po_cetak/" . $rd->invoice . "") . '" title="Cetak" >
            <i class="fa-solid fa-fill-drip"></i>
          </a>
        </div>';
      }
      $data[] = $row;
      $no++;
    }
    $output = [
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->M_po->count_all($dat[0], $bulan, $tahun, $cabang),
      "recordsFiltered" => $this->M_po->count_filtered($dat[0], $bulan, $tahun, $cabang),
      "data"            => $data,
    ];
    echo json_encode($output);
  }

  public function po_entri()
  {
    $cabang = $this->session->userdata("cabang");
    $user   = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data   = [
      "judul"     => "Tambah Data PO (Pre Order)",
      "cabang"    => $cabang,
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Pembelian/Po_entri', $data);
  }

  public function po_edit($id)
  {
    $cabang   = $this->session->userdata("cabang");
    $user     = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $header   = $this->db->get_where("po_h", ["id" => $id])->row();
    $detail   = $this->db->get_where("po_d", ["invoice" => $header->invoice]);
    $data     = [
      "judul"     => "Ubah Data PO (Pre Order)",
      "cabang"    => $cabang,
      "user"      => $user,
      "header"    => $header,
      "detail"    => $detail->result(),
      "jumdata"   => $detail->num_rows(),
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Pembelian/Po_edit', $data);
  }

  public function simpan($par)
  {
    $tgl_pembelian    = $this->input->post("tgl_pembelian");
    $cabang           = $this->session->userdata("cabang");
    if ($par == 1) {
      $invoice = $this->M_core->inv_po($cabang, $tgl_pembelian);
    } else {
      $invoice = $this->input->post("invoice");
    }
    $kode_supplier    = $this->input->post("kode_supplier");
    $kode_gudang      = $this->input->post("kode_gudang");
    $jam_pembelian    = $this->input->post("jam_pembelian");
    $pengaju          = $this->session->userdata("username");
    $pajak            = $this->input->post("cek_ppn");
    if ($pajak == 1) {
      $ppn = $this->input->post("id_ppn");
    } else {
      $ppn = "0";
    }
    $sub_total    = str_replace(",", "", $this->input->post("sub_total"));
    $sub_diskon   = str_replace(",", "", $this->input->post("diskon"));
    $ppn_rp       = str_replace(",", "", $this->input->post("ppn_rp"));
    $total        = str_replace(",", "", $this->input->post("total_semua"));
    // header
    if ($par == 1) {
      $data = [
        "invoice"       => $invoice,
        "kode_cabang"   => $cabang,
        "kode_supplier" => $kode_supplier,
        "kode_gudang"   => $kode_gudang,
        "tgl_pembelian" => $tgl_pembelian,
        "jam_pembelian" => $jam_pembelian,
        "pengaju"       => $pengaju,
        "pajak"         => $pajak,
        "ppn"           => $ppn,
        "sub_total"     => $sub_total,
        "sub_diskon"    => $sub_diskon,
        "ppn_rp"        => $ppn_rp,
        "total"         => $total,
      ];
    } else {
      $data = [
        "invoice"       => $invoice,
        "kode_cabang"   => $cabang,
        "kode_supplier" => $kode_supplier,
        "kode_gudang"   => $kode_gudang,
        "tgl_pembelian" => $tgl_pembelian,
        "jam_pembelian" => $jam_pembelian,
        "pengaju"       => $pengaju,
        "pajak"         => $pajak,
        "ppn"           => $ppn,
        "sub_total"     => $sub_total,
        "sub_diskon"    => $sub_diskon,
        "ppn_rp"        => $ppn_rp,
        "total"         => $total,
        "alasan"        => $this->input->post("alasan"),
      ];
    }
    if ($par == 2) {
      $aktifitas = [
        'username'  => $this->session->userdata("username"),
        'kegiatan'  => "Mengubah Data PO pada Invoice " . $invoice . ", Dengan alasan : " . $this->input->post("alasan"),
        'menu'      => "Pembelian Barang PO",
      ];
      $this->db->insert("activity_user", $aktifitas);
      $this->db->query("DELETE FROM po_d WHERE invoice = '$invoice'");
      $this->db->query("DELETE FROM po_h WHERE invoice = '$invoice'");
    } else {
      $aktifitas = [
        'username'  => $this->session->userdata("username"),
        'kegiatan'  => "Menambahkan Data PO, Dengan Invoice " . $invoice,
        'menu'      => "Pembelian Barang PO",
      ];
      $this->db->insert("activity_user", $aktifitas);
    }
    $cek = $this->db->insert("po_h", $data);
    // detail
    $kode_barang    = $this->input->post("kode_barang");
    $nama_barang    = $this->input->post("nama_barang");
    $kode_satuan    = $this->input->post("kode_satuan");
    $tgl_expire     = $this->input->post("tgl_expire");
    $qty_barang     = $this->input->post("qty_barang");
    $harga_barang   = $this->input->post("harga_barang");
    $discpr_barang  = $this->input->post("discpr_barang");
    $discrp_barang  = $this->input->post("discrp_barang");
    $total_barang   = $this->input->post("total_barang");
    $jum_detail     = count($kode_barang);
    for ($i = 0; $i <= ($jum_detail - 1); $i++) {
      $_kode_barang   = $kode_barang[$i];
      $_nama_barang   = $nama_barang[$i];
      $_kode_satuan   = $kode_satuan[$i];
      $_tgl_expire    = date("Y-m-d", strtotime($tgl_expire[$i]));
      $_qty_barang    = str_replace(",", "", $qty_barang[$i]);
      $_harga_barang  = str_replace(",", "", $harga_barang[$i]);
      $_discpr_barang = str_replace(",", "", $discpr_barang[$i]);
      $_discrp_barang = str_replace(",", "", $discrp_barang[$i]);
      $_total_barang  = str_replace(",", "", $total_barang[$i]);
      $data_d = [
        "invoice"     => $invoice,
        "kode_barang" => $_kode_barang,
        "nama"        => $_nama_barang,
        "satuan"      => $_kode_satuan,
        "tgl_expire"  => $_tgl_expire,
        "qty"         => $_qty_barang,
        "harga"       => $_harga_barang,
        "disc_pr"     => $_discpr_barang,
        "disc_rp"     => $_discrp_barang,
        "total"       => $_total_barang,
      ];
      if ($cek) {
        $this->db->insert("po_d", $data_d);
      }
    }
    echo json_encode(["status" => 1, "invoice" => $invoice]);
  }

  public function hapus_po($id)
  {
    $po = $this->db->get_where("po_h", ["id" => $id])->row()->invoice;
    $aktifitas = [
      'username'  => $this->session->userdata("username"),
      'kegiatan'  => "Menghapus Data PO, Dengan Invoice " . $po,
      'menu'      => "Pembelian Barang PO",
    ];
    $this->db->insert("activity_user", $aktifitas);
    $this->db->query("DELETE FROM po_d WHERE invoice = '$po'");
    $this->db->query("DELETE FROM po_h WHERE id = '$id'");
    echo json_encode(["status" => 1]);
  }

  public function po_cetak($invoice)
  {
    $cekpdf   = 1;
    $body     = "";
    $position = "P";
    $judul    = "Invoice : " . $invoice;

    $header   = $this->db->query("SELECT * FROM po_h WHERE invoice = '$invoice'")->row();
    $detail   = $this->db->query("SELECT d.* FROM po_d d WHERE d.invoice = '$invoice'")->result();

    $pengaju  = $this->db->get_where("user", ["username" => $header->pengaju])->row()->nama;
    $supplier = $this->db->get_where("supplier", ["kode_supplier" => $header->kode_supplier])->row()->nama_supplier;
    $ppn      = number_format($header->ppn_rp);
    $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
      <tr>
        <td style=\"padding: 5px; width: 13%;\">Invoice</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">$invoice</td>
        <td style=\"padding: 5px; width: 13%;\">Nama</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">$pengaju</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 13%;\">Tgl PO</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">" . date("d-m-Y", strtotime($header->tgl_pembelian)) . "</td>
        <td style=\"padding: 5px; width: 13%;\">Jam PO</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">" . date("H:i:s", strtotime($header->jam_pembelian)) . "</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 13%;\">Supplier</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">$supplier</td>
        <td style=\"padding: 5px; width: 13%;\">PPN</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">$ppn</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 13%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 2%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 35%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 13%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 2%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 35%;\">&nbsp;</td>
      </tr>
    </table>";

    $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"1\">";
    $body .= "<tr class=\"text-center\">
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">No</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Kode Barang</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Nama Barang</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Harga Satuan</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Qty</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Diskon</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Sub Total</th>
    </tr>";
    $no       = 1;
    $qty      = 0;
    $disc_rp  = 0;
    $total    = 0;
    foreach ($detail as $d) {
      $qty        += $d->qty;
      $disc_rp    += $d->disc_rp;
      $total      += $d->total;
      $body .= "<tr>
        <td style=\"padding: 5px; text-align: right;\">$no</td>
        <td style=\"padding: 5px;\">$d->kode_barang</td>
        <td style=\"padding: 5px;\">$d->nama</td>
        <td style=\"padding: 5px; text-align: right;\">" . number_format($d->harga) . "</td>
        <td style=\"padding: 5px; text-align: right;\">" . number_format($d->qty) . "</td>
        <td style=\"padding: 5px; text-align: right;\">" . number_format($d->disc_rp) . "</td>
        <td style=\"padding: 5px; text-align: right;\">" . number_format($d->total) . "</td>
      </tr>";
      $no++;
    }
    $body .= "<tr>
      <td style=\"background-color: #007bff; color: white; padding: 5px; text-align: center;\" colspan=\"4\">Total</td>
      <td style=\"padding: 5px; text-align: right;\">" . number_format($qty) . "</td>
      <td style=\"padding: 5px; text-align: right;\">" . number_format($disc_rp) . "</td>
      <td style=\"padding: 5px; text-align: right;\">" . number_format($total) . "</td>
    </tr>";
    $body .= "</table>";

    $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
      <tr>
        <td style=\"padding: 5px; width: 70%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 70%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 70%;\"></td>
        <td style=\"padding: 5px; width: 30%; text-align: center;\">Penanggung Jawab</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 70%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 30%; text-align: center;\">
          <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
        </td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 70%;\"></td>
        <td style=\"padding: 5px; width: 30%; text-align: center;\">($pengaju)</td>
      </tr>
    </table>";

    $this->M_temcetak->template($judul, $body, $position, $date = date("d-m-Y"), $cekpdf);
  }

  // ===================================================================== PENERIMAAN BARANG

  public function terima()
  {
    $cabang = $this->session->userdata("cabang");
    $user   = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data   = [
      "judul"     => "Penerimaan Barang",
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Pembelian/Penerimaan', $data);
  }

  public function terima_list($param)
  {
    $cabang   = $this->session->userdata("cabang");
    $dat      = explode("~", $param);
    if ($dat[0] == 1) {
      $bulan    = date("n");
      $tahun    = date("Y");
      $list     = $this->M_terima->get_datatables(1, $bulan, $tahun, $cabang);
    } else {
      $bulan    = date('Y-m-d', strtotime($dat[1]));
      $tahun    = date('Y-m-d', strtotime($dat[2]));
      $list     = $this->M_terima->get_datatables(2, $bulan, $tahun, $cabang);
    }
    $data     = [];
    $no       = 1;
    foreach ($list as $rd) {
      $row    = [];
      $row[]  = $no;
      $row[]  = $rd->invoice;
      $row[]  = $rd->nama_supplier;
      $row[]  = $rd->nama_gudang;
      $nama   = $this->db->query("SELECT * FROM user WHERE username = '$rd->penerima'")->row()->nama;
      $row[]  = $rd->tgl_terima;
      $row[]  = $rd->jam_terima;
      $row[]  = $nama;
      $row[]  = "<div>Rp <span class='float-right'>" . number_format($rd->total) . "</span></div>";
      if ($rd->acc > 0) {
        $cekretur       = $this->db->get_where("retur_beli_h", ["invoice_terima" => $rd->invoice])->num_rows();
        if ($cekretur > 0) {
          $row[] = '<div class="text-center">
            <button style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-warning" disabled title="Edit">
              <i class="fa-solid fa-eye-low-vision"></i>
            </button>
            <button style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus" disabled>
              <i class="fa-solid fa-ban"></i>
            </button>
            <button style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-primary" title="Un-acc" disabled>
              <i class="fa-regular fa-circle-xmark"></i>
            </button>
            <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-secondary" target="_blank" href="' . base_url("Pembelian/terima_cetak/" . $rd->invoice . "") . '" title="Cetak" >
              <i class="fa-solid fa-fill-drip"></i>
            </a>
          </div>';
        } else {
          $row[] = '<div class="text-center">
            <button style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-warning" disabled title="Edit">
              <i class="fa-solid fa-eye-low-vision"></i>
            </button>
            <button style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus" disabled>
              <i class="fa-solid fa-ban"></i>
            </button>
            <a style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-primary" href="javascript:void(0)" title="Un-acc" onclick="unacc(' . "'" . $rd->id . "'" . ",'" . $rd->invoice . "'" . ')">
              <i class="fa-regular fa-circle-xmark"></i>
            </a>
            <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-secondary" target="_blank" href="' . base_url("Pembelian/terima_cetak/" . $rd->invoice . "") . '" title="Cetak" >
              <i class="fa-solid fa-fill-drip"></i>
            </a>
          </div>';
        }
      } else {
        $row[] = '<div class="text-center">
          <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-warning" href="' . base_url("Pembelian/penerimaan_edit/" . $rd->id . "") . '" title="Edit">
            <i class="fa-solid fa-eye-low-vision"></i>
          </a>
          <a style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $rd->id . "'" . ",'" . $rd->invoice . "'" . ')">
            <i class="fa-solid fa-ban"></i>
          </a>
          <a style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-info" href="javascript:void(0)" title="Acc" onclick="acc(' . "'" . $rd->id . "'" . ",'" . $rd->invoice . "'" . ')">
            <i class="fa-solid fa-check"></i>
          </a>
          <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-secondary" target="_blank" href="' . base_url("Pembelian/terima_cetak/" . $rd->invoice . "") . '" title="Cetak" >
            <i class="fa-solid fa-fill-drip"></i>
          </a>
        </div>';
      }
      $data[] = $row;
      $no++;
    }
    $output = [
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->M_terima->count_all($dat[0], $bulan, $tahun, $cabang),
      "recordsFiltered" => $this->M_terima->count_filtered($dat[0], $bulan, $tahun, $cabang),
      "data"            => $data,
    ];
    echo json_encode($output);
  }

  public function penerimaan_entri()
  {
    $cabang = $this->session->userdata("cabang");
    $user   = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data   = [
      "judul"     => "Penerimaan Data Barang",
      "cabang"    => $cabang,
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Pembelian/Penerimaan_entri', $data);
  }

  public function penerimaan_edit($id)
  {
    $cabang = $this->session->userdata("cabang");
    $user   = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $header = $this->db->get_where("pembelian_h", ["id" => $id])->row();
    $detail = $this->db->get_where("pembelian_d", ["invoice" => $header->invoice]);
    $data   = [
      "judul"     => "Ubah Data Penerimaan",
      "cabang"    => $cabang,
      "user"      => $user,
      "header"    => $header,
      "detail"    => $detail->result(),
      "jumdata"   => $detail->num_rows(),
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Pembelian/Penerimaan_edit', $data);
  }

  public function ambil_data_po($invoice)
  {
    $header = $this->db->query("SELECT h.*, s.nama_supplier, g.nama_gudang, IF(p.nama_ppn IS NULL, 'Tanpa PPN', p.nama_ppn) AS nama_ppn FROM po_h h JOIN supplier s ON h.kode_supplier = s.kode_supplier JOIN gudang g ON h.kode_gudang = g.kode_gudang LEFT JOIN ppn p ON p.id_ppn = h.ppn WHERE h.invoice = '$invoice'")->row();
    echo json_encode($header);
  }

  public function ambil_detail_po($invoice)
  {
    $detail = $this->db->query("SELECT d.*, s.kode_satuan, b.nama_barang, b.harga_beli, s.nama_satuan, concat(b.nama_barang, ' | ', s.nama_satuan, ' | ', b.harga_beli) AS text FROM po_d d JOIN satuan s ON d.satuan = s.kode_satuan JOIN barang b ON d.kode_barang = b.kode_barang WHERE d.invoice = '$invoice'")->result();
    echo json_encode($detail);
  }

  public function simpan_terima($par)
  {
    $tgl_terima   = $this->input->post("tgl_terima");
    $invoice_po   = $this->input->post("kode_po");
    $cabang       = $this->session->userdata("cabang");
    if ($par == 1) {
      $invoice = $this->M_core->inv_terima($cabang, $tgl_terima);
    } else {
      $invoice = $this->input->post("invoice");
    }
    $kode_supplier    = $this->input->post("kode_supplier");
    $kode_gudang      = $this->input->post("kode_gudang");
    $jam_terima       = $this->input->post("jam_terima");
    $penerima         = $this->session->userdata("username");
    $pajak            = $this->input->post("cek_ppn");
    if ($pajak == 1) {
      $ppn = $this->input->post("id_ppn");
    } else {
      $ppn = "0";
    }
    $sub_total    = str_replace(",", "", $this->input->post("sub_total"));
    $sub_diskon   = str_replace(",", "", $this->input->post("diskon"));
    $ppn_rp       = str_replace(",", "", $this->input->post("ppn_rp"));
    $total        = str_replace(",", "", $this->input->post("total_semua"));
    // header
    if ($par == 1) {
      $data = [
        "invoice"       => $invoice,
        "invoice_po"    => $invoice_po,
        "kode_cabang"   => $cabang,
        "kode_supplier" => $kode_supplier,
        "kode_gudang"   => $kode_gudang,
        "tgl_terima"    => $tgl_terima,
        "jam_terima"    => $jam_terima,
        "penerima"      => $penerima,
        "pajak"         => $pajak,
        "ppn"           => $ppn,
        "sub_total"     => $sub_total,
        "sub_diskon"    => $sub_diskon,
        "ppn_rp"        => $ppn_rp,
        "total"         => $total,
      ];
    } else {
      $data = [
        "invoice"       => $invoice,
        "invoice_po"    => $invoice_po,
        "kode_cabang"   => $cabang,
        "kode_supplier" => $kode_supplier,
        "kode_gudang"   => $kode_gudang,
        "tgl_terima"    => $tgl_terima,
        "jam_terima"    => $jam_terima,
        "penerima"      => $penerima,
        "pajak"         => $pajak,
        "ppn"           => $ppn,
        "sub_total"     => $sub_total,
        "sub_diskon"    => $sub_diskon,
        "ppn_rp"        => $ppn_rp,
        "total"         => $total,
        "alasan"        => $this->input->post("alasan"),
      ];
    }
    if ($par == 2) {
      $aktifitas = [
        'username'  => $this->session->userdata("username"),
        'kegiatan'  => "Mengubah Data Terima pada Invoice " . $invoice . ", Dengan alasan : " . $this->input->post("alasan"),
        'menu'      => "Pembelian Barang Terima",
      ];
      $this->db->insert("activity_user", $aktifitas);
      $this->db->query("DELETE FROM pembelian_d WHERE invoice = '$invoice'");
      $this->db->query("DELETE FROM pembelian_h WHERE invoice = '$invoice'");
    } else {
      $aktifitas = [
        'username'  => $this->session->userdata("username"),
        'kegiatan'  => "Menambahkan Data Terima, Dengan Invoice " . $invoice,
        'menu'      => "Pembelian Barang Terima",
      ];
      $this->db->insert("activity_user", $aktifitas);
    }
    $cek = $this->db->insert("pembelian_h", $data);
    // detail
    $kode_barang    = $this->input->post("kode_barang");
    $nama_barang    = $this->input->post("nama_barang");
    $kode_satuan    = $this->input->post("kode_satuan");
    $tgl_expire     = $this->input->post("tgl_expire");
    $qty_barang     = $this->input->post("qty_barang");
    $qty_barang     = $this->input->post("qty_barang");
    $harga_barang   = $this->input->post("harga_barang");
    $harga_barang   = $this->input->post("harga_barang");
    $discpr_barang  = $this->input->post("discpr_barang");
    $discrp_barang  = $this->input->post("discrp_barang");
    $total_barang   = $this->input->post("total_barang");
    $jum_detail     = count($kode_barang);
    for ($i = 0; $i <= ($jum_detail - 1); $i++) {
      $_kode_barang   = $kode_barang[$i];
      $_nama_barang   = $nama_barang[$i];
      $_kode_satuan   = $kode_satuan[$i];
      $_tgl_expire    = $tgl_expire[$i];
      $_qty_barang    = str_replace(",", "", $qty_barang[$i]);
      $_harga_barang  = str_replace(",", "", $harga_barang[$i]);
      $_discpr_barang = str_replace(",", "", $discpr_barang[$i]);
      $_discrp_barang = str_replace(",", "", $discrp_barang[$i]);
      $_total_barang  = str_replace(",", "", $total_barang[$i]);
      $data_d = [
        "invoice"     => $invoice,
        "kode_barang" => $_kode_barang,
        "nama"        => $_nama_barang,
        "satuan"      => $_kode_satuan,
        "tgl_expire"  => $_tgl_expire,
        "qty"         => $_qty_barang,
        "harga"       => $_harga_barang,
        "disc_pr"     => $_discpr_barang,
        "disc_rp"     => $_discrp_barang,
        "total"       => $_total_barang,
      ];
      if ($cek) {
        $this->db->insert("pembelian_d", $data_d);
      }
    }
    echo json_encode(["status" => 1, "invoice" => $invoice]);
  }

  public function hapus_terima($id)
  {
    $terima     = $this->db->get_where("pembelian_h", ["id" => $id])->row()->invoice;
    $aktifitas  = [
      'username'  => $this->session->userdata("username"),
      'kegiatan'  => "Menghapus Data Terima, Dengan Invoice " . $terima,
      'menu'      => "Pembelian Barang Terima",
    ];
    $this->db->insert("activity_user", $aktifitas);
    $this->db->query("DELETE FROM pembelian_d WHERE invoice = '$terima'");
    $this->db->query("DELETE FROM pembelian_h WHERE id = '$id'");
    echo json_encode(["status" => 1]);
  }

  public function acc_terima($id)
  {
    $accer    = $this->session->userdata("username");
    $cabang   = $this->session->userdata("cabang");
    $hterima  = $this->db->get_where("pembelian_h", ["id" => $id])->row();
    $dterima  = $this->db->get_where("pembelian_d", ["invoice" => $hterima->invoice])->result();
    foreach ($dterima as $dt) {
      $cek_stok = $this->db->get_where("stok", ["kode_cabang" => $cabang, "kode_gudang" => $hterima->kode_gudang, "kode_barang" => $dt->kode_barang, "tgl_expire" => $dt->tgl_expire])->num_rows();
      if ($cek_stok > 0) {
        $this->db->query("UPDATE stok SET terima = terima + $dt->qty, saldo_akhir = saldo_akhir + $dt->qty WHERE kode_barang = '$dt->kode_barang' AND kode_gudang = '$hterima->kode_gudang' AND kode_cabang = '$cabang' AND tgl_expire = '$dt->tgl_expire'");
      } else {
        $data = [
          'kode_barang' => $dt->kode_barang,
          'kode_gudang' => $hterima->kode_gudang,
          'kode_cabang' => $cabang,
          'tgl_expire'  => $dt->tgl_expire,
          'terima'      => $dt->qty,
          'saldo_akhir' => $dt->qty,
        ];
        $this->db->insert("stok", $data);
      }
    }
    $this->db->query("UPDATE pembelian_h SET accer = '$accer', acc = 1 WHERE id = '$id'");
    echo json_encode(["status" => 1]);
  }

  public function unacc_terima($id)
  {
    $accer    = $this->session->userdata("username");
    $cabang   = $this->session->userdata("cabang");
    $hterima  = $this->db->get_where("pembelian_h", ["id" => $id])->row();
    $dterima  = $this->db->get_where("pembelian_d", ["invoice" => $hterima->invoice])->result();
    foreach ($dterima as $dt) {
      $cek_stok = $this->db->get_where("stok", ["kode_cabang" => $cabang, "kode_gudang" => $hterima->kode_gudang, "kode_barang" => $dt->kode_barang, "tgl_expire" => $dt->tgl_expire])->num_rows();
      if ($cek_stok > 0) {
        $this->db->query("UPDATE stok SET terima = terima - $dt->qty, saldo_akhir = saldo_akhir - $dt->qty WHERE kode_barang = '$dt->kode_barang' AND kode_gudang = '$hterima->kode_gudang' AND kode_cabang = '$cabang' AND tgl_expire = '$dt->tgl_expire'");
      } else {
        $data = [
          'kode_barang' => $dt->kode_barang,
          'kode_gudang' => $hterima->kode_gudang,
          'kode_cabang' => $cabang,
          'tgl_expire'  => $dt->tgl_expire,
          'terima'      => 0 - $dt->qty,
          'saldo_akhir' => 0 - $dt->qty,
        ];
        $this->db->insert("stok", $data);
      }
    }
    $this->db->query("UPDATE pembelian_h SET accer = '', acc = 0 WHERE id = '$id'");
    echo json_encode(["status" => 1]);
  }

  public function terima_cetak($invoice)
  {
    $cekpdf   = 1;
    $body     = "";
    $position = "P";
    $judul    = "Invoice : " . $invoice;

    $header   = $this->db->query("SELECT * FROM pembelian_h WHERE invoice = '$invoice'")->row();
    $detail   = $this->db->query("SELECT d.* FROM pembelian_d d WHERE d.invoice = '$invoice'")->result();

    $penerima = $this->db->get_where("user", ["username" => $header->penerima])->row()->nama;
    $supplier = $this->db->get_where("supplier", ["kode_supplier" => $header->kode_supplier])->row()->nama_supplier;
    $ppn      = number_format($header->ppn_rp);
    $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
      <tr>
        <td style=\"padding: 5px; width: 13%;\">Invoice</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">$invoice</td>
        <td style=\"padding: 5px; width: 13%;\">Nama</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">$penerima</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 13%;\">Tgl Terima</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">" . date("d-m-Y", strtotime($header->tgl_terima)) . "</td>
        <td style=\"padding: 5px; width: 13%;\">Jam Terima</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">" . date("H:i:s", strtotime($header->jam_terima)) . "</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 13%;\">Supplier</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">$supplier</td>
        <td style=\"padding: 5px; width: 13%;\">PPN</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">$ppn</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 13%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 2%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 35%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 13%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 2%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 35%;\">&nbsp;</td>
      </tr>
    </table>";

    $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"1\">";
    $body .= "<tr class=\"text-center\">
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">No</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Kode Barang</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Nama Barang</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Harga Satuan</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Qty</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Diskon</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Sub Total</th>
    </tr>";
    $no       = 1;
    $qty      = 0;
    $disc_rp  = 0;
    $total    = 0;
    foreach ($detail as $d) {
      $qty        += $d->qty;
      $disc_rp    += $d->disc_rp;
      $total      += $d->total;
      $body .= "<tr>
        <td style=\"padding: 5px; text-align: right;\">$no</td>
        <td style=\"padding: 5px;\">$d->kode_barang</td>
        <td style=\"padding: 5px;\">$d->nama</td>
        <td style=\"padding: 5px; text-align: right;\">" . number_format($d->harga) . "</td>
        <td style=\"padding: 5px; text-align: right;\">" . number_format($d->qty) . "</td>
        <td style=\"padding: 5px; text-align: right;\">" . number_format($d->disc_rp) . "</td>
        <td style=\"padding: 5px; text-align: right;\">" . number_format($d->total) . "</td>
      </tr>";
      $no++;
    }
    $body .= "<tr>
      <td style=\"background-color: #007bff; color: white; padding: 5px; text-align: center;\" colspan=\"4\">Total</td>
      <td style=\"padding: 5px; text-align: right;\">" . number_format($qty) . "</td>
      <td style=\"padding: 5px; text-align: right;\">" . number_format($disc_rp) . "</td>
      <td style=\"padding: 5px; text-align: right;\">" . number_format($total) . "</td>
    </tr>";
    $body .= "</table>";

    $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
      <tr>
        <td style=\"padding: 5px; width: 70%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 70%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 70%;\"></td>
        <td style=\"padding: 5px; width: 30%; text-align: center;\">Penanggung Jawab</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 70%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 30%; text-align: center;\">
          <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
        </td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 70%;\"></td>
        <td style=\"padding: 5px; width: 30%; text-align: center;\">($penerima)</td>
      </tr>
    </table>";

    $this->M_temcetak->template($judul, $body, $position, $date = date("d-m-Y"), $cekpdf);
  }

  // ===================================================================== RETUR BARANG

  public function retur()
  {
    $cabang = $this->session->userdata("cabang");
    $user   = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data   = [
      "judul"     => "Retur Penerimaan",
      "cabang"    => $cabang,
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Pembelian/Retur', $data);
  }

  public function retur_list($param)
  {
    $cabang   = $this->session->userdata("cabang");
    $dat      = explode("~", $param);
    if ($dat[0] == 1) {
      $bulan    = date("n");
      $tahun    = date("Y");
      $list     = $this->M_retur->get_datatables(1, $bulan, $tahun, $cabang);
    } else {
      $bulan    = date('Y-m-d', strtotime($dat[1]));
      $tahun    = date('Y-m-d', strtotime($dat[2]));
      $list     = $this->M_retur->get_datatables(2, $bulan, $tahun, $cabang);
    }
    $data     = [];
    $no       = 1;
    foreach ($list as $rd) {
      $row    = [];
      $row[]  = $no;
      $row[]  = $rd->invoice;
      $row[]  = $rd->nama_supplier;
      $row[]  = $rd->nama_gudang;
      $nama   = $this->db->query("SELECT * FROM user WHERE username = '$rd->peretur'")->row()->nama;
      $row[]  = $rd->tgl_retur;
      $row[]  = $rd->jam_retur;
      $row[]  = $nama;
      $row[]  = "<div>Rp <span class='float-right'>" . number_format($rd->total) . "</span></div>";
      if ($rd->acc > 0) {
        $row[] = '<div class="text-center" style="gap 1em;">
          <button style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-warning" disabled title="Edit">
            <i class="fa-solid fa-eye-low-vision"></i>
          </button>
          <button style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus" disabled>
            <i class="fa-solid fa-ban"></i>
          </button>
          <a style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-primary" href="javascript:void(0)" title="Un-acc" onclick="unacc(' . "'" . $rd->id . "'" . ",'" . $rd->invoice . "'" . ')">
            <i class="fa-regular fa-circle-xmark"></i>
          </a>
          <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-secondary" target="_blank" href="' . base_url("Pembelian/retur_cetak/" . $rd->invoice . "") . '" title="Cetak" >
            <i class="fa-solid fa-fill-drip"></i>
          </a>
        </div>';
      } else {
        $row[] = '<div class="text-center" style="gap: 1em;">
          <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-warning" href="' . base_url("Pembelian/retur_edit/" . $rd->id . "") . '" title="Edit">
            <i class="fa-solid fa-eye-low-vision"></i>
          </a>
          <a style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $rd->id . "'" . ",'" . $rd->invoice . "'" . ')">
            <i class="fa-solid fa-ban"></i>
          </a>
          <a style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-info" href="javascript:void(0)" title="Acc" onclick="acc(' . "'" . $rd->id . "'" . ",'" . $rd->invoice . "'" . ')">
            <i class="fa-solid fa-check"></i>
          </a>
          <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-secondary" target="_blank" href="' . base_url("Pembelian/retur_cetak/" . $rd->invoice . "") . '" title="Cetak" >
            <i class="fa-solid fa-fill-drip"></i>
          </a>
        </div>';
      }
      $data[] = $row;
      $no++;
    }
    $output = [
      "draw"            => $_POST['draw'],
      "recordsTotal"    => $this->M_retur->count_all($dat[0], $bulan, $tahun, $cabang),
      "recordsFiltered" => $this->M_retur->count_filtered($dat[0], $bulan, $tahun, $cabang),
      "data"            => $data,
    ];
    echo json_encode($output);
  }

  public function retur_entri()
  {
    $cabang = $this->session->userdata("cabang");
    $user   = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data   = [
      "judul"     => "Retur Penerimaan Data Barang",
      "cabang"    => $cabang,
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Pembelian/Retur_entri', $data);
  }

  public function retur_edit($id)
  {
    $cabang   = $this->session->userdata("cabang");
    $user     = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $header   = $this->db->get_where("retur_beli_h", ["id" => $id])->row();
    $detail   = $this->db->get_where("retur_beli_d", ["invoice" => $header->invoice]);
    $data = [
      "judul"     => "Ubah Data Retur Penerimaan",
      "cabang"    => $cabang,
      "user"      => $user,
      "header"    => $header,
      "detail"    => $detail->result(),
      "jumdata"   => $detail->num_rows(),
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Pembelian/Retur_edit', $data);
  }

  public function ambil_data_terima($invoice)
  {
    $header = $this->db->query("SELECT h.*, s.nama_supplier, g.nama_gudang, IF(p.nama_ppn IS NULL, 'Tanpa PPN', p.nama_ppn) AS nama_ppn FROM pembelian_h h JOIN supplier s ON h.kode_supplier = s.kode_supplier JOIN gudang g ON h.kode_gudang = g.kode_gudang LEFT JOIN ppn p ON p.id_ppn = h.ppn WHERE h.invoice = '$invoice'")->row();
    echo json_encode($header);
  }

  public function ambil_detail_terima($invoice)
  {
    $detail = $this->db->query("SELECT d.*, s.kode_satuan, b.nama_barang, b.harga_beli, s.nama_satuan, concat(b.nama_barang, ' | ', s.nama_satuan, ' | ', b.harga_beli) AS text FROM pembelian_d d JOIN satuan s ON d.satuan = s.kode_satuan JOIN barang b ON d.kode_barang = b.kode_barang WHERE d.invoice = '$invoice'")->result();
    echo json_encode($detail);
  }

  public function simpan_retur($par)
  {
    $tgl_retur        = $this->input->post("tgl_retur");
    $invoice_terima   = $this->input->post("kode_terima");
    $cabang           = $this->session->userdata("cabang");
    if ($par == 1) {
      $invoice = $this->M_core->inv_retur($cabang, $tgl_retur);
    } else {
      $invoice = $this->input->post("invoice");
    }
    $kode_supplier    = $this->input->post("kode_supplier");
    $kode_gudang      = $this->input->post("kode_gudang");
    $jam_retur        = $this->input->post("jam_retur");
    $peretur          = $this->session->userdata("username");
    $pajak            = $this->input->post("cek_ppn");
    if ($pajak == 1) {
      $ppn = $this->input->post("id_ppn");
    } else {
      $ppn = "0";
    }
    $sub_total    = str_replace(",", "", $this->input->post("sub_total"));
    $sub_diskon   = str_replace(",", "", $this->input->post("diskon"));
    $ppn_rp       = str_replace(",", "", $this->input->post("ppn_rp"));
    $total        = str_replace(",", "", $this->input->post("total_semua"));
    // header
    if ($par == 1) {
      $data = [
        "invoice"         => $invoice,
        "invoice_terima"  => $invoice_terima,
        "kode_cabang"     => $cabang,
        "kode_supplier"   => $kode_supplier,
        "kode_gudang"     => $kode_gudang,
        "tgl_retur"       => $tgl_retur,
        "jam_retur"       => $jam_retur,
        "peretur"         => $peretur,
        "pajak"           => $pajak,
        "ppn"             => $ppn,
        "sub_total"       => $sub_total,
        "sub_diskon"      => $sub_diskon,
        "ppn_rp"          => $ppn_rp,
        "total"           => $total,
      ];
    } else {
      $data = [
        "invoice"         => $invoice,
        "invoice_terima"  => $invoice_terima,
        "kode_cabang"     => $cabang,
        "kode_supplier"   => $kode_supplier,
        "kode_gudang"     => $kode_gudang,
        "tgl_retur"       => $tgl_retur,
        "jam_retur"       => $jam_retur,
        "peretur"         => $peretur,
        "pajak"           => $pajak,
        "ppn"             => $ppn,
        "sub_total"       => $sub_total,
        "sub_diskon"      => $sub_diskon,
        "ppn_rp"          => $ppn_rp,
        "total"           => $total,
        "alasan"          => $this->input->post("alasan"),
      ];
    }
    if ($par == 2) {
      $aktifitas = [
        'username'  => $this->session->userdata("username"),
        'kegiatan'  => "Mengubah Data Retur Penerimaan pada Invoice " . $invoice . ", Dengan alasan : " . $this->input->post("alasan"),
        'menu'      => "Retur Pembelian",
      ];
      $this->db->insert("activity_user", $aktifitas);
      $this->db->query("DELETE FROM retur_beli_d WHERE invoice = '$invoice'");
      $this->db->query("DELETE FROM retur_beli_h WHERE invoice = '$invoice'");
    } else {
      $aktifitas = [
        'username'  => $this->session->userdata("username"),
        'kegiatan'  => "Menambahkan Data Retur Penerimaan, Dengan Invoice " . $invoice,
        'menu'      => "Retur Pembelian",
      ];
      $this->db->insert("activity_user", $aktifitas);
    }
    $cek = $this->db->insert("retur_beli_h", $data);
    // detail
    $kode_barang    = $this->input->post("kode_barang");
    $nama_barang    = $this->input->post("nama_barang");
    $kode_satuan    = $this->input->post("kode_satuan");
    $tgl_expire     = $this->input->post("tgl_expire");
    $qty_barang     = $this->input->post("qty_barang");
    $qty_barang     = $this->input->post("qty_barang");
    $harga_barang   = $this->input->post("harga_barang");
    $harga_barang   = $this->input->post("harga_barang");
    $discpr_barang  = $this->input->post("discpr_barang");
    $discrp_barang  = $this->input->post("discrp_barang");
    $total_barang   = $this->input->post("total_barang");
    $jum_detail     = count($kode_barang);
    for ($i = 0; $i <= ($jum_detail - 1); $i++) {
      $_kode_barang   = $kode_barang[$i];
      $_nama_barang   = $nama_barang[$i];
      $_kode_satuan   = $kode_satuan[$i];
      $_tgl_expire    = $tgl_expire[$i];
      $_qty_barang    = str_replace(",", "", $qty_barang[$i]);
      $_harga_barang  = str_replace(",", "", $harga_barang[$i]);
      $_discpr_barang = str_replace(",", "", $discpr_barang[$i]);
      $_discrp_barang = str_replace(",", "", $discrp_barang[$i]);
      $_total_barang  = str_replace(",", "", $total_barang[$i]);
      $data_d = [
        "invoice"     => $invoice,
        "kode_barang" => $_kode_barang,
        "nama"        => $_nama_barang,
        "satuan"      => $_kode_satuan,
        "tgl_expire"  => $_tgl_expire,
        "qty"         => $_qty_barang,
        "harga"       => $_harga_barang,
        "disc_pr"     => $_discpr_barang,
        "disc_rp"     => $_discrp_barang,
        "total"       => $_total_barang,
      ];
      if ($cek) {
        $this->db->insert("retur_beli_d", $data_d);
      }
    }
    echo json_encode(["status" => 1, "invoice" => $invoice]);
  }

  public function hapus_retur($id)
  {
    $retur = $this->db->get_where("retur_beli_h", ["id" => $id])->row()->invoice;
    $aktifitas = [
      'username'  => $this->session->userdata("username"),
      'kegiatan'  => "Menghapus Data Retur, Dengan Invoice " . $retur,
      'menu'      => "Retur Penerimaan Barang",
    ];
    $this->db->insert("activity_user", $aktifitas);
    $this->db->query("DELETE FROM retur_beli_d WHERE invoice = '$retur'");
    $this->db->query("DELETE FROM retur_beli_h WHERE id = '$id'");
    echo json_encode(["status" => 1]);
  }

  public function acc_retur($id)
  {
    $accer    = $this->session->userdata("username");
    $cabang   = $this->session->userdata("cabang");
    $hterima  = $this->db->get_where("retur_beli_h", ["id" => $id])->row();
    $dterima  = $this->db->get_where("retur_beli_d", ["invoice" => $hterima->invoice])->result();
    foreach ($dterima as $dt) {
      $cek_stok = $this->db->get_where("stok", ["kode_cabang" => $cabang, "kode_gudang" => $hterima->kode_gudang, "kode_barang" => $dt->kode_barang, "tgl_expire" => $dt->tgl_expire])->num_rows();
      if ($cek_stok > 0) {
        $this->db->query("UPDATE stok SET keluar = keluar + $dt->qty, saldo_akhir = saldo_akhir - $dt->qty WHERE kode_barang = '$dt->kode_barang' AND kode_gudang = '$hterima->kode_gudang' AND kode_cabang = '$cabang' AND tgl_expire = '$dt->tgl_expire'");
      } else {
        $data = [
          'kode_barang' => $dt->kode_barang,
          'kode_gudang' => $hterima->kode_gudang,
          'kode_cabang' => $cabang,
          'tgl_expire'  => $dt->tgl_expire,
          'keluar'      => $dt->qty,
          'saldo_akhir' => $dt->qty,
        ];
        $this->db->insert("stok", $data);
      }
    }
    $this->db->query("UPDATE retur_beli_h SET accer = '$accer', acc = 1 WHERE id = '$id'");
    echo json_encode(["status" => 1]);
  }

  public function unacc_retur($id)
  {
    $accer    = $this->session->userdata("username");
    $cabang   = $this->session->userdata("cabang");
    $hterima  = $this->db->get_where("retur_beli_h", ["id" => $id])->row();
    $dterima  = $this->db->get_where("retur_beli_d", ["invoice" => $hterima->invoice])->result();
    foreach ($dterima as $dt) {
      $cek_stok = $this->db->get_where("stok", ["kode_cabang" => $cabang, "kode_gudang" => $hterima->kode_gudang, "kode_barang" => $dt->kode_barang, "tgl_expire" => $dt->tgl_expire])->num_rows();
      if ($cek_stok > 0) {
        $this->db->query("UPDATE stok SET keluar = keluar - $dt->qty, saldo_akhir = saldo_akhir + $dt->qty WHERE kode_barang = '$dt->kode_barang' AND kode_gudang = '$hterima->kode_gudang' AND kode_cabang = '$cabang' AND tgl_expire = '$dt->tgl_expire'");
      } else {
        $data = [
          'kode_barang' => $dt->kode_barang,
          'kode_gudang' => $hterima->kode_gudang,
          'kode_cabang' => $cabang,
          'tgl_expire'  => $dt->tgl_expire,
          'keluar'      => 0 - $dt->qty,
          'saldo_akhir' => 0 - $dt->qty,
        ];
        $this->db->insert("stok", $data);
      }
    }
    $this->db->query("UPDATE retur_beli_h SET accer = '', acc = 0 WHERE id = '$id'");
    echo json_encode(["status" => 1]);
  }

  public function retur_cetak($invoice)
  {
    $cekpdf   = 1;
    $body     = "";
    $position = "P";
    $judul    = "Invoice : " . $invoice;

    $header   = $this->db->query("SELECT * FROM retur_beli_h WHERE invoice = '$invoice'")->row();
    $detail   = $this->db->query("SELECT d.* FROM retur_beli_d d WHERE d.invoice = '$invoice'")->result();

    $peretur  = $this->db->get_where("user", ["username" => $header->peretur])->row()->nama;
    $supplier = $this->db->get_where("supplier", ["kode_supplier" => $header->kode_supplier])->row()->nama_supplier;
    $ppn      = number_format($header->ppn_rp);
    $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
      <tr>
        <td style=\"padding: 5px; width: 13%;\">Invoice</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">$invoice</td>
        <td style=\"padding: 5px; width: 13%;\">Nama</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">$peretur</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 13%;\">Tgl Retur</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">" . date("d-m-Y", strtotime($header->tgl_retur)) . "</td>
        <td style=\"padding: 5px; width: 13%;\">Jam Retur</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">" . date("H:i:s", strtotime($header->jam_retur)) . "</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 13%;\">Supplier</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">$supplier</td>
        <td style=\"padding: 5px; width: 13%;\">PPN</td>
        <td style=\"padding: 5px; width: 2%;\"> : </td>
        <td style=\"padding: 5px; width: 35%;\">$ppn</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 13%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 2%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 35%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 13%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 2%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 35%;\">&nbsp;</td>
      </tr>
    </table>";

    $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"1\">";
    $body .= "<tr class=\"text-center\">
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">No</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Kode Barang</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Nama Barang</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Harga Satuan</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Qty</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Diskon</th>
      <th style=\"background-color: #007bff; color: white; padding: 5px;\">Sub Total</th>
    </tr>";
    $no       = 1;
    $qty      = 0;
    $disc_rp  = 0;
    $total    = 0;
    foreach ($detail as $d) {
      $qty        += $d->qty;
      $disc_rp    += $d->disc_rp;
      $total      += $d->total;
      $body .= "<tr>
        <td style=\"padding: 5px; text-align: right;\">$no</td>
        <td style=\"padding: 5px;\">$d->kode_barang</td>
        <td style=\"padding: 5px;\">$d->nama</td>
        <td style=\"padding: 5px; text-align: right;\">" . number_format($d->harga) . "</td>
        <td style=\"padding: 5px; text-align: right;\">" . number_format($d->qty) . "</td>
        <td style=\"padding: 5px; text-align: right;\">" . number_format($d->disc_rp) . "</td>
        <td style=\"padding: 5px; text-align: right;\">" . number_format($d->total) . "</td>
      </tr>";
      $no++;
    }
    $body .= "<tr>
      <td style=\"background-color: #007bff; color: white; padding: 5px; text-align: center;\" colspan=\"4\">Total</td>
      <td style=\"padding: 5px; text-align: right;\">" . number_format($qty) . "</td>
      <td style=\"padding: 5px; text-align: right;\">" . number_format($disc_rp) . "</td>
      <td style=\"padding: 5px; text-align: right;\">" . number_format($total) . "</td>
    </tr>";
    $body .= "</table>";

    $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
      <tr>
        <td style=\"padding: 5px; width: 70%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 70%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 70%;\"></td>
        <td style=\"padding: 5px; width: 30%; text-align: center;\">Penanggung Jawab</td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 70%;\">&nbsp;</td>
        <td style=\"padding: 5px; width: 30%; text-align: center;\">
          <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
        </td>
      </tr>
      <tr>
        <td style=\"padding: 5px; width: 70%;\"></td>
        <td style=\"padding: 5px; width: 30%; text-align: center;\">($peretur)</td>
      </tr>
    </table>";

    $this->M_temcetak->template($judul, $body, $position, $date = date("d-m-Y"), $cekpdf);
  }

  // ===================================================================== LAPORAN

  public function laporan()
  {
    $cabang = $this->session->userdata("cabang");
    $user   = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
    $data   = [
      "judul"     => "Laporan Pembelian",
      "cabang"    => $cabang,
      "user"      => $user,
      "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
      "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
      "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
    ];
    $this->template->load('Template/Home', 'Pembelian/Laporan', $data);
  }

  public function laporan_pembelian($cekpdf)
  {
    $cabang           = $this->session->userdata("cabang");
    $pencetak         = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row()->nama;
    $penanggungjawab  = $this->db->get_where("cabang", ["kode_cabang" => $this->session->userdata("cabang")])->row()->penanggungjawab;

    $dari             = date("Y-m-d", strtotime($this->input->get("dari")));
    $sampai           = date("Y-m-d", strtotime($this->input->get("sampai")));
    $kode_supplier    = $this->input->get("kode_supplier");
    $kode_gudang      = $this->input->get("kode_gudang");
    $laporan          = $this->input->get("laporan");

    $body             = "";
    $position         = "P";

    if ($laporan == 1) {
      $judul = "1) Laporan PO Cabang: " . $cabang;

      if (($kode_gudang == "" || $kode_gudang == null  || $kode_gudang == "null") && ($kode_supplier == "" || $kode_supplier == null || $kode_supplier == "null")) {
        $header = $this->db->query("SELECT * FROM po_h WHERE kode_cabang = '$cabang' AND tgl_pembelian >= '$dari' AND tgl_pembelian <= '$sampai'")->result();
      } else if (($kode_gudang == "" || $kode_gudang == null  || $kode_gudang == "null") && ($kode_supplier != "" || $kode_supplier != null || $kode_supplier != "null")) {
        $header = $this->db->query("SELECT * FROM po_h WHERE kode_cabang = '$cabang' AND kode_supplier = '$kode_supplier' AND tgl_pembelian >= '$dari' AND tgl_pembelian <= '$sampai'")->result();
      } else if (($kode_gudang != "" || $kode_gudang != null || $kode_gudang != "null") && ($kode_supplier == "" || $kode_supplier == null || $kode_supplier == "null")) {
        $header = $this->db->query("SELECT * FROM po_h WHERE kode_cabang = '$cabang' AND kode_gudang = '$kode_gudang' AND tgl_pembelian >= '$dari' AND tgl_pembelian <= '$sampai'")->result();
      } else {
        $header = $this->db->query("SELECT * FROM po_h WHERE kode_cabang = '$cabang' AND kode_gudang = '$kode_gudang' AND kode_supplier = '$kode_supplier' AND tgl_pembelian >= '$dari' AND tgl_pembelian <= '$sampai'")->result();
      }

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
        <tr>
          <td style=\"padding: 5px; color: #007bff; font-weight: bold;\">$judul</td>
        </tr>
        <tr>
          <td style=\"padding: 5px;\">&nbsp;</td>
        </tr>
      </table>";

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"1\">
      <tr class=\"text-center\">
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">No</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Invoice PO</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Supplier</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Gudang</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Subtotal</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Diskon</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">PPN</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Total</th>
      </tr>";

      if ($header) {
        $no               = 1;
        $sub_total_all    = 0;
        $sub_diskon_all   = 0;
        $ppn_rp_all       = 0;
        $total_all        = 0;
        foreach ($header as $h) {
          $supplier         = $this->db->get_where("supplier", ["kode_supplier" => $h->kode_supplier])->row();
          $gudang           = $this->db->get_where("gudang", ["kode_gudang" => $h->kode_gudang])->row();

          $sub_total_all    += $h->sub_total;
          $sub_diskon_all   += $h->sub_diskon;
          $ppn_rp_all       += $h->ppn_rp;
          $total_all        += $h->total;

          if ($cekpdf == 1) {
            $sub_total        = number_format($h->sub_total);
            $sub_diskon       = number_format($h->sub_diskon);
            $ppn_rp           = number_format($h->ppn_rp);
            $total            = number_format($h->total);

            $sub_total_allx   = number_format($sub_total_all);
            $sub_diskon_allx  = number_format($sub_diskon_all);
            $ppn_rp_allx      = number_format($ppn_rp_all);
            $total_allx       = number_format($total_all);
          } else {
            $sub_total        = ceil($h->sub_total);
            $sub_diskon       = ceil($h->sub_diskon);
            $ppn_rp           = ceil($h->ppn_rp);
            $total            = ceil($h->total);

            $sub_total_allx   = ceil($sub_total_all);
            $sub_diskon_allx  = ceil($sub_diskon_all);
            $ppn_rp_allx      = ceil($ppn_rp_all);
            $total_allx       = ceil($total_all);
          }
          $body .= "<tr>
            <td style=\"padding: 5px;\">$no</td>
            <td style=\"padding: 5px;\">$h->invoice</td>
            <td style=\"padding: 5px;\">$supplier->nama_supplier</td>
            <td style=\"padding: 5px;\">$gudang->nama_gudang</td>
            <td style=\"padding: 5px; text-align: right;\">$sub_total</td>
            <td style=\"padding: 5px; text-align: right;\">$sub_diskon</td>
            <td style=\"padding: 5px; text-align: right;\">$ppn_rp</td>
            <td style=\"padding: 5px; text-align: right;\">$total</td>
          </tr>";
          $no++;
        }
        $body .= "</table><br>";

        $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\">";
        $body .= "<tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Sub Total Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$sub_total_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Diskon Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$sub_diskon_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">PPN Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$ppn_rp_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; color: red; font-weight: bold; text-align: right;\">Total Keseluruhan : </th>
          <td style=\"padding: 5px; color: red; font-weight: bold; text-align: right;\">$total_allx</th>
        </tr>";
        $body .= "</table>";
      } else {
        $body .= "<tr>
          <td style=\"padding: 5px; text-align: center; color: red; font-weight: bold;\" colspan=\"8\">Tidak Ada Data</td>
        </tr>";
        $body .= "</table><br>";
      }

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">Penanggung Jawab</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">Pencetak</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">
            <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
          </td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">
            <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
          </td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\"></td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">($penanggungjawab)</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">($pencetak)</td>
        </tr>
      </table>";
    } else if ($laporan == 2) {
      $judul = "2) Laporan PO Detail Cabang: " . $cabang;

      if (($kode_gudang == "" || $kode_gudang == null  || $kode_gudang == "null") && ($kode_supplier == "" || $kode_supplier == null || $kode_supplier == "null")) {
        $header = $this->db->query("SELECT * FROM po_h WHERE kode_cabang = '$cabang' AND tgl_pembelian >= '$dari' AND tgl_pembelian <= '$sampai'")->result();
      } else if (($kode_gudang == "" || $kode_gudang == null  || $kode_gudang == "null") && ($kode_supplier != "" || $kode_supplier != null || $kode_supplier != "null")) {
        $header = $this->db->query("SELECT * FROM po_h WHERE kode_cabang = '$cabang' AND kode_supplier = '$kode_supplier' AND tgl_pembelian >= '$dari' AND tgl_pembelian <= '$sampai'")->result();
      } else if (($kode_gudang != "" || $kode_gudang != null || $kode_gudang != "null") && ($kode_supplier == "" || $kode_supplier == null || $kode_supplier == "null")) {
        $header = $this->db->query("SELECT * FROM po_h WHERE kode_cabang = '$cabang' AND kode_gudang = '$kode_gudang' AND tgl_pembelian >= '$dari' AND tgl_pembelian <= '$sampai'")->result();
      } else {
        $header = $this->db->query("SELECT * FROM po_h WHERE kode_cabang = '$cabang' AND kode_gudang = '$kode_gudang' AND kode_supplier = '$kode_supplier' AND tgl_pembelian >= '$dari' AND tgl_pembelian <= '$sampai'")->result();
      }

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
        <tr>
          <td style=\"padding: 5px; color: #007bff; font-weight: bold;\">$judul</td>
        </tr>
        <tr>
          <td style=\"padding: 5px;\">&nbsp;</td>
        </tr>
      </table>";

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"1\">";

      $body .= "<tr class=\"text-center\">
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">No</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Kode</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Nama</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Satuan</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Expire</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Qty</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Harga</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Diskon</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Total</th>
      </tr>";

      if ($header) {
        $no               = 1;
        $qtyh_all         = 0;
        $hargah_all       = 0;
        $diskon_all       = 0;
        $totalh_all       = 0;
        foreach ($header as $h) {
          $detail   = $this->db->query("SELECT d.* FROM po_d d WHERE d.invoice = '$h->invoice'")->result();
          $supplier = $this->db->get_where("supplier", ["kode_supplier" => $h->kode_supplier])->row();
          $gudang   = $this->db->get_where("gudang", ["kode_gudang" => $h->kode_gudang])->row();

          $body .= "<tr>
            <td style=\"background-color: grey; color: white; padding: 5px;\" colspan=\"3\">$supplier->nama_supplier - Gudang: $gudang->nama_gudang</td>
            <td style=\"background-color: grey; color: white; padding: 5px;\" colspan=\"6\">$h->invoice</td>
          </tr>";

          $qty_all        = 0;
          $harga_all      = 0;
          $disc_rp_all    = 0;
          $total_all      = 0;

          foreach ($detail as $d) {
            $satuan = $this->db->get_where("satuan", ["kode_satuan" => $d->satuan])->row();
            if ($satuan) {
              $satuan = $satuan->nama_satuan;
            } else {
              $satuan = "Belum Ada";
            }

            $qty_all        += $d->qty;
            $harga_all      += $d->harga;
            $disc_rp_all    += $d->disc_rp;
            $total_all      += $d->total;
            if ($cekpdf == 1) {
              $qty            = number_format($d->qty);
              $harga          = number_format($d->harga);
              $disc_rp        = number_format($d->disc_rp);
              $total          = number_format($d->total);

              $qty_allx       = number_format($qty_all);
              $harga_allx     = number_format($harga_all);
              $disc_rp_allx   = number_format($disc_rp_all);
              $total_allx     = number_format($total_all);
            } else {
              $qty            = ceil($d->qty);
              $harga          = ceil($d->harga);
              $disc_rp        = ceil($d->disc_rp);
              $total          = ceil($d->total);

              $qty_allx       = ceil($qty_all);
              $harga_allx     = ceil($harga_all);
              $disc_rp_allx   = ceil($disc_rp_all);
              $total_allx     = ceil($total_all);
            }
            $body .= "<tr class=\"text-center\">
              <td style=\"padding: 5px; text-align: right;\">$no</td>
              <td style=\"padding: 5px;\">$d->kode_barang</td>
              <td style=\"padding: 5px;\">$d->nama</td>
              <td style=\"padding: 5px;\">$satuan</td>
              <td style=\"padding: 5px;\">" . date("d-m-Y", strtotime($d->tgl_expire)) . "</td>
              <td style=\"padding: 5px; text-align: right;\">$qty</td>
              <td style=\"padding: 5px; text-align: right;\">$harga</td>
              <td style=\"padding: 5px; text-align: right;\">$disc_rp</td>
              <td style=\"padding: 5px; text-align: right;\">$total</td>
            </tr>";
            $no++;
          }
          $body .= "<tr class=\"text-center\">
            <td style=\"background-color: #007bff; color: white; padding: 5px;\" colspan=\"5\">Total Per-PO</td>
            <td style=\"padding: 5px; text-align: right;\">$qty_allx</td>
            <td style=\"padding: 5px; text-align: right;\">$harga_allx</td>
            <td style=\"padding: 5px; text-align: right;\">$disc_rp_allx</td>
            <td style=\"padding: 5px; text-align: right;\">$total_allx</td>
          </tr>";

          $qtyh_all         += $qty_all;
          $hargah_all       += $harga_all;
          $diskon_all       += $disc_rp_all;
          $totalh_all       += $total_all;

          if ($cekpdf == 1) {
            $qtyh_allx   = number_format($qtyh_all);
            $hargah_allx = number_format($hargah_all);
            $diskon_allx = number_format($diskon_all);
            $totalh_allx = number_format($totalh_all);
          } else {
            $qtyh_allx   = ceil($qtyh_all);
            $hargah_allx = ceil($hargah_all);
            $diskon_allx = ceil($diskon_all);
            $totalh_allx = ceil($totalh_all);
          }
        }
      } else {
        $body .= "<tr>
          <td style=\"padding: 5px; text-align: center; color: red; font-weight: bold;\" colspan=\"9\">Tidak Ada Data</td>
        </tr>";

        $qtyh_allx   = 0;
        $hargah_allx = 0;
        $diskon_allx = 0;
        $totalh_allx = 0;
      }

      $body .= "</table><br>";

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\">";
      $body .= "<tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Qty Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$qtyh_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Harga Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$hargah_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Diskon Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$diskon_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; color: red; font-weight: bold; text-align: right;\">Total Keseluruhan : </th>
          <td style=\"padding: 5px; color: red; font-weight: bold; text-align: right;\">$totalh_allx</th>
        </tr>";
      $body .= "</table>";

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">Penanggung Jawab</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">Pencetak</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">
            <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
          </td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">
            <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
          </td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\"></td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">($penanggungjawab)</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">($pencetak)</td>
        </tr>
      </table>";
    } else if ($laporan == 3) {
      $judul = "3) Laporan Penerimaan Cabang: " . $cabang;

      if (($kode_gudang == "" || $kode_gudang == null  || $kode_gudang == "null") && ($kode_supplier == "" || $kode_supplier == null || $kode_supplier == "null")) {
        $header = $this->db->query("SELECT * FROM pembelian_h WHERE kode_cabang = '$cabang' AND tgl_terima >= '$dari' AND tgl_terima <= '$sampai'")->result();
      } else if (($kode_gudang == "" || $kode_gudang == null  || $kode_gudang == "null") && ($kode_supplier != "" || $kode_supplier != null || $kode_supplier != "null")) {
        $header = $this->db->query("SELECT * FROM pembelian_h WHERE kode_cabang = '$cabang' AND kode_supplier = '$kode_supplier' AND tgl_terima >= '$dari' AND tgl_terima <= '$sampai'")->result();
      } else if (($kode_gudang != "" || $kode_gudang != null || $kode_gudang != "null") && ($kode_supplier == "" || $kode_supplier == null || $kode_supplier == "null")) {
        $header = $this->db->query("SELECT * FROM pembelian_h WHERE kode_gudang = '$kode_gudang' AND kode_supplier = '$kode_supplier' AND tgl_terima >= '$dari' AND tgl_terima <= '$sampai'")->result();
      } else {
        $header = $this->db->query("SELECT * FROM pembelian_h WHERE kode_cabang = '$cabang' AND kode_gudang = '$kode_gudang' AND kode_supplier = '$kode_supplier' AND tgl_terima >= '$dari' AND tgl_terima <= '$sampai'")->result();
      }

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
        <tr>
          <td style=\"padding: 5px; color: #007bff; font-weight: bold;\">$judul</td>
        </tr>
        <tr>
          <td style=\"padding: 5px;\">&nbsp;</td>
        </tr>
      </table>";

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"1\">
      <tr class=\"text-center\">
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">No</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Invoice PO</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Supplier</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Gudang</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Subtotal</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Diskon</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">PPN</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Total</th>
      </tr>";

      if ($header) {
        $no               = 1;
        $sub_total_all    = 0;
        $sub_diskon_all   = 0;
        $ppn_rp_all       = 0;
        $total_all        = 0;
        foreach ($header as $h) {
          $supplier         = $this->db->get_where("supplier", ["kode_supplier" => $h->kode_supplier])->row();
          $gudang           = $this->db->get_where("gudang", ["kode_gudang" => $h->kode_gudang])->row();

          $sub_total_all    += $h->sub_total;
          $sub_diskon_all   += $h->sub_diskon;
          $ppn_rp_all       += $h->ppn_rp;
          $total_all        += $h->total;

          if ($cekpdf == 1) {
            $sub_total        = number_format($h->sub_total);
            $sub_diskon       = number_format($h->sub_diskon);
            $ppn_rp           = number_format($h->ppn_rp);
            $total            = number_format($h->total);

            $sub_total_allx   = number_format($sub_total_all);
            $sub_diskon_allx  = number_format($sub_diskon_all);
            $ppn_rp_allx      = number_format($ppn_rp_all);
            $total_allx       = number_format($total_all);
          } else {
            $sub_total        = ceil($h->sub_total);
            $sub_diskon       = ceil($h->sub_diskon);
            $ppn_rp           = ceil($h->ppn_rp);
            $total            = ceil($h->total);

            $sub_total_allx   = ceil($sub_total_all);
            $sub_diskon_allx  = ceil($sub_diskon_all);
            $ppn_rp_allx      = ceil($ppn_rp_all);
            $total_allx       = ceil($total_all);
          }
          $body .= "<tr>
            <td style=\"padding: 5px;\">$no</td>
            <td style=\"padding: 5px;\">$h->invoice</td>
            <td style=\"padding: 5px;\">$supplier->nama_supplier</td>
            <td style=\"padding: 5px;\">$gudang->nama_gudang</td>
            <td style=\"padding: 5px; text-align: right;\">$sub_total</td>
            <td style=\"padding: 5px; text-align: right;\">$sub_diskon</td>
            <td style=\"padding: 5px; text-align: right;\">$ppn_rp</td>
            <td style=\"padding: 5px; text-align: right;\">$total</td>
          </tr>";
          $no++;
        }
        $body .= "</table><br>";

        $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\">";
        $body .= "<tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Sub Total Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$sub_total_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Diskon Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$sub_diskon_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">PPN Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$ppn_rp_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; color: red; font-weight: bold; text-align: right;\">Total Keseluruhan : </th>
          <td style=\"padding: 5px; color: red; font-weight: bold; text-align: right;\">$total_allx</th>
        </tr>";
        $body .= "</table>";
      } else {
        $body .= "<tr>
          <td style=\"padding: 5px; text-align: center; color: red; font-weight: bold;\" colspan=\"8\">Tidak Ada Data</td>
        </tr>";
        $body .= "</table><br>";
      }

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">Penanggung Jawab</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">Pencetak</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">
            <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
          </td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">
            <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
          </td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\"></td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">($penanggungjawab)</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">($pencetak)</td>
        </tr>
      </table>";
    } else if ($laporan == 4) {
      $judul = "4) Laporan Penerimaan Detail Cabang : " . $cabang;

      if (($kode_gudang == "" || $kode_gudang == null  || $kode_gudang == "null") && ($kode_supplier == "" || $kode_supplier == null || $kode_supplier == "null")) {
        $header = $this->db->query("SELECT * FROM pembelian_h WHERE kode_cabang = '$cabang' AND tgl_terima >= '$dari' AND tgl_terima <= '$sampai'")->result();
      } else if (($kode_gudang == "" || $kode_gudang == null  || $kode_gudang == "null") && ($kode_supplier != "" || $kode_supplier != null || $kode_supplier != "null")) {
        $header = $this->db->query("SELECT * FROM pembelian_h WHERE kode_cabang = '$cabang' AND kode_supplier = '$kode_supplier' AND tgl_terima >= '$dari' AND tgl_terima <= '$sampai'")->result();
      } else if (($kode_gudang != "" || $kode_gudang != null || $kode_gudang != "null") && ($kode_supplier == "" || $kode_supplier == null || $kode_supplier == "null")) {
        $header = $this->db->query("SELECT * FROM pembelian_h WHERE kode_cabang = '$cabang' AND kode_gudang = '$kode_gudang' AND tgl_terima >= '$dari' AND tgl_terima <= '$sampai'")->result();
      } else {
        $header = $this->db->query("SELECT * FROM pembelian_h WHERE kode_cabang = '$cabang' AND kode_gudang = '$kode_gudang' AND kode_supplier = '$kode_supplier' AND tgl_terima >= '$dari' AND tgl_terima <= '$sampai'")->result();
      }

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
        <tr>
          <td style=\"padding: 5px; color: #007bff; font-weight: bold;\">$judul</td>
        </tr>
        <tr>
          <td style=\"padding: 5px;\">&nbsp;</td>
        </tr>
      </table>";

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"1\">";

      $body .= "<tr class=\"text-center\">
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">No</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Kode</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Nama</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Satuan</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Expire</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Qty</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Harga</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Diskon</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Total</th>
      </tr>";

      if ($header) {
        $no               = 1;
        $qtyh_all         = 0;
        $hargah_all       = 0;
        $diskon_all       = 0;
        $totalh_all       = 0;
        foreach ($header as $h) {
          $detail   = $this->db->query("SELECT d.* FROM pembelian_d d WHERE d.invoice = '$h->invoice'")->result();
          $supplier = $this->db->get_where("supplier", ["kode_supplier" => $h->kode_supplier])->row();
          $gudang   = $this->db->get_where("gudang", ["kode_gudang" => $h->kode_gudang])->row();

          $body .= "<tr>
            <td style=\"background-color: grey; color: white; padding: 5px;\" colspan=\"3\">$supplier->nama_supplier - Gudang: $gudang->nama_gudang</td>
            <td style=\"background-color: grey; color: white; padding: 5px;\" colspan=\"6\">$h->invoice</td>
          </tr>";

          $qty_all        = 0;
          $harga_all      = 0;
          $disc_rp_all    = 0;
          $total_all      = 0;

          foreach ($detail as $d) {
            $satuan = $this->db->get_where("satuan", ["kode_satuan" => $d->satuan])->row();
            if ($satuan) {
              $satuan = $satuan->nama_satuan;
            } else {
              $satuan = "Belum Ada";
            }

            $qty_all        += $d->qty;
            $harga_all      += $d->harga;
            $disc_rp_all    += $d->disc_rp;
            $total_all      += $d->total;
            if ($cekpdf == 1) {
              $qty            = number_format($d->qty);
              $harga          = number_format($d->harga);
              $disc_rp        = number_format($d->disc_rp);
              $total          = number_format($d->total);

              $qty_allx       = number_format($qty_all);
              $harga_allx     = number_format($harga_all);
              $disc_rp_allx   = number_format($disc_rp_all);
              $total_allx     = number_format($total_all);
            } else {
              $qty            = ceil($d->qty);
              $harga          = ceil($d->harga);
              $disc_rp        = ceil($d->disc_rp);
              $total          = ceil($d->total);

              $qty_allx       = ceil($qty_all);
              $harga_allx     = ceil($harga_all);
              $disc_rp_allx   = ceil($disc_rp_all);
              $total_allx     = ceil($total_all);
            }
            $body .= "<tr class=\"text-center\">
              <td style=\"padding: 5px; text-align: right;\">$no</td>
              <td style=\"padding: 5px;\">$d->kode_barang</td>
              <td style=\"padding: 5px;\">$d->nama</td>
              <td style=\"padding: 5px;\">$satuan</td>
              <td style=\"padding: 5px;\">" . date("d-m-Y", strtotime($d->tgl_expire)) . "</td>
              <td style=\"padding: 5px; text-align: right;\">$qty</td>
              <td style=\"padding: 5px; text-align: right;\">$harga</td>
              <td style=\"padding: 5px; text-align: right;\">$disc_rp</td>
              <td style=\"padding: 5px; text-align: right;\">$total</td>
            </tr>";
            $no++;
          }
          $body .= "<tr class=\"text-center\">
            <td style=\"background-color: #007bff; color: white; padding: 5px;\" colspan=\"5\">Total Per-PO</td>
            <td style=\"padding: 5px; text-align: right;\">$qty_allx</td>
            <td style=\"padding: 5px; text-align: right;\">$harga_allx</td>
            <td style=\"padding: 5px; text-align: right;\">$disc_rp_allx</td>
            <td style=\"padding: 5px; text-align: right;\">$total_allx</td>
          </tr>";

          $qtyh_all         += $qty_all;
          $hargah_all       += $harga_all;
          $diskon_all       += $disc_rp_all;
          $totalh_all       += $total_all;

          if ($cekpdf == 1) {
            $qtyh_allx   = number_format($qtyh_all);
            $hargah_allx = number_format($hargah_all);
            $diskon_allx = number_format($diskon_all);
            $totalh_allx = number_format($totalh_all);
          } else {
            $qtyh_allx   = ceil($qtyh_all);
            $hargah_allx = ceil($hargah_all);
            $diskon_allx = ceil($diskon_all);
            $totalh_allx = ceil($totalh_all);
          }
        }
      } else {
        $body .= "<tr>
          <td style=\"padding: 5px; text-align: center; color: red; font-weight: bold;\" colspan=\"9\">Tidak Ada Data</td>
        </tr>";
        $qtyh_allx   = 0;
        $hargah_allx = 0;
        $diskon_allx = 0;
        $totalh_allx = 0;
      }

      $body .= "</table><br>";

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\">";
      $body .= "<tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Qty Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$qtyh_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Harga Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$hargah_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Diskon Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$diskon_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; color: red; font-weight: bold; text-align: right;\">Total Keseluruhan : </th>
          <td style=\"padding: 5px; color: red; font-weight: bold; text-align: right;\">$totalh_allx</th>
        </tr>";
      $body .= "</table>";

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">Penanggung Jawab</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">Pencetak</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">
            <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
          </td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">
            <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
          </td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\"></td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">($penanggungjawab)</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">($pencetak)</td>
        </tr>
      </table>";
    } else if ($laporan == 5) {
      $judul = "5) Laporan Retur Penerimaan Cabang : " . $cabang;

      if (($kode_gudang == "" || $kode_gudang == null  || $kode_gudang == "null") && ($kode_supplier == "" || $kode_supplier == null || $kode_supplier == "null")) {
        $header = $this->db->query("SELECT * FROM retur_beli_h WHERE kode_cabang = '$cabang' AND tgl_retur >= '$dari' AND tgl_retur <= '$sampai'")->result();
      } else if (($kode_gudang == "" || $kode_gudang == null  || $kode_gudang == "null") && ($kode_supplier != "" || $kode_supplier != null || $kode_supplier != "null")) {
        $header = $this->db->query("SELECT * FROM retur_beli_h WHERE kode_cabang = '$cabang' AND kode_supplier = '$kode_supplier' AND tgl_retur >= '$dari' AND tgl_retur <= '$sampai'")->result();
      } else if (($kode_gudang != "" || $kode_gudang != null || $kode_gudang != "null") && ($kode_supplier == "" || $kode_supplier == null || $kode_supplier == "null")) {
        $header = $this->db->query("SELECT * FROM retur_beli_h WHERE kode_cabang = '$cabang' AND kode_gudang = '$kode_gudang' AND tgl_retur >= '$dari' AND tgl_retur <= '$sampai'")->result();
      } else {
        $header = $this->db->query("SELECT * FROM retur_beli_h WHERE kode_cabang = '$cabang' AND kode_gudang = '$kode_gudang' AND kode_supplier = '$kode_supplier' AND tgl_retur >= '$dari' AND tgl_retur <= '$sampai'")->result();
      }

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
        <tr>
          <td style=\"padding: 5px; color: #007bff; font-weight: bold;\">$judul</td>
        </tr>
        <tr>
          <td style=\"padding: 5px;\">&nbsp;</td>
        </tr>
      </table>";

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"1\">
      <tr class=\"text-center\">
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">No</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Invoice PO</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Supplier</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Gudang</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Subtotal</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Diskon</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">PPN</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Total</th>
      </tr>";

      if ($header) {
        $no               = 1;
        $sub_total_all    = 0;
        $sub_diskon_all   = 0;
        $ppn_rp_all       = 0;
        $total_all        = 0;
        foreach ($header as $h) {
          $supplier         = $this->db->get_where("supplier", ["kode_supplier" => $h->kode_supplier])->row();
          $gudang           = $this->db->get_where("gudang", ["kode_gudang" => $h->kode_gudang])->row();

          $sub_total_all    += $h->sub_total;
          $sub_diskon_all   += $h->sub_diskon;
          $ppn_rp_all       += $h->ppn_rp;
          $total_all        += $h->total;

          if ($cekpdf == 1) {
            $sub_total        = number_format($h->sub_total);
            $sub_diskon       = number_format($h->sub_diskon);
            $ppn_rp           = number_format($h->ppn_rp);
            $total            = number_format($h->total);

            $sub_total_allx   = number_format($sub_total_all);
            $sub_diskon_allx  = number_format($sub_diskon_all);
            $ppn_rp_allx      = number_format($ppn_rp_all);
            $total_allx       = number_format($total_all);
          } else {
            $sub_total        = ceil($h->sub_total);
            $sub_diskon       = ceil($h->sub_diskon);
            $ppn_rp           = ceil($h->ppn_rp);
            $total            = ceil($h->total);

            $sub_total_allx   = ceil($sub_total_all);
            $sub_diskon_allx  = ceil($sub_diskon_all);
            $ppn_rp_allx      = ceil($ppn_rp_all);
            $total_allx       = ceil($total_all);
          }
          $body .= "<tr>
            <td style=\"padding: 5px;\">$no</td>
            <td style=\"padding: 5px;\">$h->invoice</td>
            <td style=\"padding: 5px;\">$supplier->nama_supplier</td>
            <td style=\"padding: 5px;\">$gudang->nama_gudang</td>
            <td style=\"padding: 5px; text-align: right;\">$sub_total</td>
            <td style=\"padding: 5px; text-align: right;\">$sub_diskon</td>
            <td style=\"padding: 5px; text-align: right;\">$ppn_rp</td>
            <td style=\"padding: 5px; text-align: right;\">$total</td>
          </tr>";
          $no++;
        }
        $body .= "</table><br>";

        $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\">";
        $body .= "<tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Sub Total Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$sub_total_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Diskon Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$sub_diskon_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">PPN Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$ppn_rp_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; color: red; font-weight: bold; text-align: right;\">Total Keseluruhan : </th>
          <td style=\"padding: 5px; color: red; font-weight: bold; text-align: right;\">$total_allx</th>
        </tr>";
        $body .= "</table>";
      } else {
        $body .= "<tr>
          <td style=\"padding: 5px; text-align: center; color: red; font-weight: bold;\" colspan=\"8\">Tidak Ada Data</td>
        </tr>";
        $body .= "</table><br>";
      }

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">Penanggung Jawab</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">Pencetak</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">
            <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
          </td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">
            <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
          </td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\"></td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">($penanggungjawab)</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">($pencetak)</td>
        </tr>
      </table>";
    } else {
      $judul = "6) Laporan Retur Penerimaan Detail Cabang : " . $cabang;

      if (($kode_gudang == "" || $kode_gudang == null  || $kode_gudang == "null") && ($kode_supplier == "" || $kode_supplier == null || $kode_supplier == "null")) {
        $header = $this->db->query("SELECT * FROM retur_beli_h WHERE kode_cabang = '$cabang' AND tgl_retur >= '$dari' AND tgl_retur <= '$sampai'")->result();
      } else if (($kode_gudang == "" || $kode_gudang == null  || $kode_gudang == "null") && ($kode_supplier != "" || $kode_supplier != null || $kode_supplier != "null")) {
        $header = $this->db->query("SELECT * FROM retur_beli_h WHERE kode_cabang = '$cabang' AND kode_supplier = '$kode_supplier' AND tgl_retur >= '$dari' AND tgl_retur <= '$sampai'")->result();
      } else if (($kode_gudang != "" || $kode_gudang != null || $kode_gudang != "null") && ($kode_supplier == "" || $kode_supplier == null || $kode_supplier == "null")) {
        $header = $this->db->query("SELECT * FROM retur_beli_h WHERE kode_cabang = '$cabang' AND kode_gudang = '$kode_gudang' AND tgl_retur >= '$dari' AND tgl_retur <= '$sampai'")->result();
      } else {
        $header = $this->db->query("SELECT * FROM retur_beli_h WHERE kode_cabang = '$cabang' AND kode_gudang = '$kode_gudang' AND kode_supplier = '$kode_supplier' AND tgl_retur >= '$dari' AND tgl_retur <= '$sampai'")->result();
      }

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
        <tr>
          <td style=\"padding: 5px; color: #007bff; font-weight: bold;\">$judul</td>
        </tr>
        <tr>
          <td style=\"padding: 5px;\">&nbsp;</td>
        </tr>
      </table>";

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"1\">";

      $body .= "<tr class=\"text-center\">
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">No</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Kode</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Nama</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Satuan</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Expire</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Qty</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Harga</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Diskon</th>
        <th style=\"background-color: #007bff; color: white; padding: 5px;\">Total</th>
      </tr>";

      if (!empty($header)) {
        $no               = 1;
        $qtyh_all         = 0;
        $hargah_all       = 0;
        $diskon_all       = 0;
        $totalh_all       = 0;
        foreach ($header as $h) {
          $detail   = $this->db->query("SELECT d.* FROM retur_beli_d d WHERE d.invoice = '$h->invoice'")->result();
          $supplier = $this->db->get_where("supplier", ["kode_supplier" => $h->kode_supplier])->row();
          $gudang   = $this->db->get_where("gudang", ["kode_gudang" => $h->kode_gudang])->row();

          $body .= "<tr>
            <td style=\"background-color: grey; color: white; padding: 5px;\" colspan=\"3\">$supplier->nama_supplier - Gudang: $gudang->nama_gudang</td>
            <td style=\"background-color: grey; color: white; padding: 5px;\" colspan=\"6\">$h->invoice</td>
          </tr>";

          $qty_all        = 0;
          $harga_all      = 0;
          $disc_rp_all    = 0;
          $total_all      = 0;

          foreach ($detail as $d) {
            $satuan = $this->db->get_where("satuan", ["kode_satuan" => $d->satuan])->row();
            if ($satuan) {
              $satuan = $satuan->nama_satuan;
            } else {
              $satuan = "Belum Ada";
            }

            $qty_all        += $d->qty;
            $harga_all      += $d->harga;
            $disc_rp_all    += $d->disc_rp;
            $total_all      += $d->total;
            if ($cekpdf == 1) {
              $qty            = number_format($d->qty);
              $harga          = number_format($d->harga);
              $disc_rp        = number_format($d->disc_rp);
              $total          = number_format($d->total);

              $qty_allx       = number_format($qty_all);
              $harga_allx     = number_format($harga_all);
              $disc_rp_allx   = number_format($disc_rp_all);
              $total_allx     = number_format($total_all);
            } else {
              $qty            = ceil($d->qty);
              $harga          = ceil($d->harga);
              $disc_rp        = ceil($d->disc_rp);
              $total          = ceil($d->total);

              $qty_allx       = ceil($qty_all);
              $harga_allx     = ceil($harga_all);
              $disc_rp_allx   = ceil($disc_rp_all);
              $total_allx     = ceil($total_all);
            }
            $body .= "<tr class=\"text-center\">
              <td style=\"padding: 5px; text-align: right;\">$no</td>
              <td style=\"padding: 5px;\">$d->kode_barang</td>
              <td style=\"padding: 5px;\">$d->nama</td>
              <td style=\"padding: 5px;\">$satuan</td>
              <td style=\"padding: 5px;\">" . date("d-m-Y", strtotime($d->tgl_expire)) . "</td>
              <td style=\"padding: 5px; text-align: right;\">$qty</td>
              <td style=\"padding: 5px; text-align: right;\">$harga</td>
              <td style=\"padding: 5px; text-align: right;\">$disc_rp</td>
              <td style=\"padding: 5px; text-align: right;\">$total</td>
            </tr>";
            $no++;
          }
          $body .= "<tr class=\"text-center\">
            <td style=\"background-color: #007bff; color: white; padding: 5px;\" colspan=\"5\">Total Per-Supplier</td>
            <td style=\"padding: 5px; text-align: right;\">$qty_allx</td>
            <td style=\"padding: 5px; text-align: right;\">$harga_allx</td>
            <td style=\"padding: 5px; text-align: right;\">$disc_rp_allx</td>
            <td style=\"padding: 5px; text-align: right;\">$total_allx</td>
          </tr>";

          $qtyh_all         += $qty_all;
          $hargah_all       += $harga_all;
          $diskon_all       += $disc_rp_all;
          $totalh_all       += $total_all;

          if ($cekpdf == 1) {
            $qtyh_allx   = number_format($qtyh_all);
            $hargah_allx = number_format($hargah_all);
            $diskon_allx = number_format($diskon_all);
            $totalh_allx = number_format($totalh_all);
          } else {
            $qtyh_allx   = ceil($qtyh_all);
            $hargah_allx = ceil($hargah_all);
            $diskon_allx = ceil($diskon_all);
            $totalh_allx = ceil($totalh_all);
          }
        }
      } else {
        $body .= "<tr>
          <td style=\"padding: 5px; text-align: center; color: red; font-weight: bold;\" colspan=\"9\">Tidak Ada Data</td>
        </tr>";
        $qtyh_allx = 0;
        $hargah_allx = 0;
        $diskon_allx = 0;
        $totalh_allx = 0;
      }

      $body .= "</table><br>";

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:12px\" width=\"100%\" align=\"center\" border=\"0\">";
      $body .= "<tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Qty Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$qtyh_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Harga Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$hargah_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; text-align: right;\">Diskon Keseluruhan : </th>
          <td style=\"padding: 5px; text-align: right;\">$diskon_allx</th>
        </tr>
        <tr class=\"text-center\">
          <td style=\"padding: 5px; width: 60%;\">&nbsp;</th>
          <td style=\"padding: 5px; color: red; font-weight: bold; text-align: right;\">Total Keseluruhan : </th>
          <td style=\"padding: 5px; color: red; font-weight: bold; text-align: right;\">$totalh_allx</th>
        </tr>";
      $body .= "</table>";

      $body .= "<table style=\"border-collapse:collapse;font-family: tahoma; font-size:15px\" width=\"100%\" align=\"center\" border=\"0\">
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%;\">&nbsp;</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">Penanggung Jawab</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">Pencetak</td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\">&nbsp;</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">
            <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
          </td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">
            <img src=\"" . base_url('assets/img/id_web.png') . "\" style=\"opacity: 0.3;\">
          </td>
        </tr>
        <tr>
          <td style=\"padding: 5px; width: 40%;\"></td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">($penanggungjawab)</td>
          <td style=\"padding: 5px; width: 30%; text-align: center;\">($pencetak)</td>
        </tr>
      </table>";
    }

    $this->M_temcetak->template($judul, $body, $position, $date = date("d-m-Y"), $cekpdf);
  }
}
