<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Select2_master extends CI_Controller
{

  public function data_cabang()
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query("SELECT id_cabang AS id, concat(kode_cabang, ' - ', nama_cabang) AS text FROM cabang WHERE id_cabang LIKE '%" . $key . "%' OR nama_cabang LIKE '%" . $key . "%' OR alamat_cabang LIKE '%" . $key . "%' OR kontak_cabang LIKE '%" . $key . "%' ORDER BY kode_cabang ASC")->result();
    } else {
      $data = $this->db->query("SELECT id_cabang AS id, concat(kode_cabang, ' - ', nama_cabang) AS text FROM cabang")->result();
    }
    echo json_encode($data);
  }

  public function data_role()
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query("SELECT id_role AS id, concat(tingkatan) AS text FROM role WHERE id_role LIKE '%" . $key . "%' OR tingkatan LIKE '%" . $key . "%' ORDER BY id_role ASC")->result();
    } else {
      $data = $this->db->query("SELECT id_role AS id, concat(tingkatan) AS text FROM role")->result();
    }
    echo json_encode($data);
  }

  public function get_data($id_cabang)
  {
    $data = $this->db->get_where("cabang", ["id_cabang" => $id_cabang])->row();
    echo json_encode($data);
  }

  public function data_satuan($cabang)
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query("SELECT kode_satuan AS id, concat(nama_satuan) AS text FROM satuan WHERE kode_cabang = '$cabang' AND kode_satuan LIKE '%" . $key . "%' OR nama_satuan LIKE '%" . $key . "%' ORDER BY kode_satuan ASC")->result();
    } else {
      $data = $this->db->query("SELECT kode_satuan AS id, concat(nama_satuan) AS text FROM satuan WHERE kode_cabang = '$cabang'")->result();
    }
    echo json_encode($data);
  }

  public function data_kategori($cabang)
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query("SELECT kode_kategori AS id, concat(nama_kategori) AS text FROM kategori WHERE kode_cabang = '$cabang' AND kode_kategori LIKE '%" . $key . "%' OR nama_kategori LIKE '%" . $key . "%' ORDER BY kode_kategori ASC")->result();
    } else {
      $data = $this->db->query("SELECT kode_kategori AS id, concat(nama_kategori) AS text FROM kategori WHERE kode_cabang = '$cabang'")->result();
    }
    echo json_encode($data);
  }

  public function data_supplier($cabang)
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query("SELECT kode_supplier AS id, concat(nama_supplier) AS text FROM supplier WHERE kode_cabang = '$cabang' AND kode_supplier LIKE '%" . $key . "%' OR nama_supplier LIKE '%" . $key . "%' ORDER BY kode_supplier ASC")->result();
    } else {
      $data = $this->db->query("SELECT kode_supplier AS id, concat(nama_supplier) AS text FROM supplier WHERE kode_cabang = '$cabang'")->result();
    }
    echo json_encode($data);
  }

  public function data_gudang($cabang)
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query("SELECT kode_gudang AS id, concat(nama_gudang) AS text FROM gudang WHERE kode_cabang = '$cabang' AND kode_gudang LIKE '%" . $key . "%' OR nama_gudang LIKE '%" . $key . "%' ORDER BY kode_gudang ASC")->result();
    } else {
      $data = $this->db->query("SELECT kode_gudang AS id, concat(nama_gudang) AS text FROM gudang WHERE kode_cabang = '$cabang'")->result();
    }
    echo json_encode($data);
  }

  public function data_ppn()
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query("SELECT id_ppn AS id, concat(nama_ppn) AS text FROM ppn WHERE kode_ppn LIKE '%" . $key . "%' OR nama_ppn LIKE '%" . $key . "%' ORDER BY kode_ppn ASC")->result();
    } else {
      $data = $this->db->query("SELECT id_ppn AS id, concat(nama_ppn) AS text FROM ppn")->result();
    }
    echo json_encode($data);
  }

  public function get_ppn($id)
  {
    $data = $this->db->get_where("ppn", ["id_ppn" => $id])->row()->value_ppn;
    echo json_encode($data);
  }

  public function data_barang($cabang)
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query("SELECT kode_barang AS id, concat(nama_barang, ' | ', satuan, ' | ', 'Beli: Rp. ', harga_beli) AS text FROM barang WHERE kode_cabang = '$cabang' AND kode_barang LIKE '%" . $key . "%' OR nama_barang LIKE '%" . $key . "%' OR satuan LIKE '%" . $key . "%' ORDER BY kode_barang ASC")->result();
    } else {
      $data = $this->db->query("SELECT kode_barang AS id, concat(nama_barang, ' | ', satuan, ' | ', 'Beli: Rp. ', harga_beli) AS text FROM barang WHERE kode_cabang = '$cabang'")->result();
    }
    echo json_encode($data);
  }

  public function data_barang_jual($cabang)
  {
    $now = date("Y-m-d");
    $key = $this->input->post('searchTerm');
    $gudang = $this->input->get('gudang');
    if ($key != '') {
      $data = $this->db->query(
        "SELECT b.kode_barang AS id, CONCAT(b.nama_barang, ' | ', b.harga_jual, ' | ', SUM(s.saldo_akhir), ' | ', 'Expire: ', DATE_FORMAT(s.tgl_expire, '%Y-%m-%d')) AS text
        FROM barang b
        JOIN stok s ON b.kode_barang = s.kode_barang
        WHERE (b.kode_cabang = '$cabang' AND s.kode_cabang = '$cabang') AND s.kode_gudang = '$gudang'
        AND (b.kode_barang LIKE '%$key%' OR nama_barang LIKE '%$key%' OR b.satuan LIKE '%$key%' OR b.harga_jual LIKE '%$key%')
        AND s.tgl_expire > '$now'
        GROUP BY s.tgl_expire
        ORDER BY b.kode_barang, s.tgl_expire ASC LIMIT 50"
      )->result();
    } else {
      $data = $this->db->query(
        "SELECT b.kode_barang AS id, CONCAT(b.nama_barang, ' | ', b.harga_jual, ' | ', SUM(s.saldo_akhir), ' | ', 'Expire: ', DATE_FORMAT(s.tgl_expire, '%Y-%m-%d')) AS text
        FROM barang b
        JOIN stok s ON b.kode_barang = s.kode_barang
        WHERE (b.kode_cabang = '$cabang' AND s.kode_cabang = '$cabang') AND s.kode_gudang = '$gudang'
        AND s.tgl_expire > '$now'
        GROUP BY s.tgl_expire
        ORDER BY b.kode_barang, s.tgl_expire ASC LIMIT 50"
      )->result();
    }
    echo json_encode($data);
  }

  public function data_po($cabang)
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query("SELECT invoice AS id, concat(invoice, ' | ', tgl_pembelian, ' | ', jam_pembelian) AS text FROM po_h WHERE kode_cabang = '$cabang' AND (invoice LIKE '%" . $key . "%' OR tgl_pembelian LIKE '%" . $key . "%' OR jam_pembelian LIKE '%" . $key . "%') AND invoice NOT IN (SELECT invoice_po FROM pembelian_h) ORDER BY invoice ASC")->result();
    } else {
      $data = $this->db->query("SELECT invoice AS id, concat(invoice, ' | ', tgl_pembelian, ' | ', jam_pembelian) AS text FROM po_h WHERE kode_cabang = '$cabang' AND invoice NOT IN (SELECT invoice_po FROM pembelian_h)")->result();
    }
    echo json_encode($data);
  }

  public function data_penerimaan($cabang)
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query("SELECT invoice AS id, concat(invoice, ' | ', tgl_terima, ' | ', jam_terima) AS text FROM pembelian_h WHERE kode_cabang = '$cabang' AND (invoice LIKE '%" . $key . "%' OR tgl_terima LIKE '%" . $key . "%' OR jam_terima LIKE '%" . $key . "%' OR penerima LIKE '%" . $key . "%' OR invoice_po LIKE '%" . $key . "%') AND invoice NOT IN (SELECT invoice_terima FROM retur_beli_h) AND acc = 1 ORDER BY invoice ASC")->result();
    } else {
      $data = $this->db->query("SELECT invoice AS id, concat(invoice, ' | ', tgl_terima, ' | ', jam_terima) AS text FROM pembelian_h WHERE kode_cabang = '$cabang' AND invoice NOT IN (SELECT invoice_terima FROM retur_beli_h) AND acc = 1")->result();
    }
    echo json_encode($data);
  }

  public function data_pembeli()
  {
    $key = $this->input->post('searchTerm');
    if ($key != '') {
      $data = $this->db->query(
        "(SELECT 'UMUM0001' AS id, concat('UMUM') AS text FROM user LIMIT 1)
        
        UNION ALL

        (SELECT id_user AS id, concat(id_user, ' | ', nama, ' | ', nohp, ' | ', alamat) AS text FROM user WHERE id_role = 3 AND (username LIKE '%$key%' OR nama LIKE '%$key%' OR nohp LIKE '%$key%' OR alamat LIKE '%$key%') LIMIT 20)
        "
      )->result();
    } else {
      $data = $this->db->query(
        "(SELECT 'UMUM0001' AS id, concat('UMUM') AS text FROM user LIMIT 1)
        
        UNION ALL

        (SELECT id_user AS id, concat(id_user, ' | ', nama, ' | ', nohp, ' | ', alamat) AS text FROM user WHERE id_role = 3 LIMIT 20)
        "
      )->result();
    }
    echo json_encode($data);
  }
}
