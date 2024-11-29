<?php
/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description This file is for the excercise controller without the view 
 */

include_once MODEL_DIR . '/exercise.php';

/**
 * ExerciseController
 */
class ExerciseController
{	
	/**
	 * create an exercise
	 *
	 * @return void
	 */
	public function createExercise()
	{
		if (!isset($_POST['exercise_title'])) {
			badRequest();
			return;
		}

		$exercise = Exercise::create($_POST['exercise_title']);
		header('Location: /exercises/' . $exercise->getId() . '/fields');
	}
	
	/**
	 * Delete an exercise
	 *
	 * @param int $id
	 * @return void
	 */
	public function deleteExercise(int $id)
	{
		$exercise = new Exercise($id);

		if ($exercise->getStatus() == Status::Building || $exercise->getStatus() == Status::Closed) {
			$exercise->delete();
		}
		header('Location: /exercises');
	}
	
	/**
	 * Change state of an exercise
	 *
	 * @param int $id
	 * @return void
	 */
	public function changeStateOfExercise(int $id)
	{
		if (!isset($_GET['exercise']['status'])) {
			badRequest();
			return;
		}

		$exercise = null;
		$exercise = new Exercise($id);

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
