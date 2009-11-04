<?php
if (!defined ('TYPO3_MODE'))
	die ('Access denied.');

global $TYPO3_CONF_VARS, $_EXTKEY;
$configurationArray = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);

if (is_array($configurationArray) && array_key_exists('explicitAllow', $configurationArray) && $configurationArray['explicitAllow'] == 1) {
	$TYPO3_CONF_VARS['BE']['explicitADmode'] = 'explicitAllow';
}

// register hook to update the include access list option
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:be_groups/service/class.tx_begroups_service_tcemain_hook.php:tx_begroups_service_tcemain_hook';

?>