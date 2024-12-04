<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  Fulfillment class
 */

require_once MODEL_DIR . '/databases_connectors/databases_choose.php';
require_once MODEL_DIR . '/fulfillment_field.php';
require_once MODEL_DIR . '/field.php';
require_once MODEL_DIR . '/exercise.php';

/**
 * This class is the fulfillment buiness logic of the application
 */
class Fulfillment
{
	private DatabasesAccess $database_access;
	private int $id;

	/**
	 * constructor of the fulfillment
	 *
	 * @param  int $id the id of the fulfillment
	 *
	 * @throws FulfillmentNotFoundException if the fulfillment does not exist
	 * @return void
	 */
	public function __construct(int $id)
	{
		$this->id = $id;

		$this->database_access = (new DatabasesChoose())->getDatabase();

		if (!$this->database_access->doesFulfillmentExist($id)) {
			throw new FulfillmentNotFoundException();
		}
	}

	/**
	 * Get the id of the fulfillment
	 *
	 * @return int the id of the fulfillment
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * get fulfillment creation date
	 *
	 * @return int the timestamp of the creation date
	 */
	public function getTimestamp()
	{
		return $this->database_access->getFulfillmentTimestamp($this->id);
	}

	/**
	 * create fulfillment fields data
	 *
	 * @param  Field $field the field to create
	 * @param  string $body the body of the field
	 * @return FulfillmentField the created field
	 */
	public function createFields(Field $field, string $body)
	{
		if ($this->getExercise()->getStatus() != Status::Answering) {
			throw new ExerciseNotInAnsweringStatus();
		}

		$this->database_access->createFulfillmentField($field->getId(), $this->id, $body);

		return new FulfillmentField($field->getId(), $this->id);
	}

	/**
	 * get a fields of the fulfillment
	 *
	 * @return array[FulfillmentField $field] the fields of the fulfillment
	 */
	public function getFields()
	{
		$fulfillment = [];

		foreach ($this->database_access->getFulfillmentFields($this->id) as $field) {
			$fulfillment[] = new FulfillmentField($field[0], $this->id);
		}

		return $fulfillment;
	}

	/**
	 * get exercise of the fulfillment
	 *
	 * @return Exercise the exercise of the fulfillment
	 */
	public function getExercise()
	{
		return new Exercise($this->database_access->getExerciseByFulfillmentId($this->id));
	}
}

/**
 * This exception is thrown when the fulfillment does not exist
 */
class FulfillmentNotFoundException extends LooperException
{
	/**
	 * constructor of the exception
	 *
	 * @param  string $message the message of the exception Default: 'The fulfillment does not exist'
	 * @param  int $code the code of the exception Default: 0
	 * @param  Exception $previous the previous exception Default: null
	 * @return void
	 */
	public function __construct($message = 'The fulfillment does not exist', $code = 0, Exception $previous = null)
	{
		parent::__construct(404, 'fulfillment not found', $message, $code, $previous);
	}
}
