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
      echo 'Database connection failed: ' . $e->getMessage();
    }
  }

