<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  FulfillmentField class herited from a field
 */

require_once MODEL_DIR . '/field.php';

/**
 * FulfillmentField
 *
 */
class FulfillmentField extends Field
{
	private $fulfillment_id;

	/**
	 * Contructor of the FulfillmentField
	 *
	 * @param  int $field_id
	 * @param  int $fulfillment_id
	 * @return void
	 */
	public function __construct(int $field_id, int $fulfillment_id)
	{
		parent::__construct($field_id);

		$this->fulfillment_id = $fulfillment_id;

		if (!$this->database_access->doesFulfillmentExist($fulfillment_id)) {
			throw new FulfillmentNotFoundException();
		}
	}

	/**
	 * get fulfillment id
	 *
	 * @return int
	 */
	public function getFulfillmentId()
	{
		return $this->fulfillment_id;
	}

	/**
	 * get fulfillment body
	 *
	 * @return string
	 */
	public function getBody()
	{
		return $this->database_access->getFulfillmentBody(parent::getId(), $this->fulfillment_id);
	}

	/**
	 * set body
	 *
	 * @param  string $body
	 * @return void
	 */
	public function setBody(string $body)
	{
		if ($this->getExercise()->getStatus() != Status::Answering) {
			throw new ExerciseNotInAnsweringStatus();
		}
		$this->database_access->setFulfillmentBody(parent::getId(), $this->fulfillment_id, $body);
	}
}
