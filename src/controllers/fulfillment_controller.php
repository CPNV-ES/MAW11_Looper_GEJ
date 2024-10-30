<?php

include_once MODEL_DIR . '/exercise.php';

$entry = [
	'FulfillmentController()' => [
		'POST' => [
			'/exercises/:id:int/fulfillments' => 'createFulfillment(:id:int)'
		]
	]
];

class FulfillmentController
{
    public function createFulfillment(int $exercise_id)
	{
        if (!isset($_POST['fulfillment']['answers_attributes'])){
            badRequest();
            return;
        }
		echo json_encode($_POST);

	}
}