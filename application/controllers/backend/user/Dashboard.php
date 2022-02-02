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
        if( $this->session->userdata('pengguna') != 'user'){
            redirect(site_url('admin/dashboard'));
        }
    
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        return view('backend.user.dashboard.index', $data);
    }

}
