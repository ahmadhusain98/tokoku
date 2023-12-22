<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Bangkok');

class M_temcetak extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("M_cetak");
  }

  function template($judul, $body, $position, $date, $cekpdf)
  {
    $cabang      = $this->db->get_where("cabang", ["kode_cabang" => $this->session->userdata("cabang")])->row();
    $param       = $judul;
    $chari       = '';
    if ($cekpdf == 1) {
      $chari .= "<table style=\"border-collapse:collapse;font-family: Century Gothic; font-size:12px; color:#000;\" width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
          <td colspan=\"2\" style=\"border-top: none; border-right: none;border-left: none;border-bottom: none;\">
            <div style=\"text-align:right; font-weight: bold; font-size: 20px;\"><b><span style=\"color: red;\">Toko</span><span style=\"color: blue;\">ku</span></b></div>
          </td>
        </tr>
        <tr>
          <td colspan=\"2\">
            &nbsp;
          </td>
        </tr>
        <tr>
          <td colspan=\"2\" style=\"border-top: none; border-right: none;border-left: none;border-bottom: none;\">
            <div style=\"font-size: 16px;\">$cabang->nama_cabang - [$cabang->kode_cabang]</div>
          </td>
        </tr>
        <tr>
          <td colspan=\"2\">
            <div style=\"font-size: 11px;\">$cabang->alamat_cabang ($cabang->kontak_cabang)</div>
          </td>
        </tr>
        <tr>
          <td>
            <div style=\"font-size: 11px;\">$cabang->kontak_cabang</div>
          </td>
          <td>
            <td style=\"text-align:right; font-size:12px;\"><i>Cetak : " . $date . "</i></td>
          </td>
        </tr>
      </table>";
      $chari .= "<table style=\"border-collapse:collapse;font-family: Century Gothic; font-size:12px; color:#000;\" width=\"100%\"  border=\"1\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
          <td style=\"border-top: none;border-right: none;border-left: none;\"> &nbsp; </td>
        </tr>
        <tr>
          <td style=\"border-top: none; border-right: none;border-left: none;\"></td>
        </tr>
      </table>
      <table style=\"border-collapse:collapse;font-family: Century Gothic; font-size:12px; color:#000;\" width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
          <td> &nbsp; </td>
        </tr>
      </table>";
    }
    $chari .= $body;
    $data['prev']   = $chari;
    $judul          = $param;

    switch ($cekpdf) {
      case 0;
        echo ("<title>$judul</title>");
        echo ($chari);
        break;

      case 1;
        echo ("<title>$judul</title>");
        $this->M_cetak->mpdf($position, 'A4', $judul, $chari, '.PDF', 10, 10, 10, 2);
        break;
      case 2;
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Content-Type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename= $judul.xls");
        $this->load->view('master_cetak', $data);
        break;
      case 3;
        echo ("<title>$judul</title>");
        echo ($chari);
        echo "<script>window.print();</script>";
        break;
    }
  }
}
