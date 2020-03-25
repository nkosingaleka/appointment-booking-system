<?php

// Example table names
$GLOBALS['example_tables'] = array(
  'staff' => array(
    array(
      'id' => 'as-5e4685e3c899f1.04316598',
      'title' => 'Mr',
      'forename' => 'Matthew',
      'surname' => 'Johnson',
      'sex' => 'M',
      'job_title' => 'Receptionist',
    ),
    array(
      'id' => 'as-5e46873222d123.80231466',
      'title' => 'Mrs',
      'forename' => 'Stacey',
      'surname' => 'Rhodes',
      'sex' => 'F',
      'job_title' => 'Receptionist',
    ),
    array(
      'id' => 'ms-5e4685f6e57722.33264537',
      'title' => 'Dr',
      'forename' => 'Jin',
      'surname' => 'Xiao',
      'sex' => 'M',
      'job_title' => 'General Practitioner',
    ),
    array(
      'id' => 'ms-5e46874b062833.95604018',
      'title' => 'Dr',
      'forename' => 'Margaret',
      'surname' => 'Christchurch',
      'sex' => 'F',
      'job_title' => 'General Practitioner',
    ),
  ),
);

// Example column names
$GLOBALS['example_projections'] = array(
  'staff' => array(
    'title',
    'forename',
    'surname',
    'job_title',
  ),
);

// Example conditions to be checked in query
$GLOBALS['example_selections'] = array(
  'staff' => array(
    'title' => array(
      'comparison' => '=',
      'param' => ':title',
      'value' => 'Mr',
    ),
  ),
);

$GLOBALS['example_selections_revert'] = array(
  'staff' => array(
    'id' => array(
      'comparison' => '=',
      'param' => ':id',
      'value' => 'as-5e4685e3c899f1.04316598',
    ),
  ),
);

// Example invalid data
$GLOBALS['invalid_table'] = 'invalid-table-name';
$GLOBALS['invalid_projections'] = ['invalid-attribute'];
$GLOBALS['invalid_selections'] = array(
  'invalid-attribute' => array(
    'comparison' => '!',
    'param' => ':invalid-attribute',
    'value' => '',
  ),
);
$GLOBALS['invalid_join_tables'] = array('invalid-table-name');
$GLOBALS['invalid_join_conditions'] = array('invalid-table-name.id = also-invalid-table-name.id');

// Example join tables
$GLOBALS['example_join_tables'] = array(
  'staff' => array(
    'account',
  ),
);

//Example join conditions
$GLOBALS['example_join_conditions'] = array(
  'staff' => array(
    'account.id = staff.id',
  ),
);

// Example insert data
$GLOBALS['example_insert_data'] = array(
  'account' => array(
    'id' => array(
      'param' => ':id',
      'value' => 'test_id',
    ),
    'email' => array(
      'param' => ':email',
      'value' => 'test@test.com',
    ),
    'password' => array(
      'param' => ':password',
      'value' => 'test123',
    ),
    'role_id' => array(
      'param' => ':role_id',
      'value' => 1,
    ),
  ),
  'staff' => array(
    'id' => array(
      'param' => ':id',
      'value' => 'test_id',
    ),
    'title' => array(
      'param' => ':title',
      'value' => 'test_title',
    ),
    'forename' => array(
      'param' => ':forename',
      'value' => 'test_forename',
    ),
    'surname' => array(
      'param' => ':surname',
      'value' => 'test_surname',
    ),
    'job_title' => array(
      'param' => ':job_title',
      'value' => 'test_job_title',
    ),
  ),
);

// Example update data
$GLOBALS['example_update_data'] = array(
  'staff' => array(
    'title' => array(
      'param' => ':title_up',
      'value' => 'Dr',
    ),
  ),
);

$GLOBALS['example_update_data_revert'] = array(
  'staff' => array(
    'title' => array(
      'param' => ':title_up',
      'value' => 'Mr',
    ),
  ),
);
