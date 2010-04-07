<?php
/***************************************************************
 *  Copyright notice
 *
 *  Copyright (c) 2009, Michael Klapper <michael.klapper@aoemedia.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Service hook to upate the "inc_access_lists" field from the current saved be_grups record
 *
 * class.tx_begroups_service_tcemain_hook.php
 *
 * @author Michael Klapper <michael.klapper@aoemedia.de>
 * @version $Id: class.tx_begroups_service_tcemain_hook.php $
 * @date 03.11.2009
 * @package TYPO3
 * @subpackage tx_begroups
 */
class tx_begroups_service_tcemain_hook {

	/**
	 * @var array
	 */
	private $setIncludeListFlag = array (
		0 => null,
		1 => true,
		2 => true,
		3 => false,
		4 => false,
		5 => false,
		6 => false,
		7 => false,
		8 => false,
	);

	/**
	 * Update inc_access_lists value if the table is "be_groups"
	 *
	 * @param array          $incommingFieldArray    Current record
	 * @param string         $table                  Database table of current record
	 * @param integer        $id                     Uid of current record
	 * @param t3lib_TCEmain  $parentObj
	 *
	 * @access     public
	 * @return     string
	 * 
	 * @author Michael Klapper <michael.klapper@aoemedia.de>
	 */
	public function processDatamap_preProcessFieldArray(&$incomingFieldArray, $table, $id, $parentObj) {
		if ($table == 'be_groups') {

				// reset all fields except the relevant for the current selected view
			if (! is_null($this->setIncludeListFlag[$incomingFieldArray['tx_begroups_kind']]) ) {
				$fieldsToKeepArray = array_keys(t3lib_beFunc::getTCAtypes('be_groups', $incomingFieldArray, 1));

				foreach ($incomingFieldArray as $column => $value) {
					if (! in_array($column, $fieldsToKeepArray) && (t3lib_div::testInt($id) === true) ) {
						$incomingFieldArray[$column] = null;
					}
				}
			}

				// update include access list flag
			if ($this->setIncludeListFlag[$incomingFieldArray['tx_begroups_kind']] === true) {
				$incomingFieldArray['inc_access_lists'] = 1;
			} elseif ($this->setIncludeListFlag[$incomingFieldArray['tx_begroups_kind']] === false) {
				$incomingFieldArray['inc_access_lists'] = 0;
			}
		}
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/be_groups/service/class.tx_begroups_service_tcemain_hook.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/be_groups/service/class.tx_begroups_service_tcemain_hook.php']);
}

?>