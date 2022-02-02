<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('session_web') != true) {
            redirect(site_url('auth'));
        }
        if( $this->session->userdata('pengguna') != 'admin'){
            redirect(site_url('user/dashboard'));
        }
    }

    private $main_table = "tb_log";

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['jumlah_user'] = $this->model->count_all('user');
        $data['jumlah_transaksi'] = $this->model->count_all('transaksi');
        $data['jumlah_transaksi_today'] = $this->model->count_where('transaksi', ['created_on' => date('Y-m-d')]);
        return view('backend.admin.dashboard.index', $data);
    }

    public function fetch_table()
    {
        $column_select = array('id', 'aktivitas', 'oleh', 'pada');
        $column_search = array('id', 'aktivitas', 'oleh', 'pada');
        $column_order = array(null, 'id', 'aktivitas', 'oleh', 'pada');

        $join_table = null;
        $filter_data = null;
        $filter_array = null; 
        $order_by = array('id' => 'desc');
        $group_by = null; 

        $get_data = $this->model->make_datatables($this->main_table, $column_select, $column_search, $column_order, $order_by, $group_by, $join_table, $filter_data, $filter_array);

        $data = array();
        $no = $_POST['start'];
        foreach ($get_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->aktivitas;
            $sub_array[] = date('d/m/Y (h:i)', strtotime($row->pada));
            $sub_array[] = $row->oleh;
            $data[] = $sub_array;
        }

        $output = array(
            "csrfName" => $this->security->get_csrf_token_name(),
            "csrfHash" => $this->security->get_csrf_hash(),
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->count_all($this->main_table),
            "recordsFiltered" => $this->model->count_filtered($this->main_table, $column_select, $column_search, $column_order, $order_by, $group_by, $join_table, $filter_data, $filter_array),
            "data" => $data
        );
        echo json_encode($output);
    }
}
