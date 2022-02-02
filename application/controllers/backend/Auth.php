<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
    }

    function index()
    {
        if ($this->session->userdata('session_web') == true) {
            redirect('admin/dashboard');
        }else{
            $data['title'] = 'Auth';
            $data['action'] = 'auth/masuk';
            return view('backend.auth.index', $data);
        }
         
    }

    public function daftar(){
        $data = array(
            'title' =>  'Daftar',
            'form_id'=>'form-daftar',
            'nama' => set_value('nama'),
            'no_hp' => set_value('no_hp'),
            'username' => set_value('username'),
            'password' => set_value('password'),
        );

        return view('backend.auth.daftar', $data);
    }

    public function aksi_daftar(){
        $this->form_validation->set_rules('username', '', 'trim|required|is_unique[user.username]', array('is_unique' => 'Username sudah pernah terdaftar', 'trim' => '', 'required' => 'Username harus diisi.'));
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|callback__passwordRegex',  array('trim' => '', 'required' => 'Password wajib diisi.', 'min_length' => 'Minimal 8 karakter.'));
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]',  array('trim' => '', 'required' => 'Konfirmasi password wajib diisi.', 'matches' => 'Konfirmasi Password tidak cocok.'));
        $this->form_validation->set_rules('nama', '', 'trim|required', array('trim' => '', 'required' => 'Nama Lengkap harus diisi.'));
		$this->form_validation->set_rules('no_hp', '', 'numeric|trim|required|min_length[10]|max_length[12]|is_unique[profil.no_hp]', array('trim' => '', 'required' => 'No. HP wajib diisi.', 'min_length'=> 'Minimal 10 Digit', 'max_length'=> 'Maksimal 12 Digit'));
        if (empty($_FILES['foto']['name'])) {
            $this->form_validation->set_rules('foto', '', 'required|file_type[images/jpg|images/jpeg|images/png]', array('required' => 'Foto harus dipilih.'));
        }
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $result = array(
                'error'   => true,
                'username_error' => form_error('username'),
                'password_error' => form_error('password'),
                'passconf_error' => form_error('passconf'),
                'nama_error' => form_error('nama'),
                'no_hp_error' => form_error('no_hp'),
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            );
            if (!empty(form_error('foto'))) {
                $result['foto_error'] = form_error('foto');
            } else {
                $result['foto_error'] = '';
            }
        } else {
            $data_user = array(
                'username' => $this->input->post('username'),
                'password' => $this->hash_password($this->input->post('password'), TRUE),
                'created_by' => $this->input->post('username'),
                'created_on' => date('Y-m-d H:i:s')
            );

            $this->model->insert('user', $data_user);
            $get_id_user = $this->db->insert_id();
            $data_profil = array(
                'id_user' => $get_id_user,
                'nama' => $this->input->post('nama'),
                'no_hp' => $this->input->post('no_hp')
            );

            if (!empty($_FILES['foto']['name'])) {
                $upload = $this->do_upload();
                $data_profil['foto'] = $upload;
          
            } 

            $data_log = array(
                "aktivitas" => $this->session->userdata('username')." mengubah data user ". $this->input->post("nama"),
                "oleh" => $this->session->userdata('username'),
                "pada" => date("Y-m-d h:i:s")
            );
            $this->model->insert("log", $data_log);
           
            $result =  array(
                'result' => $this->model->insert('profil', $data_profil),
                'csrfName' => $this->security->get_csrf_token_name(),
                'csrfHash' => $this->security->get_csrf_hash()
            );
        }
        echo json_encode($result);
    }

    public function masuk()
    {   
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $data_admin = $this->model->get_where('admin', ['username'=> $username]);
        $data_user = $this->model->get_where('view_user_profil', ['username'=> $username]);
        if(isset($username)){
            if ($data_admin->num_rows() > 0) {
                $data = $data_admin->row();
                $hash = $data->password;
                if ((password_verify($password, $hash))) {
                        $sesi = array(
                            'id_admin' => $data->id_admin,
                            'username' => $data->username,
                            'pengguna' => 'admin',
                            'session_web' => true,
                        );
                    $data_log = array(
                        "aktivitas" => $sesi['username'].' telah login ke sistem',
                        "oleh" => $sesi['username'],
                        "pada" => date("Y-m-d h:i:s")
                    );
                    $this->model->insert('log', $data_log);
                    $this->session->set_userdata($sesi);
                    $result['success'] = true;
                    $result['pengguna'] = 'admin';
                }else{
                    $result['error'] = true;
                    $result['alert'] = "Username atau password salah";
                }
            }elseif($data_user->num_rows() > 0){
                $data = $data_user->row();
                $hash = $data->password;
                if ((password_verify($password, $hash))) {
                    if($data->status == 'aktif'){
                        $sesi = array(
                            'id_user' => $data->id_user,
                            'nama' => $data->nama,
                            'no_hp' => $data->no_hp,
                            'username' => $data->username,
                            'token' => $data->token,
                            'status' => $data->status,
                            'pengguna' => 'user',
                            'session_web' => true,
                        );
                        $data_log = array(
                            "aktivitas" => $sesi['username'].' telah login ke sistem',
                            "oleh" => $sesi['username'],
                            "pada" => date("Y-m-d h:i:s")
                        );
                        $this->model->insert('log', $data_log);
                        $this->session->set_userdata($sesi);
                        $result['success'] = true;
                        $result['pengguna'] = 'user';
                    }else{
                        $result['error'] = true;
                        $result['alert'] = 'Maaf akun anda tidak aktif, silahkan bayar 10 juta ke rekening admin untuk mengaktifkannya';
                    }

                }else{
                    $result['error'] = true;
                    $result['alert'] = "Username atau password salah";
                }
            } else {
                    $result['error'] = true;
                    $result['alert'] = "Username tidak ditemukan";
            }
        }else {
            $result['error'] = true;
            $result['alert'] = "Username atau password tidak boleh kosong";
        }
        $result['csrfName'] = $this->security->get_csrf_token_name();
        $result['csrfHash'] = $this->security->get_csrf_hash();
        echo json_encode($result);
    }

 

    public function keluar()
    {
        $sesi_selesai = array(
            'id_user' => 'id_user',
            'nama' => 'nama',
            'no_hp' => 'no_hp',
            'username' => 'username',
            'token' => 'token',
            'status' => 'status',
            'pengguna' => 'pengguna',
            'session_web' => 'session_web',
        );

        $data_log = array(
            'aktivitas' => $this->session->userdata('username').' telah logout dari sistem',
            "oleh" => $this->session->userdata('username'),
            "pada" => date("Y-m-d h:i:s")
        );
        $this->model->insert('log', $data_log);
        $this->session->unset_userdata($sesi_selesai);
        redirect('auth');
    }

    public function _passwordRegex($password) {
		if (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-_]).{8,}$/', $password ) ) 
		{
		$this->form_validation->set_message('_passwordRegex', 'Format password tidak sesuai');
		  return FALSE;
		}
		else 
		{
		  return TRUE;
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
