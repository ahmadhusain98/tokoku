<?php
class M_core extends CI_Model
{
  function kode_satuan($cabang)
  {
    $get = $this->db->query("SELECT kode_satuan AS kode FROM satuan WHERE kode_cabang = '$cabang' ORDER BY kode_satuan DESC LIMIT 1");
    if ($get->num_rows() > 0) {
      $row = $get->row();
      $n = (substr($row->kode, 7)) + 1;
      $no = sprintf("%'.04d", $n);
    } else {
      $no = "0001";
    }
    $kode_satuan = $cabang . "-SAT" . $no;
    return $kode_satuan;
  }

  function kode_kategori($cabang)
  {
    $get = $this->db->query("SELECT kode_kategori AS kode FROM kategori WHERE kode_cabang = '$cabang' ORDER BY kode_kategori DESC LIMIT 1");
    if ($get->num_rows() > 0) {
      $row = $get->row();
      $n = (substr($row->kode, 7)) + 1;
      $no = sprintf("%'.04d", $n);
    } else {
      $no = "0001";
    }
    $kode_kategori = $cabang . "-KAT" . $no;
    return $kode_kategori;
  }

  function kode_supplier($cabang)
  {
    $get = $this->db->query("SELECT kode_supplier AS kode FROM supplier WHERE kode_cabang = '$cabang' ORDER BY kode_supplier DESC LIMIT 1");
    if ($get->num_rows() > 0) {
      $row = $get->row();
      $n = (substr($row->kode, 7)) + 1;
      $no = sprintf("%'.04d", $n);
    } else {
      $no = "0001";
    }
    $kode_supplier = $cabang . "-SUP" . $no;
    return $kode_supplier;
  }

  function kode_gudang($cabang)
  {
    $get = $this->db->query("SELECT kode_gudang AS kode FROM gudang WHERE kode_cabang = '$cabang' ORDER BY kode_gudang DESC LIMIT 1");
    if ($get->num_rows() > 0) {
      $row = $get->row();
      $n = (substr($row->kode, 7)) + 1;
      $no = sprintf("%'.04d", $n);
    } else {
      $no = "0001";
    }
    $kode_gudang = $cabang . "-GUD" . $no;
    return $kode_gudang;
  }

  function kode_barang($cabang)
  {
    $get = $this->db->query("SELECT kode_barang AS kode FROM barang WHERE kode_cabang = '$cabang' ORDER BY kode_barang DESC LIMIT 1");
    if ($get->num_rows() > 0) {
      $row = $get->row();
      $n = (substr($row->kode, 7)) + 1;
      $no = sprintf("%'.04d", $n);
    } else {
      $no = "0001";
    }
    $kode_barang = $cabang . "-BRG" . $no;
    return $kode_barang;
  }

  function kode_order($cabang)
  {
    $get = $this->db->query("SELECT kode_order AS kode FROM order_pesanan WHERE kode_cabang = '$cabang' ORDER BY kode_order DESC LIMIT 1");
    if ($get->num_rows() > 0) {
      $row = $get->row();
      $n = (substr($row->kode, 7)) + 1;
      $no = sprintf("%'.04d", $n);
    } else {
      $no = "0001";
    }
    $kode_order = $cabang . "-ORD" . $no;
    return $kode_order;
  }

  function inv_po($cabang, $tgl)
  {
    $tahun = substr(date('Y', strtotime($tgl)), 2, 3);
    $bulan = date('m');
    $hari = date('d');
    $now = $tahun . $bulan . $hari;
    $get = $this->db->query("SELECT invoice AS kode FROM po_h WHERE kode_cabang = '$cabang' AND SUBSTRING(invoice, 8, 6) = '$now' ORDER BY invoice DESC LIMIT 1");
    if ($get->num_rows() > 0) {
      $row = $get->row();
      $n = (substr($row->kode, 13)) + 1;
      $no = sprintf("%'.04d", $n);
    } else {
      $no = "0001";
    }
    $inv_beli = $cabang . "-PRE" . $tahun . $bulan . $hari . $no;
    return $inv_beli;
  }

  function inv_terima($cabang, $tgl)
  {
    $tahun = substr(date('Y', strtotime($tgl)), 2, 3);
    $bulan = date('m');
    $hari = date('d');
    $now = $tahun . $bulan . $hari;
    $get = $this->db->query("SELECT invoice AS kode FROM pembelian_h WHERE kode_cabang = '$cabang' AND SUBSTRING(invoice, 8, 6) = '$now' ORDER BY invoice DESC LIMIT 1");
    if ($get->num_rows() > 0) {
      $row = $get->row();
      $n = (substr($row->kode, 13)) + 1;
      $no = sprintf("%'.04d", $n);
    } else {
      $no = "0001";
    }
    $inv_beli = $cabang . "-TER" . $tahun . $bulan . $hari . $no;
    return $inv_beli;
  }

  function inv_retur($cabang, $tgl)
  {
    $tahun = substr(date('Y', strtotime($tgl)), 2, 3);
    $bulan = date('m');
    $hari = date('d');
    $now = $tahun . $bulan . $hari;
    $get = $this->db->query("SELECT invoice AS kode FROM retur_beli_h WHERE kode_cabang = '$cabang' AND SUBSTRING(invoice, 8, 6) = '$now' ORDER BY invoice DESC LIMIT 1");
    if ($get->num_rows() > 0) {
      $row = $get->row();
      $n = (substr($row->kode, 13)) + 1;
      $no = sprintf("%'.04d", $n);
    } else {
      $no = "0001";
    }
    $inv_beli = $cabang . "-RET" . $tahun . $bulan . $hari . $no;
    return $inv_beli;
  }

  function inv_jual($cabang, $tgl)
  {
    $tahun = substr(date('Y', strtotime($tgl)), 2, 3);
    $bulan = date('m');
    $hari = date('d');
    $now = $tahun . $bulan . $hari;
    $get = $this->db->query("SELECT invoice AS kode FROM jual_barang_h WHERE kode_cabang = '$cabang' AND SUBSTRING(invoice, 9, 6) = '$now' ORDER BY invoice DESC LIMIT 1");
    if ($get->num_rows() > 0) {
      $row = $get->row();
      $n = (substr($row->kode, 14)) + 1;
      $no = sprintf("%'.04d", $n);
    } else {
      $no = "0001";
    }
    $inv_beli = $cabang . "-SELL" . $tahun . $bulan . $hari . $no;
    return $inv_beli;
  }
}
