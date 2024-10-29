<?php

require MODEL_DIR . '/databases_connectors/databases_access.php';
require MODEL_DIR . '/databases_connectors/postgresql/postgresql.php';

class PostgresqlAccess implements DatabasesAccess
{
	private $postgresql;

	public function __construct($host, $port, $dbname, $postgres_user, $postgres_password)
	{
		$this->postgresql = new Postgresql($host, $port, $dbname, $postgres_user, $postgres_password);
		$this->create_db_if_not_exist();
	}

	public function doesExerciseExist(int $id): bool
	{
		return count($this->postgresql->select('SELECT id FROM exercises WHERE id = :id', [':id' => $id])) > 0;
	}

	public function createExercise(string $title): int
	{
		return (int)$this->postgresql->select('INSERT INTO exercises (title) VALUES (:title) RETURNING id', [':title' => $title])[0][0];
	}

	public function getExerciseTitle(int $id): string
	{
		$result = $this->postgresql->select('SELECT title FROM exercises WHERE id = :id', [':id' => $id]);
		return $result[0]['title'];
	}

	public function getExerciseStatus(int $id): int
	{
		$result = $this->postgresql->select('SELECT status FROM exercises WHERE id = :id', [':id' => $id]);
		return $result[0]['status'];
	}

	public function getExercises(int $status = ALL_EXERCISES): array
	{
		if ($status == ALL_EXERCISES) {
			return $this->postgresql->select('SELECT id FROM exercises');
		}
		return $this->postgresql->select('SELECT id FROM exercises WHERE status = :status', [':status' => $status]);
	}

	public function getFields(int $exercise_id): array
	{
		return $this->postgresql->select('SELECT id FROM fields WHERE exercise_id = :exercise_id', [':exercise_id' => $exercise_id]);
	}

	public function doesFieldExist(int $id): bool
	{
		return count($this->postgresql->select('SELECT id FROM fields WHERE id = :id', [':id' => $id])) > 0;
	}

	public function getFieldLabel(int $id): string
	{
		return $this->postgresql->select('SELECT label FROM fields WHERE id = :id', [':id' => $id])[0]['label'];
	}

	public function getFieldKind(int $id): int
	{
		return $this->postgresql->select('SELECT kind FROM fields WHERE id = :id', [':id' => $id])[0]['kind'];
	}

	public function createField(int $exercise_id, string $label, int $kind): int
	{
		return (int)$this->postgresql->select('INSERT INTO fields (label, kind, exercise_id) VALUES (:label, :kind, :exercise_id) RETURNING id', [':label' => $label, ':kind' => $kind, ':exercise_id' => $exercise_id])[0][0];
	}

	public function deleteField(int $id): void
	{
		$this->postgresql->modify('DELETE FROM fields WHERE id = :id', [':id' => $id]);
	}

	public function isFieldInExercise(int $exercise_id, int $field_id): bool
	{
		return count($this->postgresql->select('SELECT id FROM fields WHERE exercise_id = :exercise_id AND id = :field_id', [':exercise_id' => $exercise_id, ':field_id' => $field_id])) > 0;
	}

	public function setFieldLabel(int $id, string $label): void
	{
		$this->postgresql->modify('UPDATE fields SET label = :label WHERE id = :id', [':label' => $label, ':id' => $id]);
	}

	public function setFieldKind(int $id, int $kind): void
	{
		$this->postgresql->modify('UPDATE fields SET kind = :kind WHERE id = :id', [':kind' => $kind, ':id' => $id]);
	}

	public function deleteExercise(int $id): void
	{
		$this->postgresql->modify('DELETE FROM exercises WHERE id = :id', [':id' => $id]);
	}

	public function setExerciseStatus(int $id, int $status)
	{
		$result = $this->postgresql->select('UPDATE exercises set status=:status WHERE id = :id', [':id' => $id, ':status' => $status]);
		return $result;
	}

	public function getFieldsCount(int $exercise_id): int
	{
		return $this->postgresql->select('SELECT COUNT(id) FROM fields WHERE exercise_id = :exercise_id', [':exercise_id' => $exercise_id])[0][0];
	}

	private function create_db_if_not_exist()
	{
		if (count($this->postgresql->select("SELECT 1 FROM information_schema.tables WHERE table_name = 'exercises'")) < 1) {
			foreach (explode(';', file_get_contents(filename: MODEL_DIR . '/databases_connectors/postgresql/createdb.sql')) as $query) {
				if ($query == '') {
					continue;
				}
				try {
					$this->postgresql->modify($query);
				} catch (PDOException $e) {
					continue;
				}
			}
		}
	}
}
