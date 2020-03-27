<?php

// Example appointment data
$GLOBALS['new_appointments'] = array(
  array(
    'patient_id' => 'pa-5e46875705e162.50418870',
    'contact_by_email' => 0,
    'contact_by_text' => 0,
    'request_id' => 're-5e6b94fc6ba585.01295217',
    'availability_id' => 'av-5e68fc14b59f24.32328100',
  ),
  array(
    'patient_id' => 'pa-5e46875705e162.50418870',
    'contact_by_email' => 0,
    'contact_by_text' => 0,
    'request_id' => 're-5e6b94fc6ba585.74287938',
    'availability_id' => 'av-5e68fc14b59f55.94401996',
  ),
  array(
    'patient_id' => 'pa-5e4686095092e0.76300630',
    'contact_by_email' => 0,
    'contact_by_text' => 0,
    'request_id' => 're-5e6b94fc6ba585.89234430',
    'availability_id' => 'av-5e68fc14b59fe0.25037064',
  ),
);

$GLOBALS['existing_appointments'] = array(
  array(
    'id' => 'ap-5e777c661e2a32.1539405',
    'start_time' => '',
    'reason' => '',
    'staff' => '',
    'translation' => '',
    'appointment_type' => '',
    'cancelled' => true,
    'patient_id' => 'pa-5e46875705e162.50418870',
    'contact_by_email' => 0,
    'contact_by_text' => 0,
    'request_id' => '5e6b94fc6ba585.16343542',
    'availability_id' => 'av-5e6902a6055882.31628169',
  ),
  array(
    'id' => 'ap-5e777c661e2a32.23234569',
    'start_time' => '2020-03-31 09:00:00',
    'reason' => 'I have had cramp in my foot for about 1 month now. I have tried taking medication but it has not helped.',
    'staff' => 'Dr Margaret Christchurch',
    'translation' => 'Romanian',
    'appointment_type' => 'emergency',
    'cancelled' => false,
    'patient_id' => 'pa-5e46875705e162.50418870',
    'contact_by_email' => 0,
    'contact_by_text' => 0,
    'request_id' => 're-5e6b94fc6ba585.01295217',
    'availability_id' => 'av-5e69054129f3f5.34077014',
  ),
  array(
    'id' => 'ap-5e777c661e2a32.34520912',
    'start_time' => '2020-04-08 09:00:00',
    'reason' => 'I have a bad hip.',
    'staff' => 'Dr Jin Xiao',
    'translation' => 'Welsh',
    'appointment_type' => 'routine',
    'cancelled' => false,
    'patient_id' => 'pa-5e4686095092e0.76300630',
    'contact_by_email' => 0,
    'contact_by_text' => 0,
    'request_id' => 're-5e6b94fc6ba585.74287938',
    'availability_id' => 'av-5e69021818dc41.25534831',
  ),
  array(
    'id' => 'ap-5e777c661e2a32.80096338',
    'start_time' => '2020-04-18 09:30:00',
    'reason' => 'My stomach sometimes has a burning sensation.',
    'staff' => 'Dr Jin Xiao',
    'translation' => 'Welsh',
    'appointment_type' => 'routine',
    'cancelled' => true,
    'patient_id' => 'pa-5e4686095092e0.76300630',
    'contact_by_email' => 0,
    'contact_by_text' => 0,
    'request_id' => 're-5e6b94fc6ba585.89234430',
    'availability_id' => 'av-5e6902a6055a25.54748758',
  ),
);

// Example cancellation data
$GLOBALS['example_appointment_cancellation'] = array(
  'to_cancel' => 'ap-5e777c661e2a32.23234569',
  'cancellation_reason' => 'Test reason.',
  'appointments' => $GLOBALS['existing_appointments'],
  'patient_id' => 'pa-5e46875705e162.50418870',
  'patient_contact_by_email' => false,
  'patient_contact_by_text' => false,
);

// Example invalid and edge-case data for cancellations
$GLOBALS['cancellation_reason_255'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolore.';

$GLOBALS['cancellation_reason_256'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolores.';
