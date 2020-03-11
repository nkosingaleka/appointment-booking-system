<?php

$GLOBALS['verified_users'] = array(
  'administrative' => array(
    'id' => 'as-5e4685e3c899f1.04316598',
    'role_id' => '1',
    'email' => 'as1@test.com',
  ),
  'medical' => array(
    'id' => 'ms-5e4685f6e57722.33264537',
    'role_id' => '2',
    'email' => 'ms1@test.com',
  ),
  'patient' => array(
    'id' => 'pa-5e4686095092e0.76300630',
    'role_id' => '3',
    'email' => 'pa1@test.com',
  ),
);

$GLOBALS['new_email'] = 'new@test.com';
$GLOBALS['invalid_email'] = 'invalidEmail';
$GLOBALS['nonexistent_email'] = 'nonexistent@test.com';

$GLOBALS['valid_password'] = 'test123';

$GLOBALS['patient_filled'] = array(
  'title' => 'Mr',
  'forename' => 'David',
  'surname' => 'Bowden',
  'sex' => 'M',
  'date_of_birth' => '1990-01-26',
  'house_name' => '',
  'house_no' => '12',
  'street' => 'Meyrick Road',
  'city' => 'Portsmouth',
  'county' => 'Hampshire',
  'postcode' => 'PO2 RJF',
  'tel_no' => '+447691014037',
  'mob_no' => '+448865738896',
  'next_of_kin' => 'nk-5e4693079a5e18.63580261',
  'nhs_no' => '4562594365',
  'hc_no' => '',
);

$GLOBALS['patient_empty'] = array(
  'title' => '',
  'forename' => '',
  'surname' => '',
  'sex' => '',
  'date_of_birth' => '',
  'house_name' => '',
  'house_no' => '',
  'street' => '',
  'city' => '',
  'county' => '',
  'postcode' => '',
  'tel_no' => '',
  'mob_no' => '',
  'next_of_kin' => '',
  'nhs_no' => '',
  'hc_no' => '',
);

$GLOBALS['nok_filled'] = array(
  'relationship' => 'Father',
  'title' => 'Mr',
  'forename' => 'Nerti',
  'surname' => 'Philson',
  'house_name' => '',
  'house_no' => '7',
  'street' => 'London Road',
  'city' => 'Southampton',
  'county' => 'Hampshire',
  'postcode' => 'SO15 2AE',
  'tel_no' => '+447691014037',
  'mob_no' => '+448865738896',
);

$GLOBALS['nok_empty'] = array(
  'relationship' => '',
  'title' => '',
  'forename' => '',
  'surname' => '',
  'house_name' => '',
  'house_no' => '',
  'street' => '',
  'city' => '',
  'county' => '',
  'postcode' => '',
  'tel_no' => '',
  'mob_no' => '',
);
