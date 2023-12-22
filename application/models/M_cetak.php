<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_cetak extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  function mpdf($form = '', $uk = '', $judul = '', $isi = '', $jdlsave = '', $lMargin = '', $rMargin = '', $font = 10, $orientasi = '', $hal = '', $tab = '', $tMargin = '')
  {
    ini_set('memory_limit', '1500000M');

    // ori
    ini_set('max_execution_time', 0);
    ini_set("memory_limit", "-1");
    set_time_limit(0);
    // end ori

    $jam = date("H:i:s");
    if ($hal == '') {
      $hal1 = 1;
    }
    if ($hal !== '') {
      $hal1 = $hal;
    }
    if ($font == '') {
      $size = 12;
    } else {
      $size = $font;
    }

    if ($tMargin == '') {
      $tMargin = 16;
    }

    if ($lMargin == '') {
      $lMargin = 15;
    }

    if ($rMargin == '') {
      $rMargin = 15;
    }

    $this->mpdf = new \Mpdf\Mpdf(array(190, 236), $size, '', $lMargin, $rMargin, $tMargin);

    $this->mpdf->AddPage($form, $uk);

    $this->mpdf->SetFooter('Tercetak {DATE j-m-Y H:i:s} |Halaman {PAGENO} / {nb}| ');

    $this->mpdf->setTitle($judul);

    $this->mpdf->writeHTML($isi);

    $this->mpdf->output($jdlsave, 'I');
  }
}
