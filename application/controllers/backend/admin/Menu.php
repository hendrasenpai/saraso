<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
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

    private $main_table = "menu";

    public function index()
    {
        $data = array();
        $data['title'] = 'Menu';
        view('backend.admin.menu.index', $data);
    }
    
    public function fetch_table()
    {
        $column_select = array('id_menu', 'nama', 'harga');
        $column_search = array('id_menu', 'nama', 'harga');
        $column_order = array(null, 'id_menu', 'nama', 'harga');

        $join_table = null;
        $filter_data = null;
        $filter_array = null; 
        $order_by = array('id_menu' => 'desc');
        $group_by = null; 

        $get_data = $this->model->make_datatables($this->main_table, $column_select, $column_search, $column_order, $order_by, $group_by, $join_table, $filter_data, $filter_array);

        $data = array();
        $no = $_POST['start'];
        foreach ($get_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->nama;
            $sub_array[] = 'Rp. '. number_format($row->harga,0,',','.');
            $sub_array[] = '
                <div class="btn-group">
                    <a href="' . site_url('admin/menu/ubah?id_menu=') . urlencode($this->encryption->encrypt($row->id_menu)) . '" class="ubah btn btn-info btn-rounded btn-sm"><i class="far fa-edit"></i> Ubah</a> 
                    <a href="javascript:void_menu(0)" data-id_menu="' . $row->id_menu . '" class="hapus btn btn-danger btn-rounded btn-sm"><i class="fas fa-trash"></i> Hapus</a>
                </div>';
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

    function tambah()
    {
        $data = array(
            'title' => 'Tambah Menu',
            'form_id' => 'form-tambah',
            'id_menu' => set_value('id_menu'),
            'nama' => set_value('nama'),
            'harga' => set_value('harga'),
        );
        return view('backend.admin.menu.form', $data);
    }

    function ubah()
    {
            $encrypt_id_menu = trim($this->input->get("id_menu"), TRUE);
            $id_menu = $this->encryption->decrypt($encrypt_id_menu);
            if ($id_menu != false) {
                $row = $this->model->get_where($this->main_table, ['id_menu' => $id_menu])->row();

                $data = array(
                    'title' => 'Ubah Menu',
                    'form_id' => 'form-ubah',
                    'id_menu' => set_value('id_menu', urlencode($encrypt_id_menu)),
                    'nama' => set_value('nama', $row->nama),
                    'harga' => set_value('harga', $row->harga),
                );
                return view('backend.admin.menu.form', $data);
            } else {
                redirect('admin/menu');
            }
    }

    function aksi_tambah()
    {
        $this->form_validation->set_rules('nama', '', 'trim|required', array('trim' => '', 'required' => 'Nama Menu harus diisi.'));
        $this->form_validation->set_rules('harga', '', 'trim|required', array('trim' => '', 'required' => 'Harga Menu harus diisi.'));
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'error'   => true,
                'nama_error' => form_error('nama'),
                'harga_error' => form_error('harga'),
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            );
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'harga' => $this->input->post('harga'),
            );

            $data_log = array(
                "aktivitas" => $this->session->userdata('username')." menambahkan data menu ". $this->input->post("nama"),
                "oleh" => $this->session->userdata('username'),
                "pada" => date("Y-m-d h:i:s")
            );
            
            $this->model->insert("log", $data_log);
            $result =  array(
                'result' => $this->model->insert($this->main_table, $data),
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            );
        }
        echo json_encode($result);
    }

    function aksi_ubah()
    {
        $this->form_validation->set_rules('nama', '', 'trim|required', array('trim' => '', 'required' => 'Nama Menu harus diisi.'));
        $this->form_validation->set_rules('harga', '', 'trim|required', array('trim' => '', 'required' => 'Harga Menu harus diisi.'));
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'error'   => true,
                'nama_error' => form_error('nama'),
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            );
        } else {
            $encrypt_id_menu = urldecode(trim($this->input->post('id_menu'), TRUE));
            $id_menu = $this->encryption->decrypt($encrypt_id_menu);
            $data = array(
                'nama' => $this->input->post('nama'),
                'harga' => $this->input->post('harga'),
            );

            $data_log = array(
                "aktivitas" => $this->session->userdata('username')." mengubah data menu ". $this->input->post("nama"),
                "oleh" => $this->session->userdata('username'),
                "pada" => date("Y-m-d h:i:s")
            );
            
            $this->model->insert("log", $data_log);
            $result =  array(
                'result' => $this->model->update($this->main_table, $data, ['id_menu' => $id_menu]),
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            );
        }
        echo json_encode($result);
    }

    public function aksi_hapus()
    {
            $id_menu = $this->input->post("id_menu");
            $row = $this->model->get_where($this->main_table, ['id_menu' =>$id_menu]);
            if ($row) {
                $get = $row->row();

                $data_log = array(
                    "aktivitas" =>  $this->session->userdata('username')." menghapus data menu ". $get->nama,
                    "oleh" => $this->session->userdata('username'),
                    "pada" => date("Y-m-d h:i:s")
                );
                $this->model->insert("log", $data_log);
                
                $result =  array(
                    'result' => $this->model->delete($this->main_table, ['id_menu' => $id_menu]),
                    'csrfName' => $this->security->get_csrf_token_name(),
                    'csrfHash' => $this->security->get_csrf_hash()
                );
                echo json_encode($result);

            } else {
                $result =  array(
                    'result' => $this->session->set_flashdata('pesan', 'data tid_menuak ada'),
                    'csrfName' => $this->security->get_csrf_token_name(),
                    'csrfHash' => $this->security->get_csrf_hash()
                );
                echo json_encode($result);
            }
    }
}
