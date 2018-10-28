<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['users/login'] = 'auth/login';
$route['users/signup'] = 'users/signup';
$route['users/logout'] = 'auth/logout';
$route['users/role'] = 'role';
$route['users/role/add'] = 'role/add';
$route['users/role/view'] = 'role/view';
$route['users/role/edit/(:num)'] = 'role/edit/$1';
$route['users/role/delete/(:num)'] = 'role/delete/$1';
$route['users/role/default/(:num)'] = 'role/set_default/$1';

$route['users/validate/(:any)'] = 'auth/activate_account/$1';

//die("My master asked me to stop here");
