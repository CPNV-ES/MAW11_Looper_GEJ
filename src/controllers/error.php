<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description This file have function to show an error page when the user is not allowed to access
 */

/**
 * send a 404 error code with a page not found
 *
 * @param  int $return_code
 * @param  string $error_message
 * @return void
 */
function lost($return_code = 404, $error_message = 'Page not found')
{
	include VIEW_DIR . '/errors/error.php';
}

/**
 * send a generic error specify the return code and error message
 *
 * @param  int $return_code
 * @param  string $error_message
 * @return void
 */
function error($return_code, $error_message)
{
	include VIEW_DIR . '/errors/error.php';
}

/**
 * send a 400 error code with a Bad Request
 *
 * @param  int $return_code
 * @param  string $error_message
 * @return void
 */
function badRequest($return_code = 400, $error_message = 'Bad Request')
{
	include VIEW_DIR . '/errors/error.php';
}

/**
 * send a 401 error code with an Unauthorized
 *
 * @param  int $return_code
 * @param  string $error_message
 * @return void
 */
function unauthorized($return_code = 401, $error_message = 'Unauthorized')
{
	include VIEW_DIR . '/errors/error.php';
}

/**
 * send a 500 error code with a Server Error
 *
 * @param  int $return_code
 * @param  string $error_message
 * @return void
 */
function serverError($return_code = 500, $error_message = 'Server Error')
{
	include VIEW_DIR . '/errors/error.php';
}
