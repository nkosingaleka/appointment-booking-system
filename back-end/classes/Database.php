<?php

/**
 * Class for the Database component.
 *
 * @category Core Component
 */

/**
 * Represents the relational database used by the application.
 */
class Database {
  /**
   * PHP Data Object (PDO) for connecting to the database.
   *
   * @var object
   */
  private $__pdo;

  /**
   * Name of the host on which the database is held.
   *
   * @var string
   */
  private $__host;

  /**
   * Name of the database.
   *
   * @var string
   */
  private $__name;

  /**
   * Username of the user account used to access the database.
   *
   * @var string
   */
  private $__user;

  /**
   * Name of the driver, or DBMS, on which the database is held.
   *
   * @var string
   */
  private $__driver;

  /**
   * Password for the user account used to access the database.
   *
   * @var string
   */
  private $__password;

  /**
   * Creates a new Database using the given configuration parameters.
   *
   * @return void
   */
  public function __construct() {
    $config = array();
    $config_file = dirname(__FILE__) . '../../.config.ini';

    if (file_exists($config_file)) {
      // Read configuration parameters
      $config = parse_ini_file(realpath($config_file));
    } else {
      // Define default configuration parameters
      $config = array(
        'host' => '127.0.0.1',
        'user' => 'root',
        'dbname' => 'appointment_booking_system',
        'driver' => 'mysql',
        'password' => '',
      );
    }

    $this->__host = $config['host'];
    $this->__user = $config['user'];
    $this->__name = $config['dbname'];
    $this->__driver = $config['driver'];
    $this->__password = $config['password'];

    $this->__connect();
  }

  /**
   * Establishes a database connection using the given configuration parameters.
   *
   * @return void
   */
  private function __connect() {
    // Define Data Source Name
    $dsn = "{$this->__driver}:dname={$this->__name};host={$this->__host}";

    try {
      // Define connection
      $this->__pdo = new PDO($dsn, $this->__user, $this->__password);
      $this->__pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Selects data from the database using the given table name and projections (e.g. attribute names).
   *
   * @param string $table Name of the table from which to select data, as specified after the FROM clause.
   * @param array $projections Attributes to select, as specifed after the SELECT clause.
   * @return array Selected data, or nothing if none were found.
   */
  public function select($table, $projections = ['*']) {
    // Append database name to table name to avoid ambiguity
    $table = $this->__name . '.' . $table;

    // List projections separately
    $projections = implode(', ', $projections);

    try {
      $statement = $this->__pdo->prepare("SELECT $projections FROM $table");

      if ($statement->execute() && $statement->rowCount() > 0) {
        // Return fetched rows if successful
        return $statement->fetchAll(PDO::FETCH_ASSOC);
      }

      // Return empty array if unsuccessful
      return array();
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Selects data from the database using the given table name,
   * selections (e.g. comparisons), and (optional) projections (e.g. attribute names).
   *
   * @param string $table Name of the table from which to select data, as specified after the FROM clause.
   * @param array $selections Conditions to check against, as specified after the WHERE clause.
   * @param array $projections Attributes to select, as specifed after the SELECT clause.
   * @return array Selected data, or nothing if none were found.
   */
  public function selectOneWhere($table, $selections, $projections = ['*']) {
    // Append database name to table name to avoid ambiguity
    $table = $this->__name . '.' . $table;

    // List projections separately
    $projections = implode(', ', $projections);

    $conditions = '';
    $params = $values = array();

    foreach (array_keys($selections) as $key) {
      $params[] = $selections[$key]['param'];
      $values[] = $selections[$key]['value'];

      unset($selections[$key]['value']);

      $conditions .= $key . ' ' . implode(' ', $selections[$key]);
      $index = array_search($key, array_keys($selections));

      if ($index + 1 < count(array_keys($selections))) {
        // Append a space to all conditions apart from the last
        $conditions .= ' ';
      }
    }

    try {
      $statement = $this->__pdo->prepare("SELECT $projections FROM $table WHERE $conditions");

      for ($i = 0; $i < count(array_keys($selections)); $i += 1) {
        // Safely bind parameters with input values
        $statement->bindParam($params[$i], $values[$i]);
      }

      if ($statement->execute() && $statement->rowCount() > 0) {
        // Return fetched rows if successful
        return $statement->fetch(PDO::FETCH_ASSOC);
      }

      // Return empty array if unsuccessful
      return array();
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Selects multiple rows of data from the database using the given table name,
   * selections (e.g. comparisons), and (optional) projections (e.g. attribute names).
   *
   * @param string $table Name of the table from which to select data, as specified after the FROM clause.
   * @param array $selections Conditions to check against, as specified after the WHERE clause.
   * @param array $projections Attributes to select, as specifed after the SELECT clause.
   * @param boolean $bind Option to safely bind input parameters (default: true).
   * @return array Selected data, or nothing if none were found.
   */
  public function selectWhere($table, $selections, $projections = ['*'], $bind = true) {
    // Append database name to table name to avoid ambiguity
    $table = $this->__name . '.' . $table;

    // List projections separately
    $projections = implode(', ', $projections);

    $conditions = '';
    $params = $values = array();

    foreach (array_keys($selections) as $key) {
      $params[] = $selections[$key]['param'];
      $values[] = $selections[$key]['value'];

      unset($selections[$key]['value']);

      $conditions .= $key . ' ' . implode(' ', $selections[$key]);
      $index = array_search($key, array_keys($selections));

      if ($index + 1 < count(array_keys($selections))) {
        // Append a space to all conditions apart from the last
        $conditions .= ' ';
      }
    }

    try {
      $statement = $this->__pdo->prepare("SELECT $projections FROM $table WHERE $conditions");

      if ($bind) {
        for ($i = 0; $i < count(array_keys($selections)); $i += 1) {
          // Safely bind parameters with input values
          $statement->bindParam($params[$i], $values[$i]);
        }
      }

      if ($statement->execute() && $statement->rowCount() > 0) {
        // Return fetched rows if successful
        return $statement->fetchAll(PDO::FETCH_ASSOC);
      }

      // Return empty array if unsuccessful
      return array();
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Selects data from the database using the given table name,
   * join tables, join conditions, and (optional) projections (e.g. attribute names).
   *
   * @param string $table Name of the table from which to select data, as specified after the FROM clause.
   * @param array $join_tables Name of the tables on which to join the first table, as specified after the JOIN clause.
   * @param array $join_conditions Conditions on which to join the tables, as specified after the ON clause.
   * @param array $projections Attributes to select, as specifed after the SELECT clause.
   * @return array Selected data, or nothing if none were found.
   */
  public function selectJoin($table, $join_tables, $join_conditions, $projections = ['*']) {
    // Append database name to table names to avoid ambiguity
    $table = $this->__name . '.' . $table;

    for ($i = 0; $i < count($join_tables); $i += 1) {
      $join_tables[$i] = $this->__name . '.' . $join_tables[$i];
    }

    // List projections separately
    $projections = implode(', ', $projections);

    $query = "SELECT $projections FROM $table";

    for ($i = 0; $i < count($join_tables); $i += 1) {
      $query .= " JOIN $join_tables[$i] ON $join_conditions[$i]";
    }

    try {
      $statement = $this->__pdo->prepare($query);

      if ($statement->execute() && $statement->rowCount() > 0) {
        // Return fetched rows if successful
        return $statement->fetchAll(PDO::FETCH_ASSOC);
      }

      // Return empty array if unsuccessful
      return array();
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Selects data from the database using the given table name,
   * join tables, join conditions, selections (e.g. comparisons), and (optional) projections (e.g. attribute names).
   *
   * @param string $table Name of the table from which to select data, as specified after the FROM clause.
   * @param array $join_tables Name of the tables on which to join the first table, as specified after the JOIN clause.
   * @param array $join_conditions Conditions on which to join the tables, as specified after the ON clause.
   * @param array $selections Conditions to check against, as specified after the WHERE clause.
   * @param array $projections Attributes to select, as specifed after the SELECT clause.
   * @param boolean $bind Option to safely bind input parameters (default: true).
   * @return array Selected data, or nothing if none were found.
   */
  public function selectOneJoinWhere($table, $join_tables, $join_conditions, $selections, $projections = ['*'], $bind = true) {
    // Append database name to table names to avoid ambiguity
    $table = $this->__name . '.' . $table;

    for ($i = 0; $i < count($join_tables); $i += 1) {
      $join_tables[$i] = $this->__name . '.' . $join_tables[$i];
    }

    // List projections separately
    $projections = implode(', ', $projections);

    $conditions = '';
    $params = $values = array();

    foreach (array_keys($selections) as $key) {
      $params[] = $selections[$key]['param'];
      $values[] = $selections[$key]['value'];

      unset($selections[$key]['value']);

      $conditions .= $key . ' ' . implode(' ', $selections[$key]);
      $index = array_search($key, array_keys($selections));

      if ($index + 1 < count(array_keys($selections))) {
        // Append a space to all conditions apart from the last
        $conditions .= ' ';
      }
    }

    $query = "SELECT $projections FROM $table";

    for ($i = 0; $i < count($join_tables); $i += 1) {
      $query .= " JOIN $join_tables[$i] ON $join_conditions[$i]";
    }

    $query .= " WHERE $conditions";

    try {
      $statement = $this->__pdo->prepare($query);

      if ($bind) {
        for ($i = 0; $i < count(array_keys($selections)); $i += 1) {
          // Safely bind parameters with input values
          $statement->bindParam($params[$i], $values[$i]);
        }
      }

      if ($statement->execute() && $statement->rowCount() > 0) {
        // Return fetched row if successful
        return $statement->fetch(PDO::FETCH_ASSOC);
      }

      // Return empty array if unsuccessful
      return array();
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Selects data from the database using the given table name,
   * join tables, join conditions, selections (e.g. comparisons), and (optional) projections (e.g. attribute names).
   *
   * @param string $table Name of the table from which to select data, as specified after the FROM clause.
   * @param array $join_tables Name of the tables on which to join the first table, as specified after the JOIN clause.
   * @param array $join_conditions Conditions on which to join the tables, as specified after the ON clause.
   * @param array $selections Conditions to check against, as specified after the WHERE clause.
   * @param array $projections Attributes to select, as specifed after the SELECT clause.
   * @param boolean $bind Option to safely bind input parameters (default: true).
   * @return array Selected data, or nothing if none were found.
   */
  public function selectJoinWhere($table, $join_tables, $join_conditions, $selections, $projections = ['*'], $bind = true) {
    // Append database name to table names to avoid ambiguity
    $table = $this->__name . '.' . $table;

    for ($i = 0; $i < count($join_tables); $i += 1) {
      $join_tables[$i] = $this->__name . '.' . $join_tables[$i];
    }

    // List projections separately
    $projections = implode(', ', $projections);

    $conditions = '';
    $params = $values = array();

    foreach (array_keys($selections) as $key) {
      $params[] = $selections[$key]['param'];
      $values[] = $selections[$key]['value'];

      unset($selections[$key]['value']);

      $conditions .= $key . ' ' . implode(' ', $selections[$key]);
      $index = array_search($key, array_keys($selections));

      if ($index + 1 < count(array_keys($selections))) {
        // Append a space to all conditions apart from the last
        $conditions .= ' ';
      }
    }

    $query = "SELECT $projections FROM $table";

    for ($i = 0; $i < count($join_tables); $i += 1) {
      $query .= " JOIN $join_tables[$i] ON $join_conditions[$i]";
    }

    $query .= " WHERE $conditions";

    try {
      $statement = $this->__pdo->prepare($query);

      if ($bind) {
        for ($i = 0; $i < count(array_keys($selections)); $i += 1) {
          // Safely bind parameters with input values
          $statement->bindParam($params[$i], $values[$i]);
        }
      }

      if ($statement->execute() && $statement->rowCount() > 0) {
        // Return fetched rows if successful
        return $statement->fetchAll(PDO::FETCH_ASSOC);
      }

      // Return empty array if unsuccessful
      return array();
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Inserts data into the database using the given table name and data values.
   *
   * @param string $table Name of the table from which to select data, as specified after the SELECT clause.
   * @param array $data Data inserted into given table name and data values, as specified after the VALUES clause.
   * @return boolean Whether the statement is valid (true) or invalid (false) for execution.
   */
  public function insert($table, $data) {
    $params = $values = array();
    $table = $this->__name . '.' . $table;

    // List projections separately
    $projections = implode(', ', array_keys($data));

    foreach (array_keys($data) as $key) {
      $params[] = $data[$key]['param'];
      $values[] = $data[$key]['value'];

      unset($data[$key]['value']);
    }

    // List parameters separately
    $placeholders = implode(', ', $params);

    try {
      $statement = $this->__pdo->prepare("INSERT INTO $table ($projections) VALUES ($placeholders)");

      for ($i = 0; $i < count(array_keys($data)); $i += 1) {
        // Safely bind parameters with input values
        $statement->bindParam($params[$i], $values[$i]);
      }

      if ($statement->execute()) {
        // If successful
        return true;
      }

      // If unsuccessful
      return false;
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Updates data from the database using the given table name,
   * selections (e.g. comparions), and columns to be updated.
   *
   * @param string $table Name of the table from which to select data, as specified after the SELECT clause.
   * @param array $selections Conditions to check against, as specified after the WHERE clause.
   * @param array $update_columns Columns updated into given table names with updated data. as specified after the VALUES clause.
   * @return boolean Whether the statement is valid (true) or invalid (false) for execution.
   */
  public function updateWhere($table, $selections, $update_columns) {
    // Append database name to table name to avoid ambiguity
    $table = $this->__name . '.' . $table;

    $updates = '';
    $conditions = '';
    $select_params = $select_values = $update_params = $update_values = array();

    foreach (array_keys($selections) as $key) {
      $select_params[] = $selections[$key]['param'];
      $select_values[] = $selections[$key]['value'];

      unset($selections[$key]['value']);

      $conditions .= $key . ' ' . implode(' ', $selections[$key]);
      $index = array_search($key, array_keys($selections));

      if ($index + 1 < count(array_keys($selections))) {
        // Append a space to all conditions apart from the last
        $conditions .= ', ';
      }
    }

    foreach (array_keys($update_columns) as $key) {
      $update_params[] = $update_columns[$key]['param'];
      $update_values[] = $update_columns[$key]['value'];

      unset($update_columns[$key]['value']);

      $updates .= $key . ' = ' . implode(' ', $update_columns[$key]);
      $index = array_search($key, array_keys($update_columns));

      if ($index + 1 < count(array_keys($update_columns))) {
        // Append a space to all updated columns apart from the last
        $updates .= ', ';
      }
    }

    try {
      $statement = $this->__pdo->prepare("UPDATE $table SET $updates WHERE $conditions");

      for ($i = 0; $i < count(array_keys($selections)); $i += 1) {
        // Safely bind selection parameters with input values
        $statement->bindParam($select_params[$i], $select_values[$i]);
      }

      for ($i = 0; $i < count(array_keys($update_columns)); $i += 1) {
        // Safely bind update parameters with input values
        $statement->bindParam($update_params[$i], $update_values[$i]);
      }

      if ($statement->execute()) {
        // If successful
        return true;
      }

      // If unsuccessful
      return false;
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Deletes data from the database using the given table name and selections (e.g. comparions).
   *
   * @param string $table Name of the table from which to delete data, as specified after the DELETE clause.
   * @param array $selections Conditions to check against, as specified after the WHERE clause.
   * @return boolean Whether the statement is valid (true) or invalid (false) for execution.
   */
  public function deleteWhere($table, $selections) {
    // Append database name to table name to avoid ambiguity
    $table = $this->__name . '.' . $table;

    $conditions = '';
    $params = $values = array();

    foreach (array_keys($selections) as $key) {
      $params[] = $selections[$key]['param'];
      $values[] = $selections[$key]['value'];

      unset($selections[$key]['value']);

      $conditions .= $key . ' ' . implode(' ', $selections[$key]);
      $index = array_search($key, array_keys($selections));

      if ($index + 1 < count(array_keys($selections))) {
        // Append a space to all conditions apart from the last
        $conditions .= ' ';
      }
    }

    try {
      // Delete the data from the given table
      $statement = $this->__pdo->prepare("DELETE FROM $table WHERE $conditions");

      for ($i = 0; $i < count(array_keys($selections)); $i += 1) {
        // Safely bind parameters with input values
        $statement->bindParam($params[$i], $values[$i]);
      }

      if ($statement->execute()) {
        // If successful
        return true;
      }

      // If unsuccessful
      return false;
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Runs a given raw SQL query.
   *
   * @param string $query The SQL query to be run.
   * @return boolean Whether the statement is valid (true) or invalid (false) for execution.
   */
  public function rawSQL($query) {
    try {
      $statement = $this->__pdo->prepare($query);

      if ($statement->execute()) {
        // If successful
        return true;
      }

      // If unsuccessful
      return false;
    } catch (PDOException $e) {
      $GLOBALS['errors'][] = $e->getMessage();
    }
  }

  /**
   * Gets the PDO holding the database connection.
   *
   * @return void
   */
  public function getPDO() {
    return $this->__pdo;
  }
}
