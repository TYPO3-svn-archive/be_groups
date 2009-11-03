<?php
if (!defined ('TYPO3_MODE'))
	die ('Access denied.');

global $TYPO3_CONF_VARS, $_EXTKEY;
$configurationArray = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);

if (is_array($configurationArray) && array_key_exists('explicitAllow', $configurationArray) && $configurationArray['explicitAllow'] == 1) {
	$TYPO3_CONF_VARS['BE']['explicitADmode'] = 'explicitAllow';
}

?>