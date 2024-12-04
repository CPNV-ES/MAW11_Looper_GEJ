<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  This is the router buiness logic and route path
 */


/**
 * This class is the router buiness logic of the application
 */
class Router
{
	private array $controller_entry = [
		'ExerciseController()' => [
			'GET' => [
				'/exercises/:id:int' => 'changeStateOfExercise(:id:int)',
				'/exercises/:id:int/delete' => 'deleteExercise(:id:int)'
			],
			'POST' => [
				'/exercises' => 'createExercise()'
			],
			'controller_file_name' => 'exercise_controller.php'
		],
		'FieldController()' => [
			'GET' => [
				'/exercises/:id:int/fields/:idFields:int' => 'deleteField(:id:int, :idFields:int)'
			],
			'POST' => [
				'/exercises/:id:int/fields' => 'createField(:id:int)',
				'/exercises/:id:int/fields/:idFields:int' => 'editField(:id:int, :idFields:int)'
			],
			'controller_file_name' => 'field_controller.php'
		],
		'FulfillmentController()' => [
			'POST' => [
				'/exercises/:id:int/fulfillments' => 'createFulfillment(:id:int)',
				'/exercises/:id:int/fulfillments/:idFulfillment:int' => 'editFulfillment(:id:int, :idFulfillment:int)'
			],
			'controller_file_name' => 'fulfillment_controller.php'
		],
		'Navigation()' => [
			'GET' => [
				'/' => 'home()',
				'/exercises' => 'manageExercises()',
				'/exercises/answering' => 'takeAnExercises()',
				'/exercises/new' => 'createAnExercises()',
				'/exercises/:id:int/fields' => 'manageField(:id:int)',
				'/exercises/:id:int/fulfillments/new' => 'take(:id:int)',
				'/exercises/:id:int/fields/:idFields:int/edit' => 'editAField(:id:int, :idFields:int)',
				'/exercises/:id:int/results' => 'showResults(:id:int)',
				'/exercises/:exercise:int/results/:field:int' => 'showFieldResults(:exercise:int,:field:int)',
				'/exercises/:id:int/fulfillments/:idFulfillments:int' => 'showFulfillmentResults(:id:int, :idFulfillments:int)',
				'/exercises/:id:int/fulfillments/:idFulfillments:int/edit' => 'editFulfillment(:id:int, :idFulfillments:int)'
			],
			'controller_file_name' => 'navigation.php'
		]
	];

	/**
	 * run the good function in the controller path with specified path
	 *
	 * @param  int $request_method the method of the request
	 * @param  int $request_uri the uri of the request
	 * @return bool true if runned successfully instead false
	 */
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
		// Iterate on all the route and check if it's the same route then launch the right controller on this route
		foreach ($routes[$request_method] as $route => $method) {
			$same_route = $this->isSameRoute($route, request_uri: $request_uri);

			if (is_array($same_route)) {
				require_once CONTROLLER_DIR . '/' . $routes['controller_file_name'];
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
				if (empty($value)) {
					return false;
				}
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
