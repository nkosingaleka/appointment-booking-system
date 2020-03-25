<?php

$GLOBALS['existing_requests'] = array(
  array(
    'id' => 're-5e6b94fc6ba585.01295217',
    'reason' => 'I have had cramp in my foot for about 1 month now. I have tried taking medication but it has not helped.',
    'translation' => 'Romanian',
    'patient' => 'Mrs Jeanette Cowles',
    'staff' => 'Dr Margaret Christchurch',
    'slots' => array(
      array(
        'start_time' => '2020-03-31 09:00:00',
        'end_time' => '2020-03-31 09:10:00',
      ),
      array(
        'start_time' => '2020-04-16 09:00:00',
        'end_time' => '2020-04-16 09:10:00',
      ),
    ),
    'cancelled' => false,
    'patient_id' => 'pa-5e46875705e162.50418870',
    'staff_id' => 'ms-5e46874b062833.95604018',
    'contact_by_email' => false,
    'contact_by_text' => false,
    'appointment_type' => 'at-5e7c24qg2bv714.65342034',
    'appointment_type_title' => 'emergency',
  ),
  array(
    'id' => 're-5e6b94fc6ba585.16343542',
    'reason' => 'Prefer not to say.',
    'translation' => 'Romanian',
    'patient' => 'Mrs Jeanette Cowles',
    'staff' => 'Dr Margaret Christchurch',
    'slots' => array(
      array(
        'start_time' => '2020-04-17 09:00:00',
        'end_time' => '2020-04-17 09:10:00',
      ),
    ),
    'cancelled' => false,
    'patient_id' => 'pa-5e46875705e162.50418870',
    'staff_id' => 'ms-5e46874b062833.95604018',
    'contact_by_email' => false,
    'contact_by_text' => false,
    'appointment_type' => null,
    'appointment_type_title' => null,
  ),
  array(
    'id' => 're-5e6b94fc6ba585.23146570',
    'reason' => 'My little toe aches when I walk.',
    'translation' => 'Welsh',
    'patient' => 'Mr David Bowden',
    'staff' => 'Dr Jin Xiao',
    'slots' => array(
      array(
        'start_time' => '2020-04-18 09:30:00',
        'end_time' => '2020-04-18 09:40:00',
      ),
      array(
        'start_time' => '2020-04-18 09:50:00',
        'end_time' => '2020-04-18 10:00:00',
      ),
    ),
    'cancelled' => true,
    'patient_id' => 'pa-5e4686095092e0.7630063',
    'staff_id' => 'ms-5e4685f6e57722.33264537',
    'contact_by_email' => false,
    'contact_by_text' => false,
    'appointment_type' => null,
    'appointment_title' => null,
  ),
  array(
    'id' => 're-5e6b94fc6ba585.74287938',
    'reason' => 'I have a bad hip',
    'translation' => 'Welsh',
    'patient' => 'Mr David Bowden',
    'staff' => 'Dr Jin Xiao',
    'slots' => array(
      array(
        'start_time' => '2020-03-23 09:00:00',
        'end_time' => '2020-03-23 09:10:00',
      ),
      array(
        'start_time' => '2020-03-27 09:00:00',
        'end_time' => '2020-03-27 09:10:00',
      ),
      array(
        'start_time' => '2020-03-31 09:00:00',
        'end_time' => '2020-03-31 09:10:00',
      ),
      array(
        'start_time' => '2020-04-08 09:00:00',
        'end_time' => '2020-04-08 09:10:00',
      ),
      array(
        'start_time' => '2020-04-16 09:00:00',
        'end_time' => '2020-04-16 09:10:00',
      ),
    ),
    'cancelled' => false,
    'patient_id' => 'pa-5e4686095092e0.76300630',
    'staff_id' => 'ms-5e4685f6e57722.33264537',
    'contact_by_email' => false,
    'contact_by_text' => false,
    'appointment_type' => 'at-5e7c24qg2bv714.25342034',
    'appointment_type_title' => 'routine',
  ),
  array(
    'id' => 're-5e6b94fc6ba585.89234430',
    'reason' => 'My stomach sometimes has a burning sensation.',
    'translation' => 'Welsh',
    'patient' => 'Mr David Bowden',
    'staff' => 'Dr Jin Xiao',
    'slots' => ',',
    'slots' => array(
      array(
        'start_time' => '2020-04-18 09:30:00',
        'end_time' => '2020-04-18 09:40:00',
      ),
      array(
        'start_time' => '2020-04-18 09:50:00',
        'end_time' => '2020-04-18 10:00:00',
      ),
    ),
    'cancelled' => false,
    'patient_id' => 'pa-5e4686095092e0.76300630',
    'staff_id' => 'ms-5e4685f6e57722.33264537',
    'contact_by_email' => false,
    'contact_by_text' => false,
    'appointment_type' => 'at-5e7c24qg2bv714.25342034',
    'appointment_type_title' => 'routine',
  ),
);

// Example valid data to cancel a request
$GLOBALS['example_cancellation'] = array(
  'to_cancel' => 're-5e6b94fc6ba585.74287938',
  'cancellation_reason' => 'PHPUnit test',
  'requests' => array(
    array(
      'id' => 're-5e6b94fc6ba585.74287938',
      'reason' => 'I have a bad hip.',
      'translation' => 'Welsh',
      'title' => 'Dr',
      'forename' => 'Jin',
      'surname' => 'Xiao',
      'slots' => array(
        array(
          'start_time' => '2020-03-23 09:00:00',
          'end_time' => '2020-03-23 09:10:00'),
        array(
          'start_time' => '2020-03-27 09:00:00',
          'end_time' => '2020-03-27 09:10:00'),
        array(
          'start_time' => '2020-03-31 09:00:00',
          'end_time' => '2020-03-31 09:10:00'),
        array(
          'start_time' => '2020-04-08 09:00:00',
          'end_time' => '2020-04-08 09:10:00'),
        array(
          'start_time' => '2020-04-16 09:00:00',
          'end_time' => '2020-04-16 09:10:00'),
      ),
      'cancelled' => false,
      'patient_id' => 'pa-5e4686095092e0.76300630',
      'contact_by_email' => false,
      'contact_by_text' => false,
      'appointment_type' => 'at-5e7c24qg2bv714.25342034',
      'staff' => 'Dr Jin Xiao',
    ),
    array(
      'id' => 're-5e6b94fc6ba585.89234430',
      'reason' => 'My stomach sometimes has a burning sensation.',
      'translation' => 'Welsh',
      'title' => 'Dr',
      'forename' => 'Jin',
      'surname' => 'Xiao',
      'slots' => array(
        array(
          'start_time' => '2020-04-18 09:30:00',
          'end_time' => '2020-04-18 09:40:00',
        ),
        array(
          'start_time' => '2020-04-18 09:50:00',
          'end_time' => '2020-04-18 10:00:00',
        ),
      ),
      'cancelled' => false,
      'patient_id' => 'pa-5e4686095092e0.76300630',
      'contact_by_email' => false,
      'contact_by_text' => false,
      'appointment_type' => 'at-5e7c24qg2bv714.25342034',
      'staff' => 'Dr Jin Xiao',
    ),
  ),
  'patient_contact_by_email' => false,
  'patient_contact_by_text' => false,
);

// Example invalid and edge-case data for cancellations
$GLOBALS['cancellation_reason_255'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolore.';

$GLOBALS['cancellation_reason_256'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolores.';

// Example valid reasons
$GLOBALS['example_reasons'] = array(
  'example-empty' => '',
  'example-1' => 'I have a bad hip.',
  'example-2' => 'I would rather not say.',
  'example-3' => ' ',
);

// Example valid translation options
$GLOBALS['available_translations'] = array(
  'None' => array(
    'id' => 'none',
    'name' => 'None (English)',
  ),
  'Welsh' => array(
    'id' => 'la-5e6274fe2da8e7.62206293',
    'name' => 'Welsh',
  ),
  'Polish' => array(
    'id' => 'la-5e627504477ac0.53112804',
    'name' => 'Polish',
  ),
  'Bengali' => array(
    'id' => 'la-5e62752a775762.64611390',
    'name' => 'Bengali',
  ),
  'Gujarati' => array(
    'id' => 'la-5e62752a775924.80449764',
    'name' => 'Gujarati',
  ),
  'Arabic' => array(
    'id' => 'la-5e62752a775a30.18919537',
    'name' => 'Arabic',
  ),
  'Urdu' => array(
    'id' => 'la-5e62752a775a78.73040756',
    'name' => 'Urdu',
  ),
  'French' => array(
    'id' => 'la-5e62752a775aa8.85707788',
    'name' => 'French',
  ),
  'Romanian' => array(
    'id' => 'la-5e62752a775ae7.54844103',
    'name' => 'Romanian',
  ),
);

// Example valid appointment types
$GLOBALS['appointment_types'] = array(
  array(
    'id' => 'at-5e7c24qg2bv714.25342034',
    'title' => 'routine',
  ),
  array(
    'id' => 'at-5e7c24qg2bv714.65342034',
    'title' => 'emergency',
  ),
);
