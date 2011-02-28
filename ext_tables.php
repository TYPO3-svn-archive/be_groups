<?php
if (!defined ('TYPO3_MODE'))
	die ('Access denied.');

	// Enable label_userFunc only for TYPO3 v 4.1 and higher
if (t3lib_div::int_from_ver(TYPO3_version) >= 4001000) {
	require_once t3lib_extMgm::extPath('be_groups') . 'service/class.user_begroups_service_tcaform_labelHelper.php';
	$TCA['be_groups']['ctrl']['label_userFunc'] = 'user_begroups_service_tcaform_labelHelper->getCombinedTitle';
}

$tempColumns = array (
	"tx_begroups_kind" => array (
		"exclude" => 1,
		"label"   => "LLL:EXT:be_groups/locallang_db.xml:be_groups.tx_begroups_kind",
		"config"  => array (
			"type"  => "select",
			"items" => array (
				array("LLL:EXT:be_groups/locallang_db.xml:be_groups.tx_begroups_kind.I.0", "0", t3lib_extMgm::extRelPath("be_groups")."selicon_be_groups_tx_begroups_kind_0.gif"),
				array("LLL:EXT:be_groups/locallang_db.xml:be_groups.tx_begroups_kind.I.1", "1", t3lib_extMgm::extRelPath("be_groups")."selicon_be_groups_tx_begroups_kind_1.gif"),
				array("LLL:EXT:be_groups/locallang_db.xml:be_groups.tx_begroups_kind.I.2", "2", t3lib_extMgm::extRelPath("be_groups")."selicon_be_groups_tx_begroups_kind_2.gif"),
				array("LLL:EXT:be_groups/locallang_db.xml:be_groups.tx_begroups_kind.I.3", "3", t3lib_extMgm::extRelPath("be_groups")."selicon_be_groups_tx_begroups_kind_3.gif"),
				array("LLL:EXT:be_groups/locallang_db.xml:be_groups.tx_begroups_kind.I.4", "4", t3lib_extMgm::extRelPath("be_groups")."selicon_be_groups_tx_begroups_kind_4.gif"),
				array("LLL:EXT:be_groups/locallang_db.xml:be_groups.tx_begroups_kind.I.5", "5", t3lib_extMgm::extRelPath("be_groups")."selicon_be_groups_tx_begroups_kind_5.gif"),
				array("LLL:EXT:be_groups/locallang_db.xml:be_groups.tx_begroups_kind.I.6", "6", t3lib_extMgm::extRelPath("be_groups")."selicon_be_groups_tx_begroups_kind_6.gif"),
				array("LLL:EXT:be_groups/locallang_db.xml:be_groups.tx_begroups_kind.I.7", "7", t3lib_extMgm::extRelPath("be_groups")."selicon_be_groups_tx_begroups_kind_7.gif"),
				array("LLL:EXT:be_groups/locallang_db.xml:be_groups.tx_begroups_kind.I.8", "8", t3lib_extMgm::extRelPath("be_groups")."selicon_be_groups_tx_begroups_kind_8.gif"),
			),
			"size"     => 1,
			"maxitems" => 1,
		)
	),
);

t3lib_div::loadTCA("be_groups");
t3lib_extMgm::addTCAcolumns("be_groups", $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes("be_groups","tx_begroups_kind;;;;1-1-1",'','after:title');
unset($tempColumns);

	// register the new types field
$TCA['be_groups']['ctrl']['type']            = 'tx_begroups_kind';
$TCA['be_groups']['ctrl']['typeicon_column'] = 'tx_begroups_kind';
$TCA['be_groups']['ctrl']['typeicons']       = array (
	'1' => t3lib_extMgm::extRelPath($_EXTKEY) . 'selicon_be_groups_tx_begroups_kind_1.gif',
	'2' => t3lib_extMgm::extRelPath($_EXTKEY) . 'selicon_be_groups_tx_begroups_kind_2.gif',
	'3' => t3lib_extMgm::extRelPath($_EXTKEY) . 'selicon_be_groups_tx_begroups_kind_3.gif',
	'4' => t3lib_extMgm::extRelPath($_EXTKEY) . 'selicon_be_groups_tx_begroups_kind_4.gif',
	'5' => t3lib_extMgm::extRelPath($_EXTKEY) . 'selicon_be_groups_tx_begroups_kind_5.gif',
	'6' => t3lib_extMgm::extRelPath($_EXTKEY) . 'selicon_be_groups_tx_begroups_kind_6.gif',
	'7' => t3lib_extMgm::extRelPath($_EXTKEY) . 'selicon_be_groups_tx_begroups_kind_7.gif',
	'8' => t3lib_extMgm::extRelPath($_EXTKEY) . 'selicon_be_groups_tx_begroups_kind_8.gif',
);

/**
	0 = all
	1 = authorization + extensions
	2 = language
	3 = meta
	4 = page access group
	5 = starting point of files system
	6 = starting point of page tree
	7 = tsconfig
	8 = workspace 
*/

	// display only groups of type "META" in usergroup select box
t3lib_div::loadTCA("be_users");
$TCA['be_users']['columns']['usergroup']['config']['foreign_table_where'] = ' AND hide_in_lists = 0 ORDER BY be_groups.title';
        // Reorder the list of be_users "usergroup" field
$TCA['be_users']['columns']['usergroup']['config']['foreign_table_where'] = ' AND hide_in_lists = 0 ORDER BY be_groups.tx_begroups_kind';

$tabExtended       = '';
$tabExtendedFields = '';
if (t3lib_extMgm::isLoaded('tt_news')) {
	$tabExtendedFields .= 'tt_news_categorymounts;;;;1-1-1, ';
}
if (t3lib_extMgm::isLoaded('dam')) {
	$tabExtendedFields .= 'tx_dam_mountpoints;;;;1-1-1, ';
} 
if (t3lib_extMgm::isLoaded('templavoila')) {
	$tabExtendedFields .= 'tx_templavoila_access;;;;1-1-1, ';
}
if (trim($tabExtendedFields) != '') {
	$tabExtended = '--div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.extended, ' . $tabExtendedFields;
}

	// define the new types and their showitems
$TCA['be_groups']['types']['0'] = array ('showitem' => 'hidden;;;;1-1-1, title;;;;2-2-2,tx_begroups_kind, description, subgroup;;;;3-3-3, --div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.base_rights, inc_access_lists;;;;1-1-1, groupMods, tables_select, tables_modify, pagetypes_select, non_exclude_fields, explicit_allowdeny , allowed_languages;;;;2-2-2, custom_options;;;;3-3-3, --div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.mounts_and_workspaces, db_mountpoints;;;;1-1-1,file_mountpoints, fileoper_perms, workspace_perms;;;;2-2-2, --div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.options, lockToDomain;;;;1-1-1, hide_in_lists;;;;2-2-2, TSconfig;;;;3-3-3, --div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.extended');
$TCA['be_groups']['types']['1'] = array ('showitem' => 'hidden;;;;1-1-1, title;;;;2-2-2,tx_begroups_kind, description, --div--;LLL:EXT:be_groups/locallang_db.xml:be_groups.tabs.modul_rights, groupMods, --div--;LLL:EXT:be_groups/locallang_db.xml:be_groups.tabs.table_rights, tables_select, tables_modify, --div--;LLL:EXT:be_groups/locallang_db.xml:be_groups.tabs.page_rights, pagetypes_select, --div--;LLL:EXT:be_groups/locallang_db.xml:be_groups.tabs.exclude_rights, non_exclude_fields, --div--;LLL:EXT:be_groups/locallang_db.xml:be_groups.tabs.pagecontent_rights, explicit_allowdeny, --div--;LLL:EXT:be_groups/locallang_db.xml:be_groups.tabs.custom_options, custom_options;;;;1-1-1,' . $tabExtended . ' --div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.options, lockToDomain;;;;1-1-1, hide_in_lists;;;;2-2-2');
$TCA['be_groups']['types']['2'] = array ('showitem' => 'hidden;;;;1-1-1, title;;;;2-2-2,tx_begroups_kind, description, --div--;LLL:EXT:be_groups/locallang_db.xml:be_groups.tabs.language_rights, allowed_languages, --div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.options, lockToDomain;;;;1-1-1, hide_in_lists;;;;2-2-2');
$TCA['be_groups']['types']['3'] = array ('showitem' => 'hidden;;;;1-1-1, title;;;;2-2-2,tx_begroups_kind, description, --div--;LLL:EXT:be_groups/locallang_db.xml:be_groups.tabs.subgroup, subgroup, --div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.options, lockToDomain;;;;1-1-1, hide_in_lists;;;;2-2-2');
$TCA['be_groups']['types']['4'] = array ('showitem' => 'hidden;;;;1-1-1, title;;;;2-2-2,tx_begroups_kind, description, --div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.options, lockToDomain;;;;1-1-1, hide_in_lists;;;;2-2-2');
$TCA['be_groups']['types']['5'] = array ('showitem' => 'hidden;;;;1-1-1, title;;;;2-2-2,tx_begroups_kind, description, --div--;LLL:EXT:be_groups/locallang_db.xml:be_groups.tabs.file_mount, file_mountpoints, fileoper_perms, --div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.options, lockToDomain;;;;1-1-1, hide_in_lists;;;;2-2-2');
$TCA['be_groups']['types']['6'] = array ('showitem' => 'hidden;;;;1-1-1, title;;;;2-2-2,tx_begroups_kind, description, --div--;LLL:EXT:be_groups/locallang_db.xml:be_groups.tabs.db_mount, db_mountpoints, --div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.options, lockToDomain;;;;1-1-1, hide_in_lists;;;;2-2-2'); 
$TCA['be_groups']['types']['7'] = array ('showitem' => 'hidden;;;;1-1-1, title;;;;2-2-2,tx_begroups_kind, description, --div--;LLL:EXT:be_groups/locallang_db.xml:be_groups.tabs.tsconfig, TSconfig, --div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.options, lockToDomain;;;;1-1-1, hide_in_lists;;;;2-2-2');
$TCA['be_groups']['types']['8'] = array ('showitem' => 'hidden;;;;1-1-1, title;;;;2-2-2,tx_begroups_kind, description, --div--;LLL:EXT:be_groups/locallang_db.xml:be_groups.tabs.workspace_rights, workspace_perms;;;;2-2-2, --div--;LLL:EXT:lang/locallang_tca.xml:be_groups.tabs.options, lockToDomain;;;;1-1-1, hide_in_lists;;;;2-2-2');

	// change field definition from multiselect to checkbox
$TCA['be_groups']['columns']['subgroup']['config']['renderMode']= 'checkbox';
$TCA['be_groups']['columns']['file_mountpoints']['config']['renderMode']= 'checkbox';
$TCA['be_groups']['columns']['file_mountpoints']['config']['wizards'] = null;
$TCA['be_groups']['columns']['pagetypes_select']['config']['renderMode']= 'checkbox';
//~ $TCA['be_groups']['columns']['groupMods']['config']['renderMode']= 'checkbox';
//~ $TCA['be_groups']['columns']['tables_modify']['config']['renderMode']= 'checkbox';
//~ $TCA['be_groups']['columns']['tables_select']['config']['renderMode']= 'checkbox';
//~ $TCA['be_groups']['columns']['non_exclude_fields']['config']['renderMode']= 'checkbox';

	// change list sorting from "title" to "tx_begroups_kind"
$TCA['be_groups']['ctrl']['default_sortby'] = 'ORDER BY tx_begroups_kind ASC';
?>
