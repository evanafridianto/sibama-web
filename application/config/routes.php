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
| Please see the user guide for complete details:
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
$route['default_controller'] = 'WebController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// default web
$route['/'] = 'WebController';


// admin 
$route['admin/dashboard'] = 'admin/DashboardController';
$route['admin/data-master/drainase'] = 'admin/DrainaseController';
$route['admin/data-master/jalan'] = 'admin/JalanController';
$route['admin/data-master/kelurahan'] = 'admin/KelurahanController';
$route['admin/data-master/kecamatan'] = 'admin/KecamatanController';
$route['admin/data-master/user'] = 'admin/UserController';
$route['admin/data-master/kondisi-penanganan'] = 'admin/KondisiPenangananDrainaseController';
$route['admin/r24'] = 'admin/R24Controller';
$route['admin/peta'] = 'admin/PetaController';
// login 
$route['login'] = 'admin/AuthController';