<?php

require_once MODEL_DIR . '/databases_connectors/databases_choose.php';

enum Kind: int
{
	case SingleLineText = 0;
	case ListOfSingleLines = 1;
	case MultiLineText = 2;
}

class Field
{
	private DatabasesAccess $database_access;
	private int $id;

	public function __construct(int $id)
	{
		$this->id = $id;

		$this->database_access = (new DatabasesChoose())->getDatabase();

		if (!$this->database_access->doesFieldExist($id)) {
			throw new Exception('Field Does Not Exist');
		}
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getLabel(): string
	{
		return $this->database_access->getFieldLabel($this->id);
	}

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

	public function setLabel(string $label): void
	{
		$this->database_access->setFieldLabel($this->id, $label);
	}

	public function setKind(Kind $kind): void
	{
		$this->database_access->setFieldKind($this->id, $kind->value);
	}

	public function delete()
	{
		$this->database_access->deleteField($this->id);
	}
}
