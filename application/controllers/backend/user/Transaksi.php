<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('session_web') != true) {
            redirect(site_url('auth'));
        }
        if( $this->session->userdata('pengguna') != 'user'){
            redirect(site_url('admin/dashboard'));
        }
    }

    private $main_table = "view_user_transaksi";

    public function index()
    {
        $data = array();
        $data['title'] = 'Transaksi';
        view('backend.user.transaksi.index', $data);
    }
    
    public function fetch_table()
    {
        $column_select = array('id_user', 'id_transaksi', 'keterangan', 'username', 'status', 'total_harga', 'created_on', 'created_by', 'updated_on', 'updated_by');
        $column_search = array('id_user', 'id_transaksi', 'keterangan', 'username', 'status', 'total_harga', 'created_on', 'created_by', 'updated_on', 'updated_by');
        $column_order = array(null, 'id_user', 'id_transaksi', 'keterangan', 'username', 'status', 'total_harga', 'created_on', 'created_by', 'updated_on', 'updated_by');

        $join_table = null;
        $filter_data =  array('id_user' => $this->session->userdata('id_user'));;
        $filter_array = null; 
        $order_by = array('id_user' => 'desc');
        $group_by = null; 

        $get_data = $this->model->make_datatables($this->main_table, $column_select, $column_search, $column_order, $order_by, $group_by, $join_table, $filter_data, $filter_array);
        
        $data = array();
        $no = $_POST['start'];
        foreach ($get_data as $row) {
            $get_menu = $this->model->get_where('view_transaksi_menu', ['id_transaksi' => $row->id_transaksi])->result();
            $menu = '<ul>';
            foreach($get_menu as $value){
                $menu .= '<li>' . $value->nama .' : '. number_format($value->harga,0,',','.') .'</li>';
            } 
            $menu .= '</ul>';

            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $menu;
            $sub_array[] = $row->keterangan;
            $sub_array[] = 'Rp. '. number_format($row->total_harga,0,',','.');
            $sub_array[] = ($row->updated_on != null) ? shortdate($row->updated_on) : shortdate($row->created_on);
            $sub_array[] = ($row->status == 'belum') ? '<span class="badge badge-warning"><i class="fa fa-clock"></i> Belum Bayar</span>' :
                           (($row->status == 'utang')  ? '<span class="badge badge-dark"><i class="fa fa-times"></i> Ngutang</span>' :
                           (($row->status == 'batal') ?  '<span class="badge badge-danger"><i class="fa fa-times"></i> Batal</span>' :
                           '<span class="badge badge-success"><i class="fa fa-check"></i> Lunas</span>'));
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

    function data_harga()
	{
		$menu = $this->input->post('menu');
        if(isset($menu)){
            $total = 0;
            foreach($menu as $row){
                $data = $this->model->get_where('menu', ['id_menu' => $row])->row()->harga;
                $total += $data;
            }
        }else{
            $total = 0;
        }

		$callback = array(
			'result' => $total,
			'csrfName' => $this->security->get_csrf_token_name(),
        	'csrfHash' => $this->security->get_csrf_hash()
		);
		echo json_encode($callback);
	}

    
    public function tambah()
    {
        // if(date('D') == 'Fri' || date('D') == 'Sat' || date('D') == 'Sun') { 
        //     $this->session->set_flashdata('pesan', 'Pesanan tidak bisa dilakukan karena hari libur');
        //     redirect(site_url('user/transaksi'));
        // }elseif(date('H') > 9){
        //     $this->session->set_flashdata('pesan', 'Pesanan tidak bisa dilakukan karena sudah lewat jam 9 pagi');
        //     redirect(site_url('user/transaksi'));
        // }else{
            $data = array(
                'title' => 'Buat Pesanan',
                'form_id' => 'form-tambah',
                'id_transaksi' => set_value('id_transaksi'),
                'menu' => set_value('menu'),
                'total_harga' => set_value('total_harga'),
                'keterangan' => set_value('keterangan'),
            );
            return view('backend.user.transaksi.form', $data);
        // }
    }


    function aksi_tambah()
    {
        $this->form_validation->set_rules('menu[]', '', 'trim|required', array('trim' => '', 'required' => 'Menu harus dipilih.'));
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'error'   => true,
                'menu_error' => form_error('menu'),
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            );
        } else {
            $data_transaksi = array(
                'id_user' => $this->session->userdata('id_user'),
                'total_harga' => $this->input->post('total_harga'),
                'keterangan' => $this->input->post('keterangan'),
                'created_by' => $this->session->userdata('username'),
                'created_on' => date("Y-m-d h:i:s")
            );

            $this->model->insert('transaksi', $data_transaksi);
            $get_id_transaksi = $this->db->insert_id();
            $menu = $this->input->post('menu');

            foreach($this->input->post('menu') as $row){
                $data_menu = array(
                    'id_transaksi' => $get_id_transaksi,
                    'id_menu' => $row,
                    'created_by' => $this->session->userdata('username'),
                    'created_on' => date("Y-m-d h:i:s")
                );
                $this->model->insert('transaksi_menu', $data_menu);
            }
            
            $data_log = array(
                "aktivitas" => $this->session->userdata('username')." menambahkan pesanan ". $this->input->post("nama"),
                "oleh" => $this->session->userdata('username'),
                "pada" => date("Y-m-d h:i:s")
            );
           
            $result =  array(
                'result' =>  $this->model->insert("log", $data_log),
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            );
        }
        echo json_encode($result);
    }
    

}