<?php

include_once MODEL_DIR . '/exercise.php';

$entry = [
	'FulfillmentController()' => [
		'POST' => [
			'/exercises/:id:int/fulfillments' => 'createFulfillment(:id:int)',
			'/exercises/:id:int/fulfillments/:idFulfillment:int' => 'editFulfillment(:id:int, :idFulfillment:int)'
		]
	]
];

class FulfillmentController
{
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
