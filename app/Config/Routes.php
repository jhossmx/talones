<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/', 'Home::index');

$routes->get('/', 'Login::index', ['as' => 'login']);
$routes->get('registro', 'Login::registro', ['as' => 'registro']); //carga formalario de registro
$routes->post('registrar', 'Login::registrar', ['as' => 'registrar']); //registra un nuevo usuario

$routes->post('validalogin', 'Login::validalogin', ['as' => 'validalogin']);
$routes->get('logout', 'Login::logout', ['as' => 'logout']);

//dashboard principal
$routes->post('principal', 'Principal::index', ['as' => 'principal', 'filter' => 'auth']);

/* ----- metodos de los pagos ------- */
$routes->get('pagos', 'Pagos::index', ['as' => 'pagos.index', 'filter' => 'auth']); //Listar los pagos realizados
$routes->get('importarpagos', 'Pagos::importarPagos', ['as' => 'importar', 'filter' => 'auth']); // importar pagos

$routes->post('procesarpagos', 'Pagos::procesar', ['as' => 'pagos.procesar', 'filter' => 'auth']);
$routes->post('procesararchivos', 'Pagos::procesarArchivos', ['as' => 'procesararchivos', 'filter' => 'auth']);
$routes->post('deletepagos', 'Pagos::deletePagos', ['as' => 'deletePagos' , 'filter' => 'auth']);


$routes->post('filtrarpagos', 'Pagos::filtrar', ['as' => 'pagos.filtrar', 'filter' => 'auth']);
$routes->post('getTotalespagos', 'Pagos::getTotalespagos', ['as' => 'pagos.getTotalespagos', 'filter' => 'auth']);

$routes->post('getTotalespagos', 'Pagos::getTotalespagos', ['as' => 'pagos.getTotalespagos', 'filter' => 'auth']);
$routes->get('reporteExcel/(:num)', 'Excelexport::index/$1', ['as' => 'excel.index' , 'filter' => 'auth']);
$routes->get('reporte/(:num)/(:any)/(:any)/(:any)', 'Excelexport::generarReporteExcel/$1/$2/$3/$4', ['as' => 'excel']);


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
