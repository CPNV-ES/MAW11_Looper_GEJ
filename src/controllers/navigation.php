<?php

include_once MODEL_DIR . '/exercise.php';

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

		if ($exercise->getStatus() != Status::Building) {
			unauthorized();
			return;
		}

		include VIEW_DIR . '/manage_field.php';
	}

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

	public function showResults(int $id)
	{
		$exercise = new Exercise($id);
		include VIEW_DIR . '/show_exercise_results.php';
	}

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
