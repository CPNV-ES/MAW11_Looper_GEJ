<?php

class Postgresql
{
	private $db;

	public function __construct($host, $port, $dbname, $postgres_user, $postgres_password)
	{
		$this->db = new PDO('pgsql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname, $postgres_user, $postgres_password);
	}

	public function select(string $squery, array $args = [])
	{
		if ($args) {
			$statement = $this->db->prepare($squery);
		} else {
			$statement = $this->db->query($squery);
		}

		$statement->execute($args);

		return $statement->fetchAll();
	}

	public function modify(string $squery, array $args = [])
	{
		if ($args) {
			$statement = $this->db->prepare($squery);
		} else {
			$statement = $this->db->query($squery);
		}

		$statement->execute($args);
	}
}
