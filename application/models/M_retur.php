<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_retur extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        setlocale(LC_ALL, 'id_ID.utf8');
        date_default_timezone_set('Asia/Jakarta');
    }

    var $table          = 'retur_beli_h';
    var $column_order   = ['retur_beli_h.id', 'invoice', 'retur_beli_h.kode_cabang', 'nama_supplier', 'nama_gudang', 'tgl_retur', 'jam_retur', 'peretur', 'total', 'accer', 'acc'];
    var $column_search  = ['retur_beli_h.id', 'invoice', 'retur_beli_h.kode_cabang', 'nama_supplier', 'nama_gudang', 'tgl_retur', 'jam_retur', 'peretur', 'total', 'accer', 'acc'];
    var $order          = ['retur_beli_h.id' => 'asc'];

    private function _get_datatables_query($jns, $bulan, $tahun, $cabang)
    {
        $this->db->select($this->column_order);
        $this->db->from($this->table);
        $this->db->join("supplier s", "s.kode_supplier = retur_beli_h.kode_supplier");
        $this->db->join("gudang g", "g.kode_gudang = retur_beli_h.kode_gudang");
        $this->db->where("retur_beli_h.kode_cabang", $cabang);
        if ($jns == 1) {
            $tanggal = date('Y-m-d');
            $this->db->where(['tgl_retur' => $tanggal]);
        } else {
            $this->db->where(['tgl_retur >=' => $bulan, 'tgl_retur<= ' => $tahun]);
        }
        $this->db->order_by("tgl_retur, jam_retur", "DESC");
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables($jns, $bulan, $tahun, $cabang)
    {
        $this->_get_datatables_query($jns, $bulan, $tahun, $cabang);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($jns, $bulan, $tahun, $cabang)
    {
        $this->_get_datatables_query($jns, $bulan, $tahun, $cabang);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($jns, $bulan, $tahun, $cabang)
    {
        $this->db->select($this->column_order);
        $this->db->from($this->table);
        $this->db->join("supplier s", "s.kode_supplier = retur_beli_h.kode_supplier");
        $this->db->join("gudang g", "g.kode_gudang = retur_beli_h.kode_gudang");
        $this->db->where("retur_beli_h.kode_cabang", $cabang);
        if ($jns == 1) {
            $this->db->where(['year(tgl_retur)' => $tahun, 'month(tgl_retur)' => $bulan]);
        } else {
            $this->db->where(['tgl_retur >=' => $bulan, 'tgl_retur<= ' => $tahun]);
        }
        return $this->db->count_all_results();
    }
}
