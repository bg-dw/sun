<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
	return view('notFound');
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
$routes->post('/auth', 'Login::auth');
$routes->get('/logout', 'Login::logout');
$routes->get('/admin/home', 'admin\Home::index');
$routes->get('/admin/presensi', 'admin\Presensi::index');
$routes->get('/admin/rekap-presensi', 'admin\Presensi::rekap');

//data master periode
$routes->get('/admin/data-periode', 'admin\MasterPeriode::index');

//data master guru
$routes->get('/admin/data-guru', 'admin\MasterGuru::index');

$routes->get('/admin/data-siswa', 'admin\MasterSiswa::index');
$routes->post('/admin/import/siswa', 'admin\MasterSiswa::importCsv');
// $routes->post('/admin/add/rfid', 'admin\Siswa::add_rfid');
// $routes->post('/admin/edit/rfid', 'admin\Siswa::edit_rfid');

//data master kelas
$routes->get('/admin/data-kelas', 'admin\MasterKelas::index');

//data master presensi
$routes->get('/admin/data-presensi', 'admin\MasterPresensi::index');

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