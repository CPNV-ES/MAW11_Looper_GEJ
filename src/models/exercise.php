<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  Exercise class
 */

require_once MODEL_DIR . '/databases_connectors/databases_choose.php';
require_once MODEL_DIR . '/field.php';
require_once MODEL_DIR . '/fulfillment.php';

/**
 * The status of an exercise (Building, Answering, Closed)
 */
enum Status: int
{
	case Building = 0;
	case Answering = 1;
	case Closed = 2;
}

/**
 * This class represents an exercise
 */
class Exercise
{
	private DatabasesAccess $database_access;
	private int $id;

	/**
	 * This is the constructor of the exercise class
	 *
	 * @param  int $id the id of the exercise
	 * @throws ExerciseNotFoundException if the exercise does not exist
	 * @return void
	 */
	public function __construct(int $id)
	{
		$this->database_access = (new DatabasesChoose())->getDatabase();
		if (!$this->database_access->doesExerciseExist($id)) {
			throw new ExerciseNotFoundException();
		}

		$this->id = $id;
	}

	/**
	 * This is a static method to create an exercise
	 *
	 * @param  string $title the title of the exercise
	 * @return self the created exercise
	 */
	public static function create(string $title): self
	{
		$database_access = (new DatabasesChoose())->getDatabase();
		return new self($database_access->createExercise($title));
	}

	/**
	 * Get the id of the exercise
	 *
	 * @return int the id of the exercise
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the title of the exercise
	 *
	 * @return string the title of the exercise
	 */
	public function getTitle()
	{
		return $this->database_access->getExerciseTitle($this->id);
	}

	/**
	 * get exercise list of field in exercise
	 *
	 * @return array[Field] the list of field in exercise
	 */
	public function getFields(): array
	{
		$array_field = [];
		foreach ($this->database_access->getFields($this->id) as $field) {
			array_push($array_field, new Field($field['id']));
		}
		return $array_field;
	}

	/**
	 * Create a field in the exercise
	 *
	 * @param  string $label the label of the field
	 * @param  Kind $kind the kind of the field
	 * @throws ExerciseNotInBuildingStatus if the exercise is not in building status
	 * @return Field the created field
	 */
	public function createField(string $label, Kind $kind): Field
	{
		if ($this->getStatus() != Status::Building) {
			throw new ExerciseNotInBuildingStatus();
		}
		return new Field($this->database_access->createField($this->id, $label, $kind->value));
	}

	/**
	 * Is field in exercise ?
	 *
	 * @param  Field $field the field to check
	 * @return bool true if the field is in the exercise, false otherwise
	 */
	public function isFieldInExercise(Field $field): bool
	{
		return $this->database_access->isFieldInExercise($this->id, $field->getId());
	}

	/**
	 * Check if a fulfillment is part of the exercise.
	 *
	 * @param Fulfillment $fulfillment The fulfillment object to check.
	 * @return bool Returns true if the fulfillment is part of the exercise, false otherwise.
	 */
	public function isFulfillmentInExercise(Fulfillment $fulfillment): bool
	{
		return $this->database_access->isFulfillmentInExercise($this->id, $fulfillment->getId());
	}

	/**
	 * This method deletes the exercise
	 *
	 * @return void the deleted exercise
	 */
	public function delete()
	{
		$this->database_access->deleteExercise($this->id);
	}

	/**
	 * Get all static exercises by status (if status is null, get all exercises)
	 *
	 * @param  Status $status the status of the exercise default null
	 * @return array[Exercise] the list of exercises by status
	 */
	public static function getExercises(Status $status = null)
	{
		$database_access = (new DatabasesChoose())->getDatabase();
		$exercises_data = [];
		if ($status == null) {
			$exercises_data = $database_access->getExercises();
		} else {
			$exercises_data = $database_access->getExercises($status->value);
		}

		$exercises = [];
		foreach ($exercises_data as $exercise_data) {
			$exercise = new self($exercise_data['id']);
			$exercises[] = $exercise;
		}

		return $exercises;
	}

	/**
	 * get status of an exercise (Building, Answering, Closed)
	 *
	 * @return Status the status of the exercise (Building, Answering, Closed)
	 */
	public function getStatus(): Status
	{
		return Status::from($this->database_access->getExerciseStatus($this->id));
	}

	/**
	 * Set the exercise as a status (Building, Answering, Closed)
	 *
	 * @param  Status $status the status to set the exercise as (Building, Answering, Closed)
	 * @return void
	 */
	public function setExerciseAs(Status $status)
	{
		$this->database_access->setExerciseStatus($this->id, $status->value);
	}

	/**
	 * get number of field in exercise
	 *
	 * @return int the number of field in exercise
	 */
	public function getFieldsCount(): int
	{
		return $this->database_access->getFieldsCount($this->id);
	}

	/**
	 * create a fulfillment in exercise when the exercise is in answering status
	 *
	 * @throws ExerciseNotInAnsweringStatus if the exercise is not in answering status
	 * @return Fulfillment the created fulfillment
	 */
	public function createFulfillment(): Fulfillment
	{
		if ($this->getStatus() != Status::Answering) {
			throw new ExerciseNotInAnsweringStatus();
		}
		return new Fulfillment($this->database_access->createFulfillment($this->id));
	}

	/**
	 * Get a list of fulfillments in exercise (All fulfillments in exercise)
	 *
	 * @return array[Fulfillment] the list of fulfillments in exercise
	 */
	public function getFulfillments(): array
	{
		$fulfillments = [];
		foreach ($this->database_access->getFulfillments($this->id) as $field) {
			array_push($fulfillments, new Fulfillment($field['id']));
		}
		return $fulfillments;
	}
}

/**
 * This exception is thrown when an exercise is not found
 */
class ExerciseNotFoundException extends LooperException
{
	/**
	 * This is the constructor of the exception
	 *
	 * @param  string $message the message of the exception
	 * @param  int $code the code of the exception
	 * @param  Exception|null $previous the previous exception
	 * @return void
	 */
	public function __construct($message = 'The exercise does not exist', $code = 0, Exception $previous = null)
	{
		// Make sure everything is assigned properly
		parent::__construct(404, 'Exercise not found', $message, $code, $previous);
	}
}

/**
 * This exception is thrown when an exercise is not in building status
 */
class ExerciseNotInBuildingStatus extends LooperException
{
	/**
	 * This is the constructor of the exception
	 *
	 * @param  string $message the message of the exception
	 * @param  int $code the code of the exception
	 * @param  Exception|null $previous the previous exception
	 * @return void
	 */
	public function __construct($message = 'The Exercise is not in building status', $code = 0, Exception|null $previous = null)
	{
		parent::__construct(400, 'The Exercise is not in building status', $message, $code, $previous);
	}
}

/**
 * This exception is thrown when an exercise is not in answering status
 */
class ExerciseNotInAnsweringStatus extends LooperException
{
	/**
	 * This is the constructor of the exception
	 *
	 * @param  string $message the message of the exception
	 * @param  int $code the code of the exception
	 * @param  Exception|null $previous the previous exception
	 * @return void
	 */
	public function __construct($message = 'The Exercise is not in answering status', $code = 0, Exception|null $previous = null)
	{
		parent::__construct(400, 'The Exercise is not in answering status', $message, $code, $previous);
	}
}
