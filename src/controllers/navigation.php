<?php

include_once MODEL_DIR . '/exercise.php';

$entry = [
	'Navigation()' => [
		'GET' => [
			'/' => 'home()',
			'/exercises' => 'manageExercises()',
			'/exercises/answering' => 'takeAnExercises()',
			'/exercises/new' => 'createAnExercises()',
			'/exercises/:id:int/fields' => 'manageField(:id:int)',
			'/exercises/:id:int/fields/:idFields:int/edit' => 'editAField(:id:int, :idFields:int)'
		]
	]
];

class Navigation
{
	public function home()
	{
		include VIEW_DIR . '/home.php';
	}

	public function createAnExercises()
	{
		include VIEW_DIR . '/create_an_exercise.php';
	}

	public function takeAnExercises()
	{
		$exercises = Exercise::getExercises(Status::Answering);
		include VIEW_DIR . '/take_an_exercise.php';
	}

	public function manageExercises()
	{
		$buildingExercises = Exercise::getExercises(Status::Building);
		$answeringExercises = Exercise::getExercises(Status::Answering);
		$closeExercises = Exercise::getExercises(Status::Closed);

		include VIEW_DIR . '/manage_an_exercise.php';
	}

	public function manageField(int $id)
	{
		$exercise = new Exercise($id);
		$fields = $exercise->getFields();

		include VIEW_DIR . '/manage_field.php';
	}

	public function editAField(int $exerciseId, int $id)
	{
		$exercise = null;
		$field = null;
		try {
			$exercise = new Exercise($exerciseId);
			$field = new Field($id);
		} catch (Exception $e) {
			lost();
			return;
		}

		if (!$exercise->isFieldInExercise($field)) {
			lost();
		}

		include VIEW_DIR . '/edit_a_field.php';
	}
}
