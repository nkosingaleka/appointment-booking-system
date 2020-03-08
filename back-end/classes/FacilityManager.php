<?php

/**
 * Represents the component for handling Facility related actions.
 */
class FacilityManager {
  /**
   * Retrieves Facililty contact details using a given id.
   *
   * @param string $facility_id ID of the facility contact details.
   * @return array Retrieved facility contact details.
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

    $result = $GLOBALS['app']->getDB()->selectOneWhere('facility', $selections, $projections);

    return $result;
  }
}
