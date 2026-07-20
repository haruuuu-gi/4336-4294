<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', static function () {
    return redirect()->to('/client/login');
});


$routes->get('client/login', 'Client\AuthController::login');
$routes->post('client/login', 'Client\AuthController::processLogin');
$routes->get('client/logout', 'Client\AuthController::logout');

$routes->group('client', ['filter' => 'clientAuth'], static function ($routes) {
    $routes->get('dashboard', 'Client\DashboardController::index');

    $routes->get('depot', 'Client\OperationController::depot');
    $routes->post('depot', 'Client\OperationController::processDepot');

    $routes->get('retrait', 'Client\OperationController::retrait');
    $routes->post('retrait', 'Client\OperationController::processRetrait');

    $routes->get('transfert', 'Client\OperationController::transfert');
    $routes->post('transfert', 'Client\OperationController::processTransfert');

    $routes->get('historique', 'Client\HistoriqueController::index');
});


$routes->get('admin/login', 'Admin\AuthController::login');
$routes->post('admin/login', 'Admin\AuthController::processLogin');
$routes->get('admin/logout', 'Admin\AuthController::logout');

$routes->group('admin', ['filter' => 'adminAuth'], static function ($routes) {
    $routes->get('dashboard', 'Admin\DashboardController::index');

    $routes->get('utilisateurs', 'Admin\UserController::index');
    $routes->post('utilisateurs', 'Admin\UserController::create');
    $routes->get('utilisateurs/(:num)/toggle', 'Admin\UserController::toggle/$1');
    $routes->get('utilisateurs/(:num)/delete', 'Admin\UserController::delete/$1');

    $routes->get('prefixes', 'Admin\PrefixController::index');
    $routes->post('prefixes', 'Admin\PrefixController::create');
    $routes->get('prefixes/(:num)/toggle', 'Admin\PrefixController::toggle/$1');
    $routes->get('prefixes/(:num)/delete', 'Admin\PrefixController::delete/$1');

    $routes->get('types-operation', 'Admin\OperationTypeController::index');
    $routes->post('types-operation', 'Admin\OperationTypeController::create');
    $routes->get('types-operation/(:num)/toggle', 'Admin\OperationTypeController::toggle/$1');

    $routes->get('types-operation/(:num)/baremes', 'Admin\BaremeController::index/$1');
    $routes->post('types-operation/(:num)/baremes', 'Admin\BaremeController::create/$1');
    $routes->get('baremes/(:num)/delete', 'Admin\BaremeController::delete/$1');

    $routes->get('gains', 'Admin\GainController::index');

    
    $routes->get('comptes', 'Admin\CompteController::index');
});
