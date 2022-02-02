<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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

    private $main_table = "view_user_profil";

    public function index()
    {
        $data = array();
        $data['title'] = 'User';
        view('backend.admin.user.index', $data);
    }
    
    public function fetch_table()
    {
        $column_select = array('id_user', 'nama', 'no_hp', 'username', 'token', 'status', 'created_on', 'created_by', 'updated_on', 'updated_by');
        $column_search = array('id_user', 'nama', 'no_hp', 'username', 'token', 'status', 'created_on', 'created_by', 'updated_on', 'updated_by');
        $column_order = array(null, 'id_user', 'nama', 'no_hp', 'username', 'token', 'status', 'created_on', 'created_by', 'updated_on', 'updated_by');

        $join_table = null;
        $filter_data = null;
        $filter_array = null; 
        $order_by = array('id_user' => 'desc');
        $group_by = null; 

        $get_data = $this->model->make_datatables($this->main_table, $column_select, $column_search, $column_order, $order_by, $group_by, $join_table, $filter_data, $filter_array);

        $data = array();
        $no = $_POST['start'];
        foreach ($get_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->nama;
            $sub_array[] = $row->no_hp;
            $sub_array[] = $row->username;
            $sub_array[] = ($row->updated_by != null) ? $row->updated_by : $row->created_by;
            $sub_array[] = ($row->updated_on != null) ? shortdate($row->updated_on) : shortdate($row->created_on);
            $sub_array[] = ($row->status == 'aktif') ? '<span class="badge badge-primary"><i class="fa fa-check"></i> Aktif</span>' :  '<span class="badge badge-danger"><i class="fa fa-times"></i> Tidak Aktif</span>';
            $sub_array[] = '
                <div class="btn-group">
                    <a href="' . site_url('admin/user/ubah?id_user=') . urlencode($this->encryption->encrypt($row->id_user)) . '" class="ubah btn btn-info btn-rounded btn-sm"><i class="far fa-edit"></i> Ubah</a> 
                    <a href="javascript:void(0)" data-id_user="' . $row->id_user . '" class="hapus btn btn-danger btn-rounded btn-sm"><i class="fas fa-trash"></i> Hapus</a>
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
                    'title' => 'Ubah User',
                    'form_id' => 'form-ubah',
                    'id_user' => set_value('id_user', urlencode($encrypt_id_user)),
                    'nama' => set_value('nama', $row->nama),
                    'no_hp' => set_value('no_hp', $row->no_hp),
                    'username' => set_value('username', $row->username),
                    'password' => set_value('password'),
                    'status' => set_value('status', $row->status),
                    'old_foto' => set_value('old_foto', $row->foto),
                );
                return view('backend.admin.user.form', $data);
            } else {
                redirect('admin/user');
            }
    }

    function aksi_ubah()
    {
        $encrypt_id = urldecode(trim($this->input->post('id_user'), TRUE));
        $id = $this->encryption->decrypt($encrypt_id);
        $value =  $this->model->get_where('user', ['id_user' => $id])->row();

        if($this->input->post('username') != $value->username) {
            $is_unique_username =  '|is_unique[user.username]';
         } else {
            $is_unique_username =  '';
         }
         
        $this->form_validation->set_rules('username', '', 'trim|required'.$is_unique_username, array('is_unique' => 'Username sudah pernah terdaftar', 'trim' => '', 'required' => 'Username harus diisi.'));
        $this->form_validation->set_rules('nama', '', 'trim|required', array('trim' => '', 'required' => 'Nama User harus diisi.'));
		$this->form_validation->set_rules('no_hp', 'No HP', 'numeric|trim|required|min_length[10]|max_length[12]', array('trim' => '', 'required' => 'No. HP wajib diisi.', 'min_length'=> 'Minimal 10 Digit', 'max_length'=> 'Maksimal 12 Digit'));
        $this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]',  array('trim' => '', 'min_length' => 'Minimal 8 karakter.'));
        $this->form_validation->set_rules('status', 'Status', 'trim|required', array('trim' => '', 'required' => 'Status wajib dipilih.'));
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'error'   => true,
                'username_error' => form_error('username'),
                'password_error' => form_error('password'),
                'nama_error' => form_error('nama'),
                'no_hp_error' => form_error('no_hp'),
                'status_error' => form_error('status'),
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            );
        } else {
            $encrypt_id_user = urldecode(trim($this->input->post('id_user'), TRUE));
            $id_user = $this->encryption->decrypt($encrypt_id_user);
            
            if($this->input->post('password') != null){
                $data_user = array(
                    'username' => $this->input->post('username'),
                    'password' => $this->hash_password($this->input->post('password'), TRUE),
                    'status' => $this->input->post('status')
                );
            }else{
                $data_user = array(
                    'username' => $this->input->post('username'),
                    'status' => $this->input->post('status'),
                );  
            }

            $data_profil = array(
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp'),
            );

            $get = $this->model->get_where('profil', ['id_user' => $id])->row();

            if (!empty($_FILES['foto']['name'])) {
                $upload = $this->do_upload();
                $data_profil['foto'] = $upload;
                if (!empty($get->foto)) {
                    unlink('upload/'.$get->foto);    
                }
            } else {
                $data_profil['foto'] = $this->input->post('old_foto');
            }

            $data_log = array(
                "aktivitas" => $this->session->userdata('username')." mengubah data user ". $this->input->post("nama"),
                "oleh" => $this->session->userdata('username'),
                "pada" => date("Y-m-d h:i:s")
            );
            
            $this->model->insert("log", $data_log);
            $this->model->update('profil', $data_profil, ['id_user' => $id_user]);
            $result =  array(
                'result' => $this->model->update('user', $data_user, ['id_user' => $id_user]),
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            );
        }
        echo json_encode($result);
    }

    public function aksi_hapus()
    {
            $id_user = $this->input->post("id_user");
            $row = $this->model->get_where($this->main_table, ['id_user' => $id_user]);
            if ($row) {
                $get = $row->row();
                if (!empty($get->foto)) {
                    unlink('upload/'.$get->foto);
                }
                $data_log = array(
                    "aktivitas" =>  $this->session->userdata('username')." menghapus data user ". $get->nama,
                    "oleh" => $this->session->userdata('username'),
                    "pada" => date("Y-m-d h:i:s")
                );
                $this->model->insert("log", $data_log);
                $this->model->delete('profil', ['id_user' => $id_user]);
                $result =  array(
                    'result' => $this->model->delete('user', ['id_user' => $id_user]),
                    'csrfName' => $this->security->get_csrf_token_name(),
                    'csrfHash' => $this->security->get_csrf_hash()
                );
                echo json_encode($result);

            } else {
                $result =  array(
                    'result' => $this->session->set_flashdata('pesan', 'data tid_userak ada'),
                    'csrfName' => $this->security->get_csrf_token_name(),
                    'csrfHash' => $this->security->get_csrf_hash()
                );
                echo json_encode($result);
            }
    }

    private function hash_password($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

    private function do_upload()
    {

        $config['upload_path']          = 'upload/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             =  2000;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!is_dir('upload/')) {
            mkdir('upload/', 0777, true);
        }

        if (!$this->upload->do_upload('foto')) //upload and validate
        {
            $this->form_validation->set_message('foto', $data['error'] = $this->upload->display_errors());

            if ($_FILES['foto']['error'] != 4) {
                return false;
            }
        }
        return $this->upload->data('file_name');
    }
}
