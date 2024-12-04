<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description This class is the field buiness logic of the application
 */

require_once MODEL_DIR . '/databases_connectors/databases_choose.php';
require_once MODEL_DIR . '/exercise.php';

/**
 * The kind of field that can be created
 */
enum Kind: int
{
	case SingleLineText = 0;
	case ListOfSingleLines = 1;
	case MultiLineText = 2;
}

/**
 * This class is the field buiness logic of the application
 */
class Field
{
	protected DatabasesAccess $database_access;
	private int $id;

	/**
	 * The constructor of the field class
	 *
	 * @param  int $id the id of the field
	 * @throws FieldNotFoundException if the field does not exist
	 * @return void
	 */
	public function __construct(int $id)
	{
		$this->id = $id;

		$this->database_access = (new DatabasesChoose())->getDatabase();

		if (!$this->database_access->doesFieldExist($id)) {
			throw new FieldNotFoundException();
		}
	}

	/**
	 * Returns the ID of a field. 
	 *
	 * @return int The unique identifier of the object.
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * Get the label of the field
	 *
	 * @return string the label of the field
	 */
	public function getLabel(): string
	{
		return $this->database_access->getFieldLabel($this->id);
	}

	/**
	 * Get the kind of the field
	 *
	 * @return Kind the kind of the field
	 */
	public function getKind(): Kind
	{
		switch ($this->database_access->getFieldKind($this->id)) {
			case 1:
				return Kind::ListOfSingleLines;
			case 2:
				return Kind::MultiLineText;
			default:
				return Kind::SingleLineText;
		}
	}

	/**
	 * Set the label of the field
	 *
	 * @param  string $label the new label of the field
	 * @return void
	 */
	public function setLabel(string $label): void
	{
		if ($this->getExercise()->getStatus() != Status::Building) {
			throw new ExerciseNotInBuildingStatus();
		}
		$this->database_access->setFieldLabel($this->id, $label);
	}

	/**
	 * Set the kind of the field
	 *
	 * @param  Kind $kind the new kind of the field
	 * @return void
	 */
	public function setKind(Kind $kind): void
	{
		if ($this->getExercise()->getStatus() != Status::Building) {
			throw new ExerciseNotInBuildingStatus();
		}
		$this->database_access->setFieldKind($this->id, $kind->value);
	}

	/**
	 * Delete the field
	 *
	 * @return void
	 */
	public function delete(): void
	{
		if ($this->getExercise()->getStatus() != Status::Building) {
			throw new ExerciseNotInBuildingStatus();
		}
		$this->database_access->deleteField($this->id);
	}

	/**
	 * Get the exercise of the field
	 *
	 * @return Exercise
	 */
	public function getExercise(): Exercise
	{
		return new Exercise($this->database_access->getExerciseByFieldId($this->id));
	}
}

/**
 * This exception is thrown when a field is not found
 */
class FieldNotFoundException extends LooperException
{
	/**
	 * The constructor of the FieldNotFoundException class
	 *
	 * @param  string $message the message of the exception default 'The field does not exist'
	 * @param  int $code the code of the exception default 0
	 * @param  Exception $previous the previous exception default null
	 * @return void
	 */
	public function __construct($message = 'The field does not exist', $code = 0, Exception $previous = null)
	{
		parent::__construct(404, 'Field not found', $message, $code, $previous);
	}
}
