<?php

/**
 * @author Ethann Schneider, Guillaume Aubert, Jomana Kaempf
 * @version 29.11.2024
 * @description  Database choose file is set to choose the correct databases based on a config (currently there is only one)
 */

require MODEL_DIR . '/databases_connectors/postgresql/postgresql_access.php';

/**
 * This class serves as a hub for managing multiple databases, allowing for easy addition or removal of database systems as needed.
 */
class DatabasesChoose
{
	// static for now but should be in a dynamic config
	private string $databases = 'postgresql';
	private static DatabasesAccess $database;

	/**
	 * DatabasesChoose contructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		if (isset(self::$database)) {
			return;
		}
		switch ($this->databases) {
			default:
				self::$database = new PostgresqlAccess('postgresql', 5432, 'db_looper', $_ENV['POSTGRES_USER'], $_ENV['POSTGRES_PASSWORD']);
		}
	}

	/**
	 * get dataases access implement with the correct databases
	 *
	 * @return DatabasesAccess
	 */
	public function getDatabase(): DatabasesAccess
	{
		return self::$database;
	}
}
