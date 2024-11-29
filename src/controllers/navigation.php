<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  This is the navigation controller that every route redirect to a view
 */

include_once MODEL_DIR . '/exercise.php';

/**
 * Navigation controller to get the GUI
 */
class Navigation
{
	/**
	 * home page
	 *
	 * @return void
	 */
	public function home()
	{
		include VIEW_DIR . '/home.php';
	}

	/**
	 * create an exercises page
	 *
	 * @return void
	 */
	public function createAnExercises()
	{
		include VIEW_DIR . '/create_an_exercise.php';
	}

	/**
	 * take an exercises page
	 *
	 * @return void
	 */
	public function takeAnExercises()
	{
		$exercises = Exercise::getExercises(Status::Answering);
		include VIEW_DIR . '/take_an_exercise.php';
	}

	/**
	 * manage an exercises
	 *
	 * @return void
	 */
	public function manageExercises()
	{
		$buildingExercises = Exercise::getExercises(Status::Building);
		$answeringExercises = Exercise::getExercises(Status::Answering);
		$closeExercises = Exercise::getExercises(Status::Closed);

		include VIEW_DIR . '/manage_an_exercise.php';
	}

	/**
	 * manage a field page
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function manageField(int $id)
	{
		$exercise = new Exercise($id);
		$fields = $exercise->getFields();

		if ($exercise->getStatus() != Status::Building) {
			unauthorized();
			return;
		}

		include VIEW_DIR . '/manage_field.php';
	}

	/**
	//  * edit a Field page
	 *
	 * @param  int $exercise_id
	 * @param  int $id the field id
	 * @return void
	 */
	public function editAField(int $exercise_id, int $id)
	{
		$exercise = new Exercise($exercise_id);
		$field = new Field($id);

		if (!$exercise->isFieldInExercise($field)) {
			lost();
			return;
		}

		if ($exercise->getStatus() != Status::Building) {
			unauthorized();
			return;
		}

		include VIEW_DIR . '/edit_a_field.php';
	}

	/**
	 * take page is the page to answer exercise
	 *
	 * @param  int $exercise_id
	 * @return void
	 */
	public function take(int $exercise_id)
	{
		$edit_take = false;
		$exercise = new Exercise($exercise_id);

		$fields = $exercise->getFields();

		if ($exercise->getStatus() != Status::Answering) {
			unauthorized();
			return;
		}

		include VIEW_DIR . '/take.php';
	}

	/**
	 * show results of an exerise
	 *
	 * @param  int $id of an exercise
	 * @return void
	 */
	public function showResults(int $id)
	{
		$exercise = new Exercise($id);
		include VIEW_DIR . '/show_exercise_results.php';
	}

	/**
	 * show field results
	 *
	 * @param  int $exercise_id
	 * @param  int $field_id
	 * @return void
	 */
	public function showFieldResults(int $exercise_id, int $field_id)
	{
		$exercise = new Exercise($exercise_id);
		$field = new Field($field_id);

		if (!$exercise->isFieldInExercise($field)) {
			lost();
			return;
		}

		include VIEW_DIR . '/show_field_results.php';
	}

	/**
	 * show fulfillment results
	 *
	 * @param  int $exercise_id
	 * @param  int $fulfillment_id
	 * @return void
	 */
	public function showFulfillmentResults(int $exercise_id, int $fulfillment_id): void
	{
		$exercise = new Exercise($exercise_id);

		$fulfillment = new Fulfillment($fulfillment_id);

		if (!$exercise->isFulfillmentInExercise($fulfillment)) {
			lost();
			return;
		}

		include VIEW_DIR . '/show_fulfillment_results.php';
	}

	/**
	 * edit a fullfillment
	 *
	 * @param  int $exercise_id
	 * @param  int $fulfillment_id
	 * @return void
	 */
	public function editFulfillment(int $exercise_id, int $fulfillment_id)
	{
		$exercise = new Exercise($exercise_id);
		$fulfillment = new Fulfillment($fulfillment_id);

		$fields = $fulfillment->getFields();

		if (!$exercise->isFulfillmentInExercise($fulfillment)) {
			lost();
			return;
		}

		if ($exercise->getStatus() != Status::Answering) {
			unauthorized();
			return;
		}

		include VIEW_DIR . '/take.php';
	}
}
