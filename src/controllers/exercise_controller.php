<?php

include_once MODEL_DIR . '/exercise.php';

$entry = [
	'ExerciseController()' => [
		'GET' => [
			'/exercises/:id:int' => 'changeStateOfExercise(:id:int)',
			'/exercises/:id:int/delete' => 'deleteExercise(:id:int)'
		],
		'POST' => [
			'/exercises' => 'createExercise()'
		]
	]
];

class ExerciseController
{
	public function createExercise()
	{
		if (!isset($_POST['exercise_title'])) {
			badRequest();
			return;
		}

		$exercise = Exercise::create($_POST['exercise_title']);
		header('Location: /exercises/' . $exercise->getId() . '/fields');
	}

	public function deleteExercise(int $id)
	{
		try {
			$exercise = new Exercise($id);
		} catch (Exception $e) {
			lost();
			return;
		}

		if ($exercise->getStatus() == Status::Building || $exercise->getStatus() == Status::Closed) {
			$exercise->delete();
		}
		header('Location: /exercises');
	}

	public function changeStateOfExercise(int $id)
	{
		if (!isset($_GET['exercise']['status'])) {
			badRequest();
			return;
		}

		$exercise = null;
		try {
			$exercise = new Exercise($id);
		} catch (Exception) {
			lost();
			return;
		}

		if ($exercise->getFieldsCount() < 1) {
			badRequest();
			return;
		}

		switch ($_GET['exercise']['status']) {
			case 'answering' && $exercise->getStatus() == Status::Building:
				$exercise->setExerciseAs(Status::Answering);
				break;
			case 'closed' && $exercise->getStatus() == Status::Answering:
				$exercise->setExerciseAs(Status::Closed);
				break;
			default:
				badRequest();
				return;
		}

		header('Location: /exercises');
	}
}
