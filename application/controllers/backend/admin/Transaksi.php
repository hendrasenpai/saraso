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
        if( $this->session->userdata('pengguna') != 'admin'){
            redirect(site_url('user/dashboard'));
        }
    }

    private $main_table = "view_user_transaksi";

    public function index()
    {
        $data = array();
        $data['title'] = 'Admin - Transaksi';
        view('backend.admin.transaksi.index', $data);
    }
    
    public function fetch_table()
    {
        $column_select = array('id_user', 'id_transaksi', 'keterangan', 'username', 'status', 'total_harga', 'created_on', 'created_by', 'updated_on', 'updated_by');
        $column_search = array('id_user', 'id_transaksi', 'keterangan', 'username', 'status', 'total_harga', 'created_on', 'created_by', 'updated_on', 'updated_by');
        $column_order = array(null, 'id_user', 'id_transaksi', 'keterangan', 'username', 'status', 'total_harga', 'created_on', 'created_by', 'updated_on', 'updated_by');

        $join_table = null;
        $filter_data =  null;
        $filter_array = null; 
        $order_by = array('id_transaksi' => 'desc');
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
            $sub_array[] = $row->id_transaksi;
            $sub_array[] = $row->username;
            $sub_array[] = $menu;
            $sub_array[] = $row->keterangan;
            $sub_array[] = 'Rp. '. number_format($row->total_harga,0,',','.');
            $sub_array[] = ($row->updated_on != null) ? shortdate($row->updated_on) : shortdate($row->created_on);
            $sub_array[] = ($row->status == 'belum') ? '<span class="badge badge-warning"><i class="fa fa-clock"></i> Belum Bayar</span>' :
                           (($row->status == 'utang')  ? '<span class="badge badge-dark"><i class="fa fa-times"></i> Ngutang</span>' :
                           (($row->status == 'batal') ?  '<span class="badge badge-danger"><i class="fa fa-times"></i> Batal</span>' :
                           '<span class="badge badge-success"><i class="fa fa-check"></i> Lunas</span>'));
            $sub_array[] = '
                           <div class="btn-group">
                            <a href="javascript:void(0)" data-id_transaksi="' . $row->id_transaksi . '" data-status="'.$row->status.'" class="ubah btn btn-info btn-rounded btn-sm"><i class="fas fa-edit"></i> Ubah</a>
                           <a href="javascript:void(0)" data-id_transaksi="' . $row->id_transaksi . '"  class="hapus btn btn-danger btn-rounded btn-sm"><i class="fas fa-trash"></i> Hapus</a>
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

    function ubah()
    {
            $encrypt_id_user = trim($this->input->get("id_user"), TRUE);
            $id_user = $this->encryption->decrypt($encrypt_id_user);
            if ($id_user != false) {
                $row = $this->model->get_where($this->main_table, ['id_user' => $id_user])->row();

                $data = array(
                    'title' => 'Ubah Transaksi',
                    'form_id' => 'form-ubah',
                    'id_user' => set_value('id_user', urlencode($encrypt_id_user)),
                    'nama' => set_value('nama', $row->nama),
                    'no_hp' => set_value('no_hp', $row->no_hp),
                    'username' => set_value('username', $row->username),
                    'status' => set_value('status', $row->status),
                    'old_foto' => set_value('old_foto', $row->foto),
                );
                return view('backend.admin.transaksi.form', $data);
            } else {
                redirect('admin/transaksi');
            }
    }

    function aksi_ubah()
    {
        $id_transaksi = $this->input->post("id_transaksi");
        $row = $this->model->get_where('transaksi', ['id_transaksi' => $id_transaksi]);
            $get = $row->row();
            $data = array(
                'status' => $this->input->post('status')
            );

            $data_log = array(
                "aktivitas" =>  $this->session->userdata('username')." mengubah data transaksi ". $get->id_transaksi,
                "oleh" => $this->session->userdata('username'),
                "pada" => date("Y-m-d h:i:s")
            );
            $this->model->insert("log", $data_log);
          
            $result =  array(
                'result' =>  $this->model->update('transaksi', $data, ['id_transaksi' => $id_transaksi]),
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            );
            echo json_encode($result);
    }

    public function aksi_hapus()
    {
            $id_transaksi = $this->input->post("id_transaksi");
            $row = $this->model->get_where('transaksi', ['id_transaksi' => $id_transaksi]);
            if ($row) {  
                $get = $row->row();
                $data_log = array(
                    "aktivitas" =>  $this->session->userdata('username')." menghapus data transaksi ".$get->id_transaksi,
                    "oleh" => $this->session->userdata('username'),
                    "pada" => date("Y-m-d h:i:s")
                );
                $this->model->insert("log", $data_log);
                $this->model->delete('transaksi_menu', ['id_transaksi' => $id_transaksi]);
                $result =  array(
                    'result' => $this->model->delete('transaksi', ['id_transaksi' => $id_transaksi]),
                    'csrfName' => $this->security->get_csrf_token_name(),
                    'csrfHash' => $this->security->get_csrf_hash()
                );
                echo json_encode($result);

            } else {
                $result =  array(
                    'result' => $this->session->set_flashdata('pesan', 'data tidak ada'),
                    'csrfName' => $this->security->get_csrf_token_name(),
                    'csrfHash' => $this->security->get_csrf_hash()
                );
                echo json_encode($result);
            }
    }
}
