<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description Postgresql connector class to select of modify the database
 */
class Postgresql
{
	private $db;

	public function __construct($host, $port, $dbname, $postgres_user, $postgres_password)
	{
		$this->db = new PDO('pgsql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname, $postgres_user, $postgres_password);
	}

	/**
	 * select (all select, returning at the end of an insert) basicly all that is returning somethings
	 *
	 * @param  string $squery the Sql query (default: '')
	 * @param  array $args (default: [])
	 * @return array[array] the result of the query
	 */
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

	/**
	 * modify (insert, update) basicly all that isn't returning anything
	 *
	 * @param  string $squery The Sql query (default: '')
	 * @param  array $args (default: [])
	 * @return void
	 */
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
