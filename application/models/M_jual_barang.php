<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_jual_barang extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        setlocale(LC_ALL, 'id_ID.utf8');
        date_default_timezone_set('Asia/Jakarta');
    }

    var $table          = 'jual_barang_h';
    var $column_order   = ['jual_barang_h.id', 'invoice', 'jual_barang_h.kode_cabang', 'nama_gudang', 'tgl_jual', 'jam_jual', 'penjual', 'pembeli', 'total'];
    var $column_search  = ['jual_barang_h.id', 'invoice', 'jual_barang_h.kode_cabang', 'nama_gudang', 'tgl_jual', 'jam_jual', 'penjual', 'pembeli', 'total'];
    var $order          = ['jual_barang_h.id' => 'asc'];

    private function _get_datatables_query($jns, $bulan, $tahun, $cabang)
    {
        $this->db->select($this->column_order);
        $this->db->from($this->table);
        $this->db->join("gudang g", "g.kode_gudang = jual_barang_h.kode_gudang");
        $this->db->where("jual_barang_h.kode_cabang", $cabang);
        if ($jns == 1) {
            $tanggal = date('Y-m-d');
            $this->db->where(['tgl_jual' => $tanggal]);
        } else {
            $this->db->where(['tgl_jual >=' => $bulan, 'tgl_jual<= ' => $tahun]);
        }
        $this->db->order_by("tgl_jual, jam_jual", "DESC");
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
        $this->db->join("gudang g", "g.kode_gudang = jual_barang_h.kode_gudang");
        $this->db->where("jual_barang_h.kode_cabang", $cabang);
        if ($jns == 1) {
            $this->db->where(['year(tgl_jual)' => $tahun, 'month(tgl_jual)' => $bulan]);
        } else {
            $this->db->where(['tgl_jual >=' => $bulan, 'tgl_jual<= ' => $tahun]);
        }
        return $this->db->count_all_results();
    }
}
