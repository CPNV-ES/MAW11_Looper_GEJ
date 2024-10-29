<?php

function lost($return_code = 404, $error_message = 'Page not found')
{
	include VIEW_DIR . '/errors/error.php';
}

function error($return_code, $error_message)
{
	include VIEW_DIR . '/errors/error.php';
}

function badRequest($return_code = 400, $error_message = 'Bad Request')
{
	include VIEW_DIR . '/errors/error.php';
}

function serverError($return_code = 500, $error_message = 'Server Error')
{
	include VIEW_DIR . '/errors/error.php';
}
