<?php

// Example slots for 09:00 - 09:10 on Mon (current week), Tue (1 week ahead), Wed (2 weeks ahead), Thu (3 weeks ahead), Fri (current week)
$GLOBALS['example_slots'] = array(
  array(
    'id' => 'sl-5e5f9bd4700174.12262196',
    'start_time' => date('Y-m-d', strtotime('monday this week')) . ' 09:00:00',
    'end_time' => date('Y-m-d', strtotime('monday this week')) . ' 09:10:00',
    'reserved' => true,
  ),
  array(
    'id' => 'sl-5e660eadc50c67.58518387',
    'start_time' => date('Y-m-d', strtotime('tuesday next week')) . ' 09:00:00',
    'end_time' => date('Y-m-d', strtotime('tuesday next week')) . ' 09:10:00',
    'reserved' => true,
  ),
  array(
    'id' => 'sl-5e66119ba93d15.30316867',
    'start_time' => date('Y-m-d', strtotime('wednesday +2 weeks')) . ' 09:00:00',
    'end_time' => date('Y-m-d', strtotime('wednesday +2 weeks')) . ' 09:10:00',
    'reserved' => true,
  ),
  array(
    'id' => 'sl-5e66129c4ea9a1.64500614',
    'start_time' => date('Y-m-d', strtotime('thursday +3 weeks')) . ' 09:00:00',
    'end_time' => date('Y-m-d', strtotime('thursday +3 weeks')) . ' 09:10:00',
    'reserved' => true,
  ),
  array(
    'id' => 'sl-5e5f9bd47004b7.86034960',
    'start_time' => date('Y-m-d', strtotime('friday this week')) . ' 09:00:00',
    'end_time' => date('Y-m-d', strtotime('friday this week')) . ' 09:10:00',
    'reserved' => true,
  ),
);

// Example slots between 09:00 and 10:00 for Monday next week
$GLOBALS['existing_slots_next_week'] = array(
  array(
    'id' => 'sl-5e660dcda05e97.76072091',
    'start_time' => date('Y-m-d', strtotime('monday next week')) . ' 09:00:00',
    'end_time' => date('Y-m-d', strtotime('monday next week')) . ' 09:10:00',
    'reserved' => true,
  ),
  array(
    'id' => 'sl-5e660dcda05fa6.30978386',
    'start_time' => date('Y-m-d', strtotime('monday next week')) . ' 09:10:00',
    'end_time' => date('Y-m-d', strtotime('monday next week')) . ' 09:20:00',
    'reserved' => false,
  ),
  array(
    'id' => 'sl-5e660dcda05fe8.15336455',
    'start_time' => date('Y-m-d', strtotime('monday next week')) . ' 09:20:00',
    'end_time' => date('Y-m-d', strtotime('monday next week')) . ' 09:30:00',
    'reserved' => false,
  ),
  array(
    'id' => 'sl-5e660dcda06013.12481526',
    'start_time' => date('Y-m-d', strtotime('monday next week')) . ' 09:30:00',
    'end_time' => date('Y-m-d', strtotime('monday next week')) . ' 09:40:00',
    'reserved' => false,
  ),
  array(
    'id' => 'sl-5e660dcda06059.06648636',
    'start_time' => date('Y-m-d', strtotime('monday next week')) . ' 09:50:00',
    'end_time' => date('Y-m-d', strtotime('monday next week')) . ' 10:00:00',
    'reserved' => false,
  ),
);

// Example slots between 09:00 and 10:00 for Monday two weeks ahead
$GLOBALS['existing_slots_two_weeks_ahead'] = array(
  array(
    'id' => 'sl-5e66119ba939c7.90476374',
    'start_time' => date('Y-m-d', strtotime('monday +2 weeks')) . ' 09:00:00',
    'end_time' => date('Y-m-d', strtotime('monday +2 weeks')) . ' 09:10:00',
    'reserved' => true,
  ),
  array(
    'id' => 'sl-5e66119ba93ac4.37015407',
    'start_time' => date('Y-m-d', strtotime('monday +2 weeks')) . ' 09:10:00',
    'end_time' => date('Y-m-d', strtotime('monday +2 weeks')) . ' 09:20:00',
    'reserved' => false,
  ),
  array(
    'id' => 'sl-5e66119ba93b18.90979794',
    'start_time' => date('Y-m-d', strtotime('monday +2 weeks')) . ' 09:20:00',
    'end_time' => date('Y-m-d', strtotime('monday +2 weeks')) . ' 09:30:00',
    'reserved' => false,
  ),
  array(
    'id' => 'sl-5e66119ba93b44.94481462',
    'start_time' => date('Y-m-d', strtotime('monday +2 weeks')) . ' 09:30:00',
    'end_time' => date('Y-m-d', strtotime('monday +2 weeks')) . ' 09:40:00',
    'reserved' => false,
  ),
  array(
    'id' => 'sl-5e66119ba93b75.02343056',
    'start_time' => date('Y-m-d', strtotime('monday +2 weeks')) . ' 09:50:00',
    'end_time' => date('Y-m-d', strtotime('monday +2 weeks')) . ' 10:00:00',
    'reserved' => false,
  ),
);
