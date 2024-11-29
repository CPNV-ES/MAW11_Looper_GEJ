<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  Field class
 */

require_once MODEL_DIR . '/databases_connectors/databases_choose.php';
require_once MODEL_DIR . '/exercise.php';

enum Kind: int
{
	case SingleLineText = 0;
	case ListOfSingleLines = 1;
	case MultiLineText = 2;
}

/**
 * Field class
 */
class Field
{
	protected DatabasesAccess $database_access;
	private int $id;

	/**
	 * Field contructor
	 *
	 * @param  int $id
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
	 * get field id
	 *
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * get field label
	 *
	 * @return string
	 */
	public function getLabel(): string
	{
		return $this->database_access->getFieldLabel($this->id);
	}

	/**
	 * fet field kind
	 *
	 * @return Kind
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
	 * set field label
	 *
	 * @param  string $label
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
	 * set field kind
	 *
	 * @param  Kind $kind
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
	 * delete a field
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
	 * get field exercise
	 *
	 * @return Exercise
	 */
	public function getExercise(): Exercise
	{
		return new Exercise($this->database_access->getExerciseByFieldId($this->id));
	}
}

/**
 * FieldNotFoundException
 */
class FieldNotFoundException extends LooperException
{
	public function __construct($message = 'The field does not exist', $code = 0, Exception $previous = null)
	{
		parent::__construct(404, 'Field not found', $message, $code, $previous);
	}
}
