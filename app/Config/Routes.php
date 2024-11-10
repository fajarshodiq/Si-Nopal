<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute Home
$routes->get('/', 'Home::index');
$routes->get('/validasi', 'Home::validasi_view');

//rute cek
$routes->post('home/check_status', 'Home::check_status');
$routes->post('/home/validate_akta_cerai', 'Home::validate_akta_cerai');


// Rute Login
$routes->get('/login', 'Auth::login');  // Menampilkan form login
$routes->post('/auth/loginAuth', 'Auth::loginAuth'); // Memproses form login
$routes->get('/logout', 'Auth::logout'); // Proses logout

//Rute Dashboard
$routes->get('/admin', 'Admin::index'); //Dashboard

// Rute Admin data perkara
$routes->get('/admin/dataperkara/', 'Admin::dataPerkara'); //data perkara
$routes->post('/admin/save', 'Admin::tambahPerkara'); // Menambah data perkara
$routes->post('/admin/update/(:num)', 'Admin::updatePerkara/$1'); // Rute untuk menangani pembaruan
$routes->get('/admin/delete/(:num)', 'Admin::deletePerkara/$1'); // Route for deleting perkara

//Rute Akta Cerai
$routes->get('/admin/aktacerai/', 'Admin::dataAktaCerai'); //data Akta Cerai
$routes->post('/admin/saveaktacerai/', 'Admin::saveAktaCerai'); //Terbitkan Akta Cerai
$routes->post('/admin/updateaktacerai/(:num)', 'Admin::updateAktaCerai/$1'); //Terbitkan Akta Cerai
$routes->get('admin/deleteAktaCerai/(:num)', 'Admin::deleteAktaCerai/$1'); //hapus Akta Cerai

//reminder
$routes->get('/admin/reminder/', 'Admin::reminder');
$routes->post('/admin/sendReminder', 'Admin::sendReminderNotification');

//User
$routes->get('/admin/user/', 'Admin::User');
$routes->post('/admin/updateUser/', 'Admin::updateUser');

//setting
$routes->get('/admin/setting/', 'Admin::setting');
$routes->post('/admin/saveSetting/', 'Admin::saveSetting');
