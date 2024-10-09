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
			case 3:
				return Kind::MultiLineText;
			default:
				return Kind::SingleLineText;
		}
	}
}
