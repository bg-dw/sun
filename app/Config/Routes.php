<?php

namespace Config;

use App\Models\M_guru;

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
$routes->get('/generate_code', 'Dashboard::generate');
$routes->post('/unlock', 'Dashboard::unlock');
$routes->get('/beranda', 'Dashboard::index');
$routes->get('/scan', 'Dashboard::scan');
$routes->get('/auto', 'Dashboard::auto_task');
$routes->post('/show', 'Dashboard::get_absen');
$routes->post('/inp', 'Dashboard::put_absen');
$routes->post('/get_last', 'Dashboard::get_total');

//Login
$routes->get('/' . bin2hex('login'), 'Login::index');
$routes->post('/' . bin2hex('auth'), 'Login::auth');
$routes->get('/' . bin2hex('logout'), 'Login::logout');
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('home'), 'admin\Home::index');
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('get_siswa_kelas'), 'admin\Home::get_siswa_kelas');
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('get_absen_today'), 'admin\Home::get_absen_today');

//presensi
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('presensi'), 'admin\Presensi::index');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('presensi'), 'admin\Presensi::index');
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('rekap-presensi'), 'admin\Presensi::rekap');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('rekap-presensi'), 'admin\Presensi::rekap');

//data master periode
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('data-periode'), 'admin\MasterPeriode::index');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('data-periode') . '/' . bin2hex('add'), 'admin\MasterPeriode::ac_add');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('data-periode') . '/' . bin2hex('update'), 'admin\MasterPeriode::ac_update');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('data-periode') . '/' . bin2hex('set-status'), 'admin\MasterPeriode::ac_update_status');

//data master guru
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('data-guru'), 'admin\MasterGuru::index');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('guru') . '/' . bin2hex('add'), 'admin\MasterGuru::add');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('guru') . '/' . bin2hex('update'), 'admin\MasterGuru::update');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('guru') . '/' . bin2hex('delete'), 'admin\MasterGuru::delete');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('guru') . '/' . bin2hex('set-status'), 'admin\MasterGuru::ac_update_status');

//data master siswa
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('data-siswa'), 'admin\MasterSiswa::index');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('import') . '/' . bin2hex('siswa'), 'admin\MasterSiswa::importCsv');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('upload_foto') . '/' . bin2hex('siswa'), 'admin\MasterSiswa::ac_upload_foto');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('siswa') . '/' . bin2hex('add'), 'admin\MasterSiswa::ac_add');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('siswa') . '/' . bin2hex('update'), 'admin\MasterSiswa::ac_update');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('siswa') . '/' . bin2hex('delete'), 'admin\MasterSiswa::ac_delete');
$routes->post('/' . bin2hex('admin/siswa/get/foto'), 'admin\MasterSiswa::get_foto');

//data master kelas
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('data-kelas'), 'admin\MasterKelas::index');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('kelas') . '/' . bin2hex('add'), 'admin\MasterKelas::add');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('kelas') . '/' . bin2hex('update'), 'admin\MasterKelas::update');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('kelas') . '/' . bin2hex('delete'), 'admin\MasterKelas::delete');

//data master presensi
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('data-presensi'), 'admin\MasterPresensi::index');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('presensi') . '/' . bin2hex('add'), 'admin\MasterPresensi::add');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('presensi') . '/' . bin2hex('update'), 'admin\MasterPresensi::update');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('presensi') . '/' . bin2hex('delete'), 'admin\MasterPresensi::delete');
$routes->post('/' . bin2hex('admin') . '/' . bin2hex('edit') . '/' . bin2hex('rfid'), 'admin\MasterPresensi::edit_rfid');

//Akun ADMIN
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('update-username'), 'admin\Akun::update_uname');
$routes->get('/' . bin2hex('admin') . '/' . bin2hex('update-password'), 'admin\Akun::update_pass');
$routes->post('/' . bin2hex('admin/cek-username-lama'), 'admin\Akun::cek_uname_lama');
$routes->post('/' . bin2hex('admin/update/username'), 'admin\Akun::ac_set_uname');
$routes->post('/' . bin2hex('admin/cek-password-lama'), 'admin\Akun::cek_pass_lama');
$routes->post('/' . bin2hex('admin/update/password'), 'admin\Akun::ac_set_password');
$routes->post('/' . bin2hex('admin/guru/cek-username'), 'admin\MasterGuru::cek_uname');
$routes->post('/' . bin2hex('admin/guru/update/username'), 'admin\MasterGuru::ac_set_uname');
$routes->post('/' . bin2hex('admin/guru/update/password'), 'admin\MasterGuru::ac_set_password');


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

// Akun Guru
$routes->get('/' . bin2hex('guru') . '/' . bin2hex('update-username'), 'guru\Akun::update_uname');
$routes->post('/' . bin2hex('guru/cek-username-lama'), 'guru\Akun::cek_uname_lama');
$routes->post('/' . bin2hex('guru/cek-username'), 'guru\Akun::cek_uname');
$routes->post('/' . bin2hex('guru/update/username'), 'guru\Akun::ac_set_uname');
$routes->get('/' . bin2hex('guru') . '/' . bin2hex('update-password'), 'guru\Akun::update_pass');
$routes->post('/' . bin2hex('guru/cek-password-lama'), 'guru\Akun::cek_pass_lama');
$routes->post('/' . bin2hex('guru/update/password'), 'guru\Akun::ac_set_password');
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