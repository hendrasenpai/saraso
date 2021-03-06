<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete reads:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['auth'] = 'backend/auth';
$route['auth/daftar'] = 'backend/auth/daftar';
$route['auth/aksi_daftar'] = 'backend/auth/aksi_daftar';
$route['auth/masuk'] = 'backend/auth/masuk';
$route['auth/keluar'] = 'backend/auth/keluar';

//ADMIN
$route['admin/dashboard'] = 'backend/admin/dashboard';
$route['admin/dashboard/(:any)'] = 'backend/admin/dashboard/$1';
$route['admin/dashboard/(:any)/(:any)'] = 'backend/admin/dashboard/$1/$2';

$route['admin/transaksi'] = 'backend/admin/transaksi';
$route['admin/transaksi/(:any)'] = 'backend/admin/transaksi/$1';
$route['admin/transaksi/(:any)/(:any)'] = 'backend/admin/transaksi/$1/$2';

$route['admin/user'] = 'backend/admin/user';
$route['admin/user/(:any)'] = 'backend/admin/user/$1';
$route['admin/user/(:any)/(:any)'] = 'backend/admin/user/$1/$2';

$route['admin/menu'] = 'backend/admin/menu';
$route['admin/menu/(:any)'] = 'backend/admin/menu/$1';
$route['admin/menu/(:any)/(:any)'] = 'backend/admin/menu/$1/$2';

//USER
$route['user/dashboard'] = 'backend/user/dashboard';
$route['user/dashboard/(:any)'] = 'backend/user/dashboard/$1';
$route['user/dashboard/(:any)/(:any)'] = 'backend/user/dashboard/$1/$2';

$route['user/profil'] = 'backend/user/profil';
$route['user/profil/(:any)'] = 'backend/user/profil/$1';
$route['user/profil/(:any)/(:any)'] = 'backend/user/profil/$1/$2';

$route['user/transaksi'] = 'backend/user/transaksi';
$route['user/transaksi/(:any)'] = 'backend/user/transaksi/$1';
$route['user/transaksi/(:any)/(:any)'] = 'backend/user/transaksi/$1/$2';

