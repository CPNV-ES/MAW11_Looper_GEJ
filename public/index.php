<?php

session_start();

define('BASE_DIR', dirname(__FILE__) . '/..');
define('SOURCE_DIR', BASE_DIR . '/src');
define('VIEW_DIR', SOURCE_DIR . '/views');
define('CONTROLLER_DIR', SOURCE_DIR . '/controllers');
define('MODEL_DIR', SOURCE_DIR . '/models');

require BASE_DIR . '/vendor/autoload.php';
require CONTROLLER_DIR . '/error.php';
require MODEL_DIR . '/router.php';

$_ENV = parse_ini_file(BASE_DIR . '/.env');

$request_uri = $_SERVER['REQUEST_URI'] ?? '/';
$request_uri = explode('?', $request_uri)[0];

$router = new Router(CONTROLLER_DIR);
if (!$router->run($_SERVER['REQUEST_METHOD'], $request_uri)) {
	lost();
}
// try {

// } catch (\Throwable $e) {
// 	serverError($e->getTraceAsString());
// }

// function getRedirection($redirect_uri)
// {
// 	if (preg_match("/^\/exercises\/([0-9]+)$/", $redirect_uri, $str)) {
// 		deleteExercise($str[1]);
// 		return;
// 	}
// 	switch ($redirect_uri) {
// 		case '/':
// 			home();
// 			break;
// 		case '/exercises':
// 			manageExercises();
// 			break;
// 		case '/exercises/answering':
// 			takeAnExercises();
// 			break;
// 		case '/exercises/new':
// 			createAnExercises();
// 			break;
// 		case (preg_match('/^\/exercises\/([0-9]+)$/A', $redirect_uri, $output_array) ? true : false):
// 			changeStateOfExercise($output_array[1]);
// 			break;
// 		default:
// 			lost();
// 	}
// }

// function postRedirection($redirect_uri)
// {
// 	switch ($redirect_uri) {
// 		case '/exercises':
// 			createExercise();
// 			break;
// 		default:
// 			lost();
// >>>>>>> develop
