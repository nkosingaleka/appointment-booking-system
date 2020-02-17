<?php

/**
 * Represents the relational database used by the application.
 */
class Database {
  private $__pdo;
  private $__host;
  private $__name;
  private $__user;
  private $__driver;
  private $__password;

  /**
   * Creates a new Database using the given configuration parameters.
   *
   */
  public function __construct() {
    // Read configuration parameters
    $config = parse_ini_file(realpath(dirname(__FILE__) . '../../.config.ini'));

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
   * Selects data from the database using the given table name,
   * selections (e.g. comparisons), and (optional) projections (e.g. attribute names).
   *
   * @param $table
   * @param $selections
   * @param $projections
   * @return array
   */
  public function selectWhere($table, $selections, $projections = ['*']) {
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
  }

  /**
   * Inserts data into the database using the given table name and data values.
   *
   * @param $table
   * @param $data
   * @return boolean
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
