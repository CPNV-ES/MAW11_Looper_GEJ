<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  FulfillmentField class herited from a field
 */

require_once MODEL_DIR . '/field.php';

/**
 * This class is the fulfillment field buiness logic of the application herited from a field
 */
class FulfillmentField extends Field
{
	private $fulfillment_id;

	/**
	 * constructor of the fulfillment field
	 *
	 * @param  int $field_id the id of the field to construct the field parent
	 * @param  int $fulfillment_id the id of the fulfillment
	 * @throws FulfillmentNotFoundException if the fulfillment does not exist
	 * @throws FieldNotFoundException if the field does not exist
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
	 * Get the id of the fulfillment
	 *
	 * @return int the id of the fulfillment
	 */
	public function getFulfillmentId()
	{
		return $this->fulfillment_id;
	}

	/**
	 * Get the body of the fulfillment
	 *
	 * @return string the body of the fulfillment
	 */
	public function getBody()
	{
		return $this->database_access->getFulfillmentBody(parent::getId(), $this->fulfillment_id);
	}

	/**
	 * Set the body of the fulfillment
	 *
	 * @param  string $body the body of the fulfillment
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
