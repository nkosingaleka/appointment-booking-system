<?php

/**
 * Represents the component for handling Facility related actions.
 */
class FacilityManager {
  /**
   * Retrieves Facililty contact details using a given id.
   *
   * @param $facility_id
   * @return array
   */
  public static function getContactDetails($facility_id) {
    $selections = array(
      'id' => array(
        'comparison' => '=',
        'param' => ':id',
        'value' => $facility_id,
      ),
    );

    $projections = array('name', 'building_name', 'building_no', 'street', 'city', 'county', 'postcode', 'tel_no');

    $result = $GLOBALS['app']->getDB()->selectWhere('facility', $selections, $projections);

    return $result;
  }
}
