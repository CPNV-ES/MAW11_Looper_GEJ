<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description This file is for the excercise controller without the view
 */

include_once MODEL_DIR . '/exercise.php';

/**
 * Class ExerciseController
 *
 * Manages the backend operations for exercises, including creation, deletion, and state transitions.
 */
class ExerciseController
{
	/**
	 * This method creates a new exercise based on the title provided by the user via `$_POST['exercise_title']`.
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
	 * This method deletes an exercise identified by `$id`. It only allows deletion if the exercise
	 * is in the `Building` or `Closed` state.
	 *
	 * @param int $id The ID of the exercise to be deleted.
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
	 * This method changes the state of an exercise identified by `$id`.
	 *
	 * @param int $id The ID of the exercise whose state is to be changed.
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
