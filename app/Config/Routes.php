<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

$encrypter = Services::encrypter();
// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function () {
	throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
});
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Dashboard::index');
$routes->get('/beranda', 'Dashboard::index');
$routes->get('/scan', 'Dashboard::scan');
$routes->post('/show', 'Dashboard::get_absen');
$routes->post('/inp', 'Dashboard::put_absen');
$routes->post('/get_last', 'Dashboard::get_total');

//Login
$routes->get(bin2hex('/login'), 'Login::index');
$routes->post(bin2hex('/auth'), 'Login::auth');
$routes->get(bin2hex('/logout'), 'Login::logout');
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('home'), 'admin\Home::index');
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('get_siswa_kelas'), 'admin\Home::get_siswa_kelas');
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('get_absen_today'), 'admin\Home::get_absen_today');

//presensi
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('presensi'), 'admin\Presensi::index');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('presensi'), 'admin\Presensi::index');
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('rekap-presensi'), 'admin\Presensi::rekap');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('rekap-presensi'), 'admin\Presensi::rekap');

//data master periode
$routes->get('/admin/data-periode', 'admin\MasterPeriode::index');

//data master guru
$routes->get('/admin/data-guru', 'admin\MasterGuru::index');
$routes->post('/admin/guru/add', 'admin\MasterGuru::add');
$routes->post('/admin/guru/update', 'admin\MasterGuru::update');
$routes->post('/admin/guru/delete', 'admin\MasterGuru::delete');

$routes->get('/admin/data-siswa', 'admin\MasterSiswa::index');
$routes->post('/admin/import/siswa', 'admin\MasterSiswa::importCsv');

//data master kelas
$routes->get('/admin/data-kelas', 'admin\MasterKelas::index');
$routes->post('/admin/kelas/add', 'admin\MasterKelas::add');

//data master presensi
$routes->get('/admin/data-presensi', 'admin\MasterPresensi::index');
$routes->post('/admin/presensi/add', 'admin\MasterPresensi::add');
$routes->post('/admin/edit/rfid', 'admin\MasterPresensi::edit_rfid');


//Guru
$routes->get('/' . bin2hex('guru') . '/' . bin2hex('home'), 'guru\Home::index');
$routes->get('/' . bin2hex('guru') . '/' . bin2hex('get_siswa_kelas'), 'guru\Home::get_siswa_kelas');
$routes->get('/' . bin2hex('guru') . '/' . bin2hex('get_absen_today'), 'guru\Home::get_absen_today');

//Presensi Guru
$routes->get('/' . bin2hex('guru') . '/' . bin2hex('presensi'), 'guru\Presensi::index');
$routes->post('/' . bin2hex('guru') . '/' . bin2hex('presensi'), 'guru\Presensi::index');
$routes->get('/' . bin2hex('guru') . '/' . bin2hex('edit-presensi'), 'guru\Presensi::update');
$routes->get('/' . bin2hex('guru') . '/' . bin2hex('edit-presensi') . '/(:num)/(:num)/(:any)', 'guru\Presensi::update/$1/$2/$3');
$routes->post('/' . bin2hex('guru') . '/' . bin2hex('edit-presensi'), 'guru\Presensi::update');
$routes->post('/' . bin2hex('guru') . '/' . bin2hex('aksi-edit-presensi') . '/(:num)/(:num)/', 'guru\Presensi::ac_update/$1/$2');
$routes->get('/' . bin2hex('guru') . '/' . bin2hex('rekap-presensi'), 'guru\Presensi::rekap');
$routes->post('/' . bin2hex('guru') . '/' . bin2hex('rekap-presensi'), 'guru\Presensi::rekap');
$routes->get('/' . bin2hex('guru') . '/' . bin2hex('data-siswa'), 'guru\MasterSiswa::index');
$routes->post('/' . bin2hex('guru') . '/' . bin2hex('set-presensi'), 'guru\Presensi::set_presensi');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}