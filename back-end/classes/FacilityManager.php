<?php

/**
 * Class for the FacilityManager component.
 *
 * @category Core Component
 */

/**
 * Represents the component for handling Facility related actions.
 */
class FacilityManager {
  /**
   * Retrieves Facililty contact details using a given id.
   *
   * @param string $facilityId ID of the facility contact details.
   * @return array Retrieved facility contact details.
   */
  public static function getContactDetails($facilityId) {
    // Define conditions to be checked in query
    $selections = array(
      'id' => array(
        'comparison' => '=',
        'param' => ':id',
        'value' => $facilityId,
      ),
    );

    // Define the attributes to be selected
    $projections = array('name', 'building_name', 'building_no', 'street', 'city', 'county', 'postcode', 'tel_no');

    // Retrieve the record containing the details whose facility ID matches the user's facility ID
    return $GLOBALS['app']->getDB()->selectOneWhere('facility', $selections, $projections);
  }
}
