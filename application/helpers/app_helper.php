<?php
defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
define("ASSETS_BACKEND", base_url('assets/backend/'));
define("ASSETS_FRONTEND", base_url('assets/frontend/'));

date_default_timezone_set("Asia/Bangkok");
   

if ( ! function_exists('shortdate'))
{
    function shortdate($tanggal)
    {
        return date('d-m-Y H:i', strtotime($tanggal)).' wib';
    }
}

if ( ! function_exists('tgl_indo'))
{
function tgl_indo($tanggal, $cetak_hari = true)
	{
		$potong = explode(' ', $tanggal);
		$tgl = $potong[0];
		$jam = $potong[1];
		$hari = array(
			1 =>    'Senin',
			'Selasa',
			'Rabu',
			'Kamis',
			'Jumat',
			'Sabtu',
			'Minggu'
		);

		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$split 	  = explode('-', $tgl);

		$tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0] . ' ' . $jam;

		if ($cetak_hari) {
			$num = date('N', strtotime($tgl));
			return $hari[$num] . ', ' . $tgl_indo;
		}
		return $tgl_indo;
    }
}

function option($table)
{
    $ci = &get_instance();
    $query = $ci->db->get($table);
    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return array();
    }
}


function url_helper(){
    $url = "";
    return $url;
}


