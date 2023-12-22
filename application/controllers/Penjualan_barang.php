<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        setlocale(LC_ALL, 'id_ID.utf8');
        date_default_timezone_set('Asia/Jakarta');
        $user = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
        $menu = $this->db->get_where("menu", ["url" => "Penjualan_barang"])->row();
        $cek_akses = $this->db->get_where("akses_menu", ["id_role" => $user->id_role, "id_menu" => $menu->id])->num_rows();
        $this->load->model("M_jual_barang");
        if ($cek_akses < 1) {
            redirect("Home");
        }
    }

    public function jual()
    {
        $cabang = $this->session->userdata("cabang");
        $user   = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
        $data   = [
            "cabang"    => $cabang,
            "judul"     => "Penjualan Barang",
            "user"      => $user,
            "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
            "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
            "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
        ];
        $this->template->load('Template/Home', 'Penjualan_barang/Jual', $data);
    }

    public function jual_list($param)
    {
        $cabang   = $this->session->userdata("cabang");
        $dat      = explode("~", $param);
        if ($dat[0] == 1) {
            $bulan = date("n");
            $tahun = date("Y");
            $list  = $this->M_jual_barang->get_datatables(1, $bulan, $tahun, $cabang);
        } else {
            $bulan  = date('Y-m-d', strtotime($dat[1]));
            $tahun  = date('Y-m-d', strtotime($dat[2]));
            $list   = $this->M_jual_barang->get_datatables(2, $bulan, $tahun, $cabang);
        }
        $data     = [];
        $no       = 1;
        foreach ($list as $rd) {
            $row    = [];
            $nama   = $this->db->query("SELECT * FROM user WHERE username = '$rd->penjual'")->row()->nama;
            if ($rd->pembeli == "UMUM0001") {
                $pembeli = "UMUM";
            } else {
                $pembeli = $this->db->query("SELECT * FROM user WHERE id_user = '$rd->pembeli'")->row()->nama;
            }
            $row[]  = $no;
            $row[]  = $rd->invoice;
            $row[]  = $pembeli;
            $row[]  = $nama;
            $row[]  = $rd->nama_gudang;
            $row[]  = $rd->tgl_jual;
            $row[]  = $rd->jam_jual;
            $row[]  = "<div>Rp <span class='float-right'>" . number_format($rd->total) . "</span></div>";
            $cek    = $this->db->query("SELECT * FROM kasir WHERE invoice_jual = '$rd->invoice'")->num_rows();
            if ($cek < 1) {
                $status = "<span class='badge badge-danger'>Belum Lunas</span>";
            } else {
                $status = "<span class='badge badge-primary'>Lunas</span>";
            }
            $row[]  = $status;
            if ($cek > 0) {
                $row[] = '<div class="text-center">
                    <button style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-warning" title="Ubah" disabled>
                        <i class="fa-solid fa-eye-low-vision"></i>
                    </button>
                    <button style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-danger" title="Hapus" disabled>
                        <i class="fa-solid fa-ban"></i>
                    </button>
                    <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-secondary" target="_blank" href="' . base_url("Penjualan_barang/jual_cetak/" . $rd->invoice . "") . '" title="Cetak" >
                        <i class="fa-solid fa-fill-drip"></i>
                    </a>
                </div>';
            } else {
                $row[] = '<div class="text-center">
                    <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-warning" href="' . base_url("Penjualan_barang/jual_edit/" . $rd->id . "") . '" title="Ubah">
                        <i class="fa-solid fa-eye-low-vision"></i>
                    </a>
                    <a style="margin-bottom: 5px;" type="button" class="btn btn-flat btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $rd->id . "'" . ",'" . $rd->invoice . "'" . ')">
                        <i class="fa-solid fa-ban"></i>
                    </a>
                    <a style="margin-bottom: 5px;" type="button" class="btn btn-sm btn-flat btn-secondary" target="_blank" href="' . base_url("Penjualan_barang/jual_cetak/" . $rd->invoice . "") . '" title="Cetak" >
                        <i class="fa-solid fa-fill-drip"></i>
                    </a>
                </div>';
            }
            $data[] = $row;
            $no++;
        }
        $output = [
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->M_jual_barang->count_all($dat[0], $bulan, $tahun, $cabang),
            "recordsFiltered" => $this->M_jual_barang->count_filtered($dat[0], $bulan, $tahun, $cabang),
            "data"            => $data,
        ];
        echo json_encode($output);
    }

    public function jual_entri()
    {
        $cabang = $this->session->userdata("cabang");
        $user   = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
        $data   = [
            "judul"     => "Tambah Data Penjualan",
            "cabang"    => $cabang,
            "user"      => $user,
            "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
            "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
            "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
            "test"      => $this->M_core->inv_jual($cabang, "2023-12-21"),
        ];
        $this->template->load('Template/Home', 'Penjualan_barang/Jual_entri', $data);
    }

    public function get_pembeli($id)
    {
        if ($id == "UMUM0001") {
            $data_user = [
                "status" => 1,
                "alamat" => "-",
            ];
            echo json_encode($data_user);
        } else {
            $data = $this->db->get_where("user", ["id_user" => $id])->row();
            if ($data) {
                $data_user = [
                    "status" => 1,
                    "alamat" => $data->alamat,
                ];
                echo json_encode($data_user);
            } else {
                echo json_encode(["status" => 0]);
            }
        }
    }

    public function get_barang($kode)
    {
        $cabang = $this->session->userdata("cabang");
        $now = date("Y-m-d");
        $gudang = $this->input->get("gudang");
        $barang = $this->db->query(
            "SELECT b.kode_barang AS id, b.nama_barang, st.kode_satuan, st.nama_satuan, b.harga_jual, s.tgl_expire
            FROM barang b
            JOIN satuan st ON b.satuan = st.kode_satuan
            JOIN stok s ON b.kode_barang = s.kode_barang
            WHERE (b.kode_cabang = '$cabang' AND s.kode_cabang = '$cabang') AND s.kode_gudang = '$gudang'
            AND s.tgl_expire > '$now' AND b.kode_barang = '$kode'
            GROUP BY s.tgl_expire"
        )->row();
        echo json_encode($barang);
    }

    public function jual_edit($id)
    {
        $cabang = $this->session->userdata("cabang");
        $user   = $this->db->get_where("user", ["username" => $this->session->userdata("username")])->row();
        $header = $this->db->query("SELECT * FROM jual_barang_h WHERE id = '$id'")->row();
        $detail = $this->db->query("SELECT * FROM jual_barang_d WHERE invoice = '$header->invoice'")->result();
        $data   = [
            "judul"     => "Tambah Data Penjualan",
            "cabang"    => $cabang,
            "user"      => $user,
            "pesan"     => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->result(),
            "jumpesan"  => $this->db->query("SELECT * FROM pesan WHERE status = 0 GROUP BY isi")->num_rows(),
            "teman"     => $this->db->query("SELECT * FROM user WHERE username != '$user->username'")->result(),
            "header"    => $header,
            "detail"    => $detail,
        ];
        $this->template->load('Template/Home', 'Penjualan_barang/Jual_edit', $data);
    }

    public function simpan($par)
    {
        $tgl_jual    = $this->input->post("tgl_jual");
        $cabang           = $this->session->userdata("cabang");
        if ($par == 1) {
            $invoice = $this->M_core->inv_jual($cabang, $tgl_jual);
        } else {
            $invoice = $this->input->post("invoice");
        }
        $jam_jual       = $this->input->post("jam_jual");
        $kode_gudang    = $this->input->post("kode_gudang");
        $pajak          = $this->input->post("cek_ppn");
        if ($pajak == 1) {
            $ppn = $this->input->post("id_ppn");
        } else {
            $ppn = "0";
        }
        $kode_pembeli   = $this->input->post("kode_pembeli");
        $penjual        = $this->session->userdata("username");
        $sub_total      = str_replace(",", "", $this->input->post("sub_total"));
        $sub_diskon     = str_replace(",", "", $this->input->post("diskon"));
        $ppn_rp         = str_replace(",", "", $this->input->post("ppn_rp"));
        $total          = str_replace(",", "", $this->input->post("total_semua"));
        // header
        if ($par == 1) {
            $data = [
                "invoice"       => $invoice,
                "kode_cabang"   => $cabang,
                "kode_gudang"   => $kode_gudang,
                "tgl_jual"      => $tgl_jual,
                "jam_jual"      => $jam_jual,
                "pembeli"       => $kode_pembeli,
                "penjual"       => $penjual,
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
                "kode_gudang"   => $kode_gudang,
                "tgl_jual"      => $tgl_jual,
                "jam_jual"      => $jam_jual,
                "pembeli"       => $kode_pembeli,
                "penjual"       => $penjual,
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
                'kegiatan'  => "Mengubah Data Jual pada Invoice " . $invoice . ", Dengan alasan : " . $this->input->post("alasan"),
                'menu'      => "Pembelian Barang Jual",
            ];
            $this->db->insert("activity_user", $aktifitas);
            $this->db->query("DELETE FROM jual_barang_d WHERE invoice = '$invoice'");
            $this->db->query("DELETE FROM jual_barang_h WHERE invoice = '$invoice'");
        } else {
            $aktifitas = [
                'username'  => $this->session->userdata("username"),
                'kegiatan'  => "Menambahkan Data Jual, Dengan Invoice " . $invoice,
                'menu'      => "Pembelian Barang Jual",
            ];
            $this->db->insert("activity_user", $aktifitas);
        }
        $cek = $this->db->insert("jual_barang_h", $data);
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
                $this->db->insert("jual_barang_d", $data_d);
            }
        }
        echo json_encode(["status" => 1, "invoice" => $invoice]);
    }
}
