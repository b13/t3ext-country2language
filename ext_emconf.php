<?php

########################################################################
# Extension Manager/Repository config file for ext "country2language".
#
# Auto generated 22-09-2012 20:39
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'GeoIP Country to Language mapping',
	'description' => 'This extension detects the users\' country through MaxMind\'s GeoIP database (and updates that db monthly through the scheduler). Additionally one can choose the default language for the users\' country.',
	'category' => 'fe',
	'author' => 'Benjamin Mack',
	'author_email' => 'benni@typo3.org',
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.1.0',
	'constraints' => array(
		'depends' => array(
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:8:{s:16:"ext_autoload.php";s:4:"9070";s:21:"ext_conf_template.txt";s:4:"7cf1";s:12:"ext_icon.gif";s:4:"e922";s:17:"ext_localconf.php";s:4:"4814";s:18:"Classes/Detect.php";s:4:"25b5";s:18:"Classes/Import.php";s:4:"564d";s:21:"Classes/Scheduler.php";s:4:"73a5";s:23:"Classes/Geoip/Geoip.php";s:4:"6f10";}',
	'suggests' => array(
	),
);
