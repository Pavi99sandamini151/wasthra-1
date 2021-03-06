<?php

class Database extends PDO {

	public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS) {
		parent::__construct($DB_TYPE . ':host=' . $DB_HOST . ';dbname=' . $DB_NAME, $DB_USER, $DB_PASS);

		//parent::setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTIONS);
	}

	/**
	 * List all the rows from the given table.
	 *
	 * @param string $table Name of the table.
	 *
	 * @param mixed $fields Array of fields that need be retrieved (* for all).
	 *
	 * @return array Result of the query as an associative array.
	 */
	public function select($table, $fields) {

		$fieldNames = NULL;
		if ($fields == '*') {
			$fieldNames = $fields;
		} else {
			foreach ($fields as $name) {
				$fieldNames .= "$name,";
			}
			$fieldNames = rtrim($fieldNames, ',');
		}

		$stmt = $this->prepare("SELECT $fieldNames FROM $table");

		$stmt->execute();

		return $stmt->fetchall();
	}

	public function selectOne($table, $fields) {

		$fieldNames = NULL;
		if ($fields == '*') {
			$fieldNames = $fields;
		} else {
			foreach ($fields as $name) {
				$fieldNames .= "$name,";
			}
			$fieldNames = rtrim($fieldNames, ',');
		}

		$stmt = $this->prepare("SELECT $fieldNames FROM $table");

		$stmt->execute();

		return $stmt->fetch();
	}

	/**
	 * List all the rows from the given table for a given condition.
	 *
	 * @param string $table Name of the table.
	 *
	 * @param mixed $fields Array of fields that need be retrieved (* for all).
	 *
	 * @param string $where WHERE condition in SQL query.
	 *
	 * @return array Result of the query as an associative array.
	 */
	public function selectWhere($table, $fields, $where, $params=array()) {

		$fieldNames = NULL;
		if ($fields == '*') {
			$fieldNames = $fields;
		} else {
			foreach ($fields as $name) {
				$fieldNames .= "$name,";
			}
			$fieldNames = rtrim($fieldNames, ',');
		}

		$stmt = $this->prepare("SELECT $fieldNames FROM $table WHERE $where");
		foreach ($params as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}
		$stmt->execute();

		return $stmt->fetchall();
	}

	public function selectOneWhere($table, $fields, $where, $params=array()) {

		$fieldNames = NULL;
		if ($fields == '*') {
			$fieldNames = $fields;
		} else {
			foreach ($fields as $name) {
				$fieldNames .= "$name,";
			}
			$fieldNames = rtrim($fieldNames, ',');
		}

		$stmt = $this->prepare("SELECT $fieldNames FROM $table WHERE $where");
		
		foreach ($params as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}
		
		$stmt->execute();

		return $stmt->fetch();
	}

	/**
	 * Insert a record to a table.
	 *
	 * @param string $table Name of the table.
	 *
	 * @param mixed $data Data need to be inserted to the database as an associative array.
	 */
	public function insert($table, $data) {
		$fieldNames = implode(',', array_keys($data));
		$fieldValues = ':' . implode(', :', array_keys($data));

		$stmt = $this->prepare("INSERT INTO $table ($fieldNames) VALUES ($fieldValues)");

		foreach ($data as $key => $value) {

			$stmt->bindValue(":$key", $value);
		}

		$stmt->execute();
	}

	/**
	 * Update a record in a table.
	 *
	 * @param string $table Name of the table.
	 *
	 * @param mixed $data Data need to be updated to the database as an associative array.
	 *
	 * @param string $where WHERE condition in SQL query.
	 */

	public function update($table, $data, $where, $params) {

		$fieldDetails = NULL;
		foreach ($data as $key => $value) {
			$fieldDetails .= "`$key` = :$key,";
		}
		$fieldDetails = rtrim($fieldDetails, ',');

		$stmt = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

		foreach ($data as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}

		foreach ($params as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}

		$stmt->execute();
	}

	/**
	 * Delete a record from a table.
	 *
	 * @param string $table Name of the table.
	 *
	 * @param string $where WHERE condition in SQL query.
	 */

	public function delete($table, $where, $params) {

		$stmt = $this->prepare("DELETE FROM $table WHERE $where");

		foreach ($params as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}

		$stmt->execute();
	}


	public function queryExecuteOnly($query) {
		$stmt = $this->prepare($query);
		$stmt->execute();
	}
	/**
	 * Delete a record from a table.
	 *
	 * @param string $query Custom query.
	 *
	 * @param string $where WHERE condition in SQL query.
	 */

	public function query($query) {

		$stmt = $this->prepare($query);

		$stmt->execute();

		return $stmt->fetchAll();
	}

	public function runQuery($query, $params=array()) {

		$stmt = $this->prepare($query);
		foreach ($params as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}
		$stmt->execute();

		return $stmt->fetchAll();
	}
}
