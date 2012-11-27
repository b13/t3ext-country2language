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
 * Class "tx_country2language_import" imports
 * the Maxmind GeoIP database
 *
 * @package		TYPO3
 * @subpackage	country2language
 */
class tx_country2language_import {

	// remote URL where the DB is located
	// usually http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz
	protected $geoipCountryUrl = NULL;

	// the file where to store it locally
	protected $geoipCountryFile = NULL;

	/**
	 * initializes the functions needed
	 */	
	public function __construct() {
		$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['country2language']);
		$this->geoipCountryUrl  = $extConf['geoipCountryUrl'];
		$this->geoipCountryFile = $extConf['geoipCountryFile'];
	}


	/**
	 * imports the remote file and extracts it
	 *
	 * @return boolean true on success
	 */
	public function doImport() {
		if ($this->geoipCountryUrl) {
			$data = t3lib_div::getURL($this->geoipCountryUrl);
			if ($data) {
				$downloadFile = PATH_site . dirname($this->geoipCountryFile) . '/' . basename($this->geoipCountryUrl);
				t3lib_div::writeFile($downloadFile, $data);

					// unzip the .gz file
				$cmd = '/bin/gunzip ' . $downloadFile;
				$res = t3lib_utility_Command::exec($cmd);
				$dbfile = PATH_site . dirname($this->geoipCountryFile) . '/' . substr(basename($this->geoipCountryUrl), 0, -3);
				$finalfile = PATH_site . $this->geoipCountryFile;
				rename($dbfile, $finalfile);
				if (is_file($finalfile)) {
					return TRUE;
				} else {
					return FALSE;
				}
			}
		}
		return TRUE;
	}
}
