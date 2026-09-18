<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Products::index');
$routes->get('products/new', 'Products::new');
$routes->post('products', 'Products::create');
$routes->get('products/(:num)/edit', 'Products::edit/$1');
$routes->post('products/(:num)', 'Products::update/$1');
$routes->post('products/(:num)/delete', 'Products::delete/$1');
$routes->get('products/(:num)/buy', 'Shop::buy/$1');
$routes->post('purchases', 'Shop::purchase');
