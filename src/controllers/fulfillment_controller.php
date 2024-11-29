<?php
/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  This file is for the fulfillment controller without the View 
 */

include_once MODEL_DIR . '/exercise.php';

/**
 * FulfillmentController
 */
class FulfillmentController
{	
	/**
	 * create a fulfillment
	 *
	 * @param  int $exercise_id
	 * @return void
	 */
	public function createFulfillment(int $exercise_id)
	{
		if (!isset($_POST['fulfillment']['answers_attributes'])) {
			badRequest();
			return;
		}

		$exercise = new Exercise($exercise_id);

		$fields = $exercise->getFields();

		foreach ($_POST['fulfillment']['answers_attributes'] as $answers_attribute) {
			if (!isset($answers_attribute['field_id'], $answers_attribute['value'])) {
				badRequest();
				return;
			}
			if (!$exercise->isFieldInExercise(new Field($answers_attribute['field_id']))) {
				badRequest();
				return;
			}
		}
		$fulfillment = $exercise->createFulfillment();

		foreach ($fields as $field) {
			$fulfillment->createFields($field, $_POST['fulfillment']['answers_attributes'][$field->getId()]['value']);
		}

		header('Location: /exercises/' . $exercise->getId() . '/fulfillments/' . $fulfillment->getId() . '/edit');
	}
	
	/**
	 * edit a fulfillment
	 *
	 * @param  int $exercise_id
	 * @param  int $fulfillment_id
	 * @return void
	 */
	public function editFulfillment(int $exercise_id, int $fulfillment_id)
	{
		if (!isset($_POST['fulfillment']['answers_attributes'])) {
			badRequest();
			return;
		}

		$exercise = new Exercise($exercise_id);

		$fulfillment = new Fulfillment($fulfillment_id);

		foreach ($_POST['fulfillment']['answers_attributes'] as $answers_attribute) {
			if (!isset($answers_attribute['field_id'], $answers_attribute['value'])) {
				badRequest();
				return;
			}

			$fulfillment_data = new FulfillmentField($answers_attribute['field_id'], $fulfillment_id);

			$fulfillment_data->setBody($answers_attribute['value']);
		}

		header('Location: /exercises/' . $exercise->getId() . '/fulfillments/' . $fulfillment->getId() . '/edit');
	}
}
