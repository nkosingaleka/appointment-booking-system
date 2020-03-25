<?php

require 'data/DatabaseTestData.php';

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase {
  public function setUp(): void {
    $GLOBALS['errors'] = array();
  }

  public function testSelectRunsWithoutSpecifiedProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->select($table);

      $this->assertIsArray($rows);
      $this->assertNotEmpty($rows);

      for ($i = 0; $i < count($rows); $i += 1) {
        $this->assertIsArray($rows[$i]);
        $this->assertNotEmpty($rows[$i]);

        foreach (array_keys($GLOBALS['example_tables'][$table][$i]) as $column) {
          $this->assertEquals($rows[$i][$column], $GLOBALS['example_tables'][$table][$i][$column]);
        }
      }
    }

    $db = null;
  }

  public function testSelectRunsWithSpecifiedProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // Use projections to select only specified attributes
      $rows = $db->select($table, $GLOBALS['example_projections'][$table]);

      $this->assertIsArray($rows);
      $this->assertNotEmpty($rows);

      for ($i = 0; $i < count($rows); $i += 1) {
        $this->assertIsArray($rows[$i]);
        $this->assertNotEmpty($rows[$i]);

        foreach (array_keys($GLOBALS['example_tables'][$table][$i]) as $column) {
          if (key_exists($column, $GLOBALS['example_projections'][$table])) {
            $this->assertEquals($rows[$i][$column], $GLOBALS['example_tables'][$table][$i][$column]);
          }
        }
      }
    }

    $db = null;
  }

  public function testSelectFailsWithInvalidTableName() {
    $db = new Database();

    // No projections, use '*' by default to select all attributes
    $rows = $db->select($GLOBALS['invalid_table']);

    $this->assertNull($rows);
    $this->assertNotEmpty($GLOBALS['errors']);

    foreach ($GLOBALS['errors'] as $error) {
      // Check for 'Syntax error or access violation: 1064' error
      $this->assertStringContainsString('SQLSTATE[42000]', $error);
    }

    $db = null;
  }

  public function testSelectFailsWithInvalidProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // Use projections to select only specified attributes
      $rows = $db->select($table, $GLOBALS['invalid_projections']);

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Column not found: 1054' error
        $this->assertStringContainsString('SQLSTATE[42S22]', $error);
      }
    }

    $db = null;
  }

  public function testSelectOneWhereRunsWithoutSpecifiedProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $row = $db->selectOneWhere($table, $GLOBALS['example_selections'][$table]);

      $this->assertIsArray($row);
      $this->assertNotEmpty($row);

      foreach (array_keys($row) as $column) {
        if (key_exists($column, $GLOBALS['example_tables'][$table])) {
          $this->assertEquals($row[$column], $GLOBALS['example_tables'][$table][$column]);
        }
      }
    }

    $db = null;
  }

  public function testSelectOneWhereRunsWithSpecifiedProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // Use projections to select only specified attributes
      $row = $db->selectOneWhere(
        $table,
        $GLOBALS['example_selections'][$table],
        $GLOBALS['example_projections'][$table]
      );

      $this->assertIsArray($row);
      $this->assertNotEmpty($row);

      foreach (array_keys($row) as $column) {
        if (key_exists($column, $GLOBALS['example_tables'][$table])) {
          $this->assertEquals(
            $row[$column],
            $GLOBALS['example_tables'][$table][$column]
          );
        }
      }
    }

    $db = null;
  }

  public function testSelectOneWhereFailsWithInvalidTableName() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $row = $db->selectOneWhere(
        $GLOBALS['invalid_table'],
        $GLOBALS['example_selections'][$table]
      );

      $this->assertNull($row);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testSelectOneWhereFailsWithInvalidSelections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $row = $db->selectOneWhere($table, $GLOBALS['invalid_selections']);

      $this->assertNull($row);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'SQLSTATE[HY093]: Invalid parameter number' error
        $this->assertStringContainsString('SQLSTATE[HY093]', $error);
      }
    }

    $db = null;
  }

  public function testSelectOneWhereFailsWithInvalidProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // Use projections to select only specified attributes
      $row = $db->selectOneWhere(
        $table,
        $GLOBALS['example_selections'][$table],
        $GLOBALS['invalid_projections']
      );

      $this->assertNull($row);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Column not found: 1054' error
        $this->assertStringContainsString('SQLSTATE[42S22]', $error);
      }
    }

    $db = null;
  }

  public function testSelectWhereRunsWithoutSpecifiedProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->selectWhere($table, $GLOBALS['example_selections'][$table]);

      $this->assertIsArray($rows);
      $this->assertNotEmpty($rows);

      for ($i = 0; $i < count($rows); $i += 1) {
        $this->assertIsArray($rows[$i]);
        $this->assertNotEmpty($rows[$i]);

        foreach (array_keys($GLOBALS['example_tables'][$table][$i]) as $column) {
          if (key_exists($column, $GLOBALS['example_projections'][$table])) {
            $this->assertEquals(
              $rows[$i][$column],
              $GLOBALS['example_tables'][$table][$i][$column]
            );
          }
        }
      }
    }

    $db = null;
  }

  public function testSelectWhereRunsWithSpecifiedProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // Use projections to select only specified attributes
      $rows = $db->selectWhere(
        $table,
        $GLOBALS['example_selections'][$table],
        $GLOBALS['example_projections'][$table]
      );

      $this->assertIsArray($rows);
      $this->assertNotEmpty($rows);

      for ($i = 0; $i < count($rows); $i += 1) {
        $this->assertIsArray($rows[$i]);
        $this->assertNotEmpty($rows[$i]);

        foreach (array_keys($GLOBALS['example_tables'][$table][$i]) as $column) {
          if (key_exists($column, $GLOBALS['example_projections'][$table])) {
            $this->assertEquals(
              $rows[$i][$column],
              $GLOBALS['example_tables'][$table][$i][$column]
            );
          }
        }
      }
    }

    $db = null;
  }

  public function testSelectWhereFailsWithInvalidTableName() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->selectWhere(
        $GLOBALS['invalid_table'],
        $GLOBALS['example_selections'][$table]
      );

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testSelectWhereFailsWithInvalidSelections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->selectWhere($table, $GLOBALS['invalid_selections']);

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'SQLSTATE[HY093]: Invalid parameter number' error
        $this->assertStringContainsString('SQLSTATE[HY093]', $error);
      }
    }

    $db = null;
  }

  public function testSelectWhereFailsWithInvalidProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // Use projections to select only specified attributes
      $rows = $db->selectWhere(
        $table,
        $GLOBALS['example_selections'][$table],
        $GLOBALS['invalid_projections']
      );

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Column not found: 1054' error
        $this->assertStringContainsString('SQLSTATE[42S22]', $error);
      }
    }

    $db = null;
  }

  public function testSelectJoinRunsWithoutSpecifiedProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->selectJoin(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table]
      );

      $this->assertIsArray($rows);
      $this->assertNotEmpty($rows);

      for ($i = 0; $i < count($rows); $i += 1) {
        $this->assertIsArray($rows[$i]);
        $this->assertNotEmpty($rows[$i]);

        foreach (array_keys($GLOBALS['example_tables'][$table][$i]) as $column) {
          if (key_exists($column, $GLOBALS['example_projections'][$table])) {
            $this->assertEquals(
              $rows[$i][$column],
              $GLOBALS['example_tables'][$table][$i][$column]
            );
          }
        }
      }
    }

    $db = null;
  }

  public function testSelectJoinRunsWithSpecifiedProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // Use projections to select only specified attributes
      $rows = $db->selectJoin(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['example_projections'][$table]
      );

      $this->assertIsArray($rows);
      $this->assertNotEmpty($rows);

      for ($i = 0; $i < count($rows); $i += 1) {
        $this->assertIsArray($rows[$i]);
        $this->assertNotEmpty($rows[$i]);

        foreach (array_keys($GLOBALS['example_tables'][$table][$i]) as $column) {
          if (key_exists($column, $GLOBALS['example_projections'][$table])) {
            $this->assertEquals(
              $rows[$i][$column],
              $GLOBALS['example_tables'][$table][$i][$column]
            );
          }
        }
      }
    }

    $db = null;
  }

  public function testSelectJoinFailsWithInvalidTableName() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->selectJoin(
        $GLOBALS['invalid_table'],
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table]
      );

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testSelectJoinFailsWithInvalidProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // Use projections to select only specified attributes
      $rows = $db->selectJoin(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['invalid_projections']
      );

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Column not found: 1054' error
        $this->assertStringContainsString('SQLSTATE[42S22]', $error);
      }
    }

    $db = null;
  }

  public function testSelectJoinFailsWithInvalidJoinTableName() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->selectJoin(
        $table,
        $GLOBALS['invalid_join_tables'],
        $GLOBALS['example_join_conditions'][$table]
      );

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testSelectJoinFailsWithInvalidJoinConditions() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->selectJoin(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['invalid_join_conditions']
      );

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testSelectOneJoinWhereRunsWithoutSpecifiedProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $row = $db->selectOneJoinWhere(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['example_selections'][$table]
      );

      $this->assertIsArray($row);
      $this->assertNotEmpty($row);

      foreach (array_keys($row) as $column) {
        if (key_exists($column, $GLOBALS['example_tables'][$table])) {
          $this->assertEquals(
            $row[$column],
            $GLOBALS['example_tables'][$table][$column]
          );
        }
      }
    }

    $db = null;
  }

  public function testSelectOneJoinWhereRunsWithSpecifiedProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // Use projections to select only specified attributes
      $row = $db->selectOneJoinWhere(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['example_selections'][$table],
        $GLOBALS['example_projections'][$table]
      );

      $this->assertIsArray($row);
      $this->assertNotEmpty($row);

      foreach (array_keys($row) as $column) {
        if (key_exists($column, $GLOBALS['example_tables'][$table])) {
          $this->assertEquals(
            $row[$column],
            $GLOBALS['example_tables'][$table][$column]
          );
        }
      }
    }

    $db = null;
  }

  public function testSelectOneJoinWhereFailsWithInvalidTableName() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $row = $db->selectOneJoinWhere(
        $GLOBALS['invalid_table'],
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['example_selections'][$table]
      );

      $this->assertNull($row);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testSelectOneJoinWhereFailsWithInvalidProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // Use projections to select only specified attributes
      $row = $db->selectOneJoinWhere(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['example_selections'][$table],
        $GLOBALS['invalid_projections']
      );

      $this->assertNull($row);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Column not found: 1054' error
        $this->assertStringContainsString('SQLSTATE[42S22]', $error);
      }
    }

    $db = null;
  }

  public function testSelectOneJoinWhereFailsWithInvalidJoinTableName() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $row = $db->selectOneJoinWhere(
        $table,
        $GLOBALS['invalid_join_tables'],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['example_selections'][$table]
      );

      $this->assertNull($row);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testSelectOneJoinWhereFailsWithInvalidJoinConditions() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $row = $db->selectOneJoinWhere(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['invalid_join_conditions'],
        $GLOBALS['example_selections'][$table]
      );

      $this->assertNull($row);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testSelectOneJoinWhereFailsWithInvalidSelections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $row = $db->selectOneJoinWhere(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['invalid_selections']
      );

      $this->assertNull($row);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'SQLSTATE[HY093]: Invalid parameter number' error
        $this->assertStringContainsString('SQLSTATE[HY093]', $error);
      }
    }

    $db = null;
  }

  public function testSelectJoinWhereRunsWithoutSpecifiedProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->selectJoinWhere(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['example_selections'][$table]
      );

      $this->assertIsArray($rows);
      $this->assertNotEmpty($rows);

      for ($i = 0; $i < count($rows); $i += 1) {
        $this->assertIsArray($rows[$i]);
        $this->assertNotEmpty($rows[$i]);

        foreach (array_keys($GLOBALS['example_tables'][$table][$i]) as $column) {
          if (key_exists($column, $GLOBALS['example_projections'][$table])) {
            $this->assertEquals(
              $rows[$i][$column],
              $GLOBALS['example_tables'][$table][$i][$column]
            );
          }
        }
      }
    }

    $db = null;
  }

  public function testSelectJoinWhereRunsWithSpecifiedProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // Use projections to select only specified attributes
      $rows = $db->selectJoinWhere(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['example_selections'][$table],
        $GLOBALS['example_projections'][$table]
      );

      $this->assertIsArray($rows);
      $this->assertNotEmpty($rows);

      for ($i = 0; $i < count($rows); $i += 1) {
        $this->assertIsArray($rows[$i]);
        $this->assertNotEmpty($rows[$i]);

        foreach (array_keys($GLOBALS['example_tables'][$table][$i]) as $column) {
          if (key_exists($column, $GLOBALS['example_projections'][$table])) {
            $this->assertEquals(
              $rows[$i][$column],
              $GLOBALS['example_tables'][$table][$i][$column]
            );
          }
        }
      }
    }

    $db = null;
  }

  public function testSelectJoinWhereFailsWithInvalidTableName() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->selectJoinWhere(
        $GLOBALS['invalid_table'],
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['example_selections'][$table]
      );

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testSelectJoinWhereFailsWithInvalidProjections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // Use projections to select only specified attributes
      $rows = $db->selectJoinWhere(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['example_selections'][$table],
        $GLOBALS['invalid_projections']
      );

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Column not found: 1054' error
        $this->assertStringContainsString('SQLSTATE[42S22]', $error);
      }
    }

    $db = null;
  }

  public function testSelectJoinWhereFailsWithInvalidJoinTableName() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->selectJoinWhere(
        $table,
        $GLOBALS['invalid_join_tables'],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['example_selections'][$table]
      );

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testSelectJoinWhereFailsWithInvalidJoinConditions() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->selectJoinWhere(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['invalid_join_conditions'],
        $GLOBALS['example_selections'][$table]
      );

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testSelectJoinWhereFailsWithInvalidSelections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      // No projections, use '*' by default to select all attributes
      $rows = $db->selectJoinWhere(
        $table,
        $GLOBALS['example_join_tables'][$table],
        $GLOBALS['example_join_conditions'][$table],
        $GLOBALS['invalid_selections']
      );

      $this->assertNull($rows);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'SQLSTATE[HY093]: Invalid parameter number' error
        $this->assertStringContainsString('SQLSTATE[HY093]', $error);
      }
    }

    $db = null;
  }

  public function testInsertRunsWithValidData() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_insert_data']) as $table) {
      $result = $db->insert($table, $GLOBALS['example_insert_data'][$table]);

      $this->assertTrue($result);
      $this->assertEmpty($GLOBALS['errors']);
    }

    $selections = array(
      'id' => array(
        'comparison' => '=',
        'param' => ':id',
        'value' => 'test_id',
      ),
    );

    // Remove inserted data again for further tests
    $db->deleteWhere('staff', $selections);
    $db->deleteWhere('account', $selections);

    $db = null;
  }

  public function testInsertFailsWithInvalidTableName() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_insert_data']) as $table) {
      $result = $db->insert(
        $GLOBALS['invalid_table'],
        $GLOBALS['example_insert_data'][$table]
      );

      $this->assertNull($result);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'SQLSTATE[42000]: Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testUpdateWhereRunsWithValidData() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      $result = $db->updateWhere(
        $table,
        $GLOBALS['example_selections'][$table],
        $GLOBALS['example_update_data'][$table]
      );

      $this->assertTrue($result);
      $this->assertEmpty($GLOBALS['errors']);

      // Revert the changed values for further testing
      $db->updateWhere(
        $table,
        $GLOBALS['example_selections_revert'][$table],
        $GLOBALS['example_update_data_revert'][$table]
      );
    }

    $db = null;
  }

  public function testUpdateWhereFailsWithInvalidTableName() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      $result = $db->updateWhere(
        $GLOBALS['invalid_table'],
        $GLOBALS['example_selections'][$table],
        $GLOBALS['example_update_data'][$table]
      );

      $this->assertNull($result);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'SQLSTATE[42000]: Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testUpdateWhereFailsWithInvalidSelections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      $result = $db->updateWhere(
        $table,
        $GLOBALS['invalid_selections'],
        $GLOBALS['example_update_data'][$table]
      );

      $this->assertNull($result);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'SQLSTATE[HY093]: Invalid parameter number' error
        $this->assertStringContainsString('SQLSTATE[HY093]', $error);
      }
    }

    $db = null;
  }

  public function testDeleteWhereFailsWithInvalidTableName() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      $result = $db->deleteWhere(
        $GLOBALS['invalid_table'],
        $GLOBALS['example_selections'][$table]
      );

      $this->assertNull($result);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'SQLSTATE[42000]: Syntax error or access violation: 1064' error
        $this->assertStringContainsString('SQLSTATE[42000]', $error);
      }
    }

    $db = null;
  }

  public function testdeleteWhereFailsWithInvalidSelections() {
    $db = new Database();

    foreach (array_keys($GLOBALS['example_tables']) as $table) {
      $result = $db->deleteWhere(
        $table,
        $GLOBALS['invalid_selections']
      );

      $this->assertNull($result);
      $this->assertNotEmpty($GLOBALS['errors']);

      foreach ($GLOBALS['errors'] as $error) {
        // Check for 'SQLSTATE[HY093]: Invalid parameter number' error
        $this->assertStringContainsString('SQLSTATE[HY093]', $error);
      }
    }

    $db = null;
  }

  public function testPDOCanBeCreated() {
    $db = new Database();
    $pdo = $db->getPDO();

    $this->assertIsObject($db);

    $db = null;
  }
}
