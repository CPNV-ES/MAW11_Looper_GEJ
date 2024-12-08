<?php

require_once MODEL_DIR . '/field.php';

class FulfillmentField extends Field
{
	private $fulfillment_id;

	public function __construct(int $field_id, int $fulfillment_id)
	{
		parent::__construct($field_id);

		$this->fulfillment_id = $fulfillment_id;

		if (!$this->database_access->doesFulfillmentExist($fulfillment_id)) {
			throw new FulfillmentNotFoundException();
		}
	}

	public function getFulfillmentId()
	{
		return $this->fulfillment_id;
	}

	public function getBody()
	{
		return $this->database_access->getFulfillmentBody(parent::getId(), $this->fulfillment_id);
	}

	public function setBody(string $body)
	{
		if ($this->getExercise()->getStatus() != Status::Answering) {
			throw new ExerciseNotInAnsweringStatus();
		}
		$this->database_access->setFulfillmentBody(parent::getId(), $this->fulfillment_id, $body);
	}
}
