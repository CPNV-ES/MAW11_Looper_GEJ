<?php

require_once MODEL_DIR . '/databases_connectors/databases_choose.php';
require_once MODEL_DIR . '/field.php';

enum Status: int
{
	case Building = 0;
	case Answering = 1;
	case Closed = 2;
}

class Exercise
{
	private DatabasesAccess $database_access;
	private int $id;

	public function __construct(int $id)
	{
		$this->database_access = (new DatabasesChoose())->getDatabase();
		if (!$this->database_access->doesExerciseExist($id)) {
			throw new Exception('The exercise does not exist');
		}

		$this->id = $id;
	}

	public static function create($title): self
	{
		$database_access = (new DatabasesChoose())->getDatabase();
		return new self($database_access->createExercise($title));
	}

	public function getId()
	{
		return $this->id;
	}

	public function getTitle()
	{
		return $this->database_access->getExerciseTitle($this->id);
	}

	public function getFields(): array
	{
		$array_field = [];
		foreach ($this->database_access->getFields($this->id) as $field) {
			array_push($array_field, new Field($field['id']));
		}
		return $array_field;
	}

	public function createField(string $label, Kind $kind): Field
	{
		return (new Field($this->database_access->createField($this->id, $label, $kind->value)));
	}

	public function isFieldInExercise(Field $field): bool
	{
		return $this->database_access->isFieldInExercise($this->id, $field->getId());
	}

	public function delete()
	{
		$this->database_access->deleteExercise($this->id);
	}

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

	public function getStatus(): Status
	{
		return Status::from($this->database_access->getExerciseStatus($this->id));
	}

	public function setExerciseAs(Status $status)
	{
		$this->database_access->setExerciseStatus($this->id, $status->value);
	}

	public function getFieldsCount(): int
	{
		return $this->database_access->getFieldsCount($this->id);
	}
}
