<?php

class Router
{
	private array $controller_entry = [];

	public function __construct(string $controller_dir)
	{
		if (!is_dir($controller_dir) || !is_readable($controller_dir)) {
			throw new Exception('Controller directory does not exist or is unreadable');
		}

		$dir = scandir($controller_dir);

		foreach ($dir as $file) {
			if (in_array($file, ['.', '..'])) {
				continue;
			}
			include_once CONTROLLER_DIR . "/$file";

			if (!isset($entry)) {
				continue;
			}

			foreach ($entry as $class => $routes) {
				$this->controller_entry[$class] = $routes;
			}
		}
	}

	public function run($request_method, $request_uri)
	{
		foreach ($this->controller_entry as $class => $routes) {
			if (!isset($routes[$request_method])) {
				continue;
			}

			if ($this->callRoute($request_method, $request_uri, $class, $routes)) {
				return true;
			}
		}
		return false;
	}

	private function callRoute($request_method, $request_uri, $class, $routes)
	{
		foreach ($routes[$request_method] as $route => $method) {
			$same_route = $this->isSameRoute($route, request_uri: $request_uri);

			if (is_array($same_route)) {
				eval('$inst = new ' . $class . ';');

				if (sizeof($same_route) > 0) {
					foreach ($same_route as $route_id => $route_value) {
						$method = str_replace($route_id, '(' . explode(':', $route_id)[2] . ")\"$route_value\"", $method);
					}
				}
				try {
					eval('$inst->' . $method . ';');
				} catch (LooperException $e) {
					error($e->getReturnCode(), $e->getErrorMessage());
				}
				return true;
			}
		}
		return false;
	}

	private function isSameRoute($route, $request_uri)
	{
		$variable_in_route = [];
		$request_method_splitted = explode('/', $request_uri);
		$route_splitted = explode('/', $route);

		if (sizeof($request_method_splitted) != sizeof($route_splitted)) {
			return false;
		}

		foreach ($route_splitted as $key => $value) {
			if ($value != $request_method_splitted[$key]) {
				if ($value[0] == ':') {
					if (!$this->checkRegexAndTypeMatch($value, $request_method_splitted[$key])) {
						return false;
					}
					$variable_in_route[$value] = $request_method_splitted[$key];
				} else {
					return false;
				}
			}
		}

		return $variable_in_route;
	}

	private function checkRegexAndTypeMatch($routeKey, $routeValue)
	{
		$routeKeySplitted = explode(':', $routeKey);

		if (!isset($routeKeySplitted[2])) {
			return false;
		}

		switch ($routeKeySplitted[2]) {
			case 'string':
				return preg_match('/^[a-zA-Z0-9_ -]{1,}$/', $routeValue) != 0;
			case 'int':
				return preg_match('/^[0-9]{1,}$/', $routeValue) != 0;
			default:
				return false;
		}
	}
}
