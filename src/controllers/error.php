<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description This file contains functions to handle various error responses such as 404 Not Found
 */

/**
 * Send a 404 Not Found error page.
 *
 * @param  int $return_code The HTTP response code to send. Default is 404.
 * @param  string $error_message The error message to display. Default is 'Page not found'.
 * @return void
 */
function lost($return_code = 404, $error_message = 'Page not found')
{
	include VIEW_DIR . '/errors/error.php';
}

/**
 * Send a generic error with a specified return code and message.
 *
 * @param int $return_code The HTTP response code to send.
 * @param string $error_message The error message to display.
 * @return void
 */
function error($return_code, $error_message)
{
	include VIEW_DIR . '/errors/error.php';
}

/**
 * Send a 400 Bad Request error page.
 *
 * @param int $return_code The HTTP response code to send. Default is 400.
 * @param string $error_message The error message to display. Default is 'Bad Request'.
 * @return void
 */
function badRequest($return_code = 400, $error_message = 'Bad Request')
{
	include VIEW_DIR . '/errors/error.php';
}

/**
 * Send a 401 Unauthorized error page.
 *
 * @param int $return_code The HTTP response code to send. Default is 401.
 * @param string $error_message The error message to display. Default is 'Unauthorized'.
 * @return void
 */
function unauthorized($return_code = 401, $error_message = 'Unauthorized')
{
	include VIEW_DIR . '/errors/error.php';
}

/**
 * Send a 500 Internal Server Error page.
 *
 * @param int $return_code The HTTP response code to send. Default is 500.
 * @param string $error_message The error message to display. Default is 'Server Error'.
 * @return void
 */
function serverError($return_code = 500, $error_message = 'Server Error')
{
	include VIEW_DIR . '/errors/error.php';
}
