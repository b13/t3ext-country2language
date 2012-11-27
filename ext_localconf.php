<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['tx_country2language_scheduler'] = array(
	'extension'        => 'country2language',
	'title'            => 'Maxmind GeoIP Database Import',
	'description'      => 'Automates the import of the GeoDB file (should be done monthly)',
	//'additionalFields' => 'tx_country2language_scheduler_additionalfieldprovider'
);

// hook so IP info is available in every request in $TSFE->clientInfo
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['tslib_fe-PostProc']['tx_country2language'] = 'EXT:country2language/Classes/Detect.php:&tx_country2language_detect->loadCountryInfosInTsfe';

// hook to choose whether the country should detect
// $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['settingLanguage_preProcess']['tx_country2language'] = 'EXT:country2language/Classes/Detect.php:&tx_country2language_detect->setLanguageFromCountry';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['determineId-PostProc']['tx_country2language'] = 'EXT:country2language/Classes/Detect.php:&tx_country2language_detect->setLanguageFromCountry';
