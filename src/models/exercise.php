<?php
/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  Exercise class 
 */

require_once MODEL_DIR . '/databases_connectors/databases_choose.php';
require_once MODEL_DIR . '/field.php';
require_once MODEL_DIR . '/fulfillment.php';

enum Status: int
{
	case Building = 0;
	case Answering = 1;
	case Closed = 2;
}

/**
 * Exercise
 */
class Exercise
{
	private DatabasesAccess $database_access;
	private int $id;
	
	/**
	 * Exerise constructor
	 *
	 * @param  mixed $id
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
	 * create an exericse
	 *
	 * @param  string $title
	 * @return self
	 */
	public static function create(string $title): self
	{
		$database_access = (new DatabasesChoose())->getDatabase();
		return new self($database_access->createExercise($title));
	}
	
	/**
	 * get exerise id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * get exerise title
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->database_access->getExerciseTitle($this->id);
	}
	
	/**
	 * get exercise fields
	 *
	 * @return array[Field]
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
	 * create field exerises
	 *
	 * @param  string $label
	 * @param  Kind $kind
	 * @return Field
	 */
	public function createField(string $label, Kind $kind): Field
	{
		if ($this->getStatus() != Status::Building) {
			throw new ExerciseNotInBuildingStatus();
		}
		return new Field($this->database_access->createField($this->id, $label, $kind->value));
	}
	
	/**
	 * is field in exeercise
	 *
	 * @param  Field $field
	 * @return bool
	 */
	public function isFieldInExercise(Field $field): bool
	{
		return $this->database_access->isFieldInExercise($this->id, $field->getId());
	}
	
	/**
	 * is fulfillment in exercise
	 *
	 * @param  Fulfillment $fulfillment
	 * @return bool
	 */
	public function isFulfillmentInExercise(Fulfillment $fulfillment): bool
	{
		return $this->database_access->isFulfillmentInExercise($this->id, $fulfillment->getId());
	}
	
	/**
	 * delete an exercise
	 *
	 * @return void
	 */
	public function delete()
	{
		$this->database_access->deleteExercise($this->id);
	}
	
	/**
	 * get exercises 
	 *
	 * @param  Status $status
	 * @return array[Exercise]
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
	 * get status of an exercise
	 *
	 * @return Status
	 */
	public function getStatus(): Status
	{
		return Status::from($this->database_access->getExerciseStatus($this->id));
	}
	
	/**
	 * set Exercise As
	 *
	 * @param  Status $status
	 * @return void
	 */
	public function setExerciseAs(Status $status)
	{
		$this->database_access->setExerciseStatus($this->id, $status->value);
	}
	
	/**
	 * get number of field in exercise
	 *
	 * @return int
	 */
	public function getFieldsCount(): int
	{
		return $this->database_access->getFieldsCount($this->id);
	}
	
	/**
	 * create Fulfillment 
	 *
	 * @return Fulfillment
	 */
	public function createFulfillment(): Fulfillment
	{
		if ($this->getStatus() != Status::Answering) {
			throw new ExerciseNotInAnsweringStatus();
		}
		return new Fulfillment($this->database_access->createFulfillment($this->id));
	}
	
	/**
	 * get all fulfillments
	 *
	 * @return array[Fulfillment]
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
 * ExerciseNotFoundException
 */
class ExerciseNotFoundException extends LooperException
{
	public function __construct($message = 'The exercise does not exist', $code = 0, Exception $previous = null)
	{
		// Make sure everything is assigned properly
		parent::__construct(404, 'Exercise not found', $message, $code, $previous);
	}
}

/**
 * ExerciseNotInBuildingStatus
 */
class ExerciseNotInBuildingStatus extends LooperException
{
	public function __construct($message = 'The Exercise is not in building status', $code = 0, Exception|null $previous = null)
	{
		parent::__construct(400, 'The Exercise is not in building status', $message, $code, $previous);
	}
}

/**
 * ExerciseNotInAnsweringStatus
 */
class ExerciseNotInAnsweringStatus extends LooperException
{
	public function __construct($message = 'The Exercise is not in answering status', $code = 0, Exception|null $previous = null)
	{
		parent::__construct(400, 'The Exercise is not in answering status', $message, $code, $previous);
	}
}
