<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011-2012 Benjamin Mack (benni@typo3.org)
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
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
/**
 * Class "tx_country2language_detect" allows to add a new task
 * to import the Maxmind GeoIP database
 *
 * @package		TYPO3
 * @subpackage	country2language
 */
class tx_country2language_detect {

	// the file where the country DB is locally stored
	protected $geoipCountryFile = NULL;

	/**
	 * loads the country infos in the TSFE clientInfo array
	 * uses a hook in TSFE->postProc-initialization
	 */
	public function loadCountryInfosInTsfe($params, &$pObj) {
		$clientIP = t3lib_div::getIndpEnv('REMOTE_ADDR');
		$infos = $this->getCountryInfos($clientIP);
		$pObj->clientInfo['COUNTRY_CODE'] = $infos['country_code'];
		$pObj->clientInfo['COUNTRY_NAME'] = $infos['country_name'];
	}


	/**
	 * checks if there is a configured language for this country
	 * 
	 * uses a hook in TSFE->settingLanguage
	 */
	public function setLanguageFromCountry($params, &$pObj) {
		$language = t3lib_div::_GP('L');

		// make sure to only load this info on the first page hit
		if ($language == NULL) {
			$TSConf = $pObj->getPagesTSconfig();
			$conf = $TSConf['tx_country2language.'];
			$countryCode = strtolower($pObj->clientInfo['COUNTRY_CODE']);
			if ($countryCode && $conf['enable'] == 1) {

					// redirect when nothing was set, make sure the language is set on this URL
				if (isset($conf['defaultRedirect.'][$countryCode])) {
					t3lib_Utility_Http::redirect($conf['defaultRedirect.'][$countryCode]);
				}

				
				if (isset($conf['mapping.'][$countryCode . '.'])) {
					foreach ($conf['mapping.'][$countryCode . '.'] as $getVariable => $getValue) {
						t3lib_div::_GETset($getValue, $getVariable);
					}
				}

			}
		}
	}


	/**
	 * fetches all country infos from a given IP address
	 * by querying the geoIP DB
	 * generic function
	 * 
	 * @param String $ipAddress
	 * @return array with two infos
	 */
	public function getCountryInfos($ipAddress) {

		$this->loadCountryFile();
		$gi = geoip_open(PATH_site . $this->geoipCountryFile, GEOIP_STANDARD);
		$res = geoip_country_code_by_addr($gi, $ipAddress);

		return array(
			'country_code' => strtolower(geoip_country_code_by_addr($gi, $ipAddress)),
			'country_name' => geoip_country_name_by_addr($gi, $ipAddress)
		);
	}

	/**
	 * loads the country file from the extension configuration
	 * in a variable accessible for the class
	 */
	protected function loadCountryFile() {
		if (!$this->geoipCountryFile) {
			require_once(t3lib_extMgm::extPath('country2language', 'Classes/Geoip/Geoip.php'));

			$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['country2language']);
			$this->geoipCountryFile = $extConf['geoipCountryFile'];
		}
	}


	/**
	 * helper function to fetch the region (contintent) by recursively 
	 * fetch the "territory" of the country code
	 **/
	public function getContinentFromCountryCode($countryCode) {
		if (t3lib_extMgm::isLoaded('static_info_tables')) {
			$countryInformation = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				'*',
				'static_countries',
				'cn_iso_2 = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr(strtoupper($countryCode), 'static_countries')
			);
			if (count($countryInformation)) {
				$countryInformation = reset($countryInformation);
				$parentTerritoryIsoNumber = $countryInformation['cn_parent_tr_iso_nr'];
				while ($parentTerritoryIsoNumber > 0) {
					$territoryInformation = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
						'*',
						'static_territories',
						'tr_iso_nr = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($parentTerritoryIsoNumber, 'static_territories')
					);
					$territoryInformation = reset($territoryInformation);
					$parentTerritoryIsoNumber = $territoryInformation['tr_parent_iso_nr'];
					if ($territoryInformation['tr_bane_en'] == 'Oceania') {
						return 'Australia';
					}
					
					// territory=21 is US, and the parent is 19, then it's north america
					if ($territoryInformation['tr_iso_nr'] == 21 && $parentTerritoryIsoNumber == 19) {
						return 'North America';
					} elseif ($parentTerritoryIsoNumber == 19) {
						return 'South America';
					}
				}
				return $territoryInformation['tr_name_en'];
			}
		}
		return NULL;
	}


}