<?php
/*
 * Register necessary class names with autoloader
 */
$extensionPath = t3lib_extMgm::extPath('country2language');
return array(
	'tx_country2language_import' => $extensionPath . 'Classes/Import.php',
	'tx_country2language_scheduler' => $extensionPath . 'Classes/Scheduler.php',
	'geoip' => $extensionPath . 'Classes/Geoip/Geoip.php'
);
