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
 * Class "tx_country2language_scheduler" allows to add a new task
 * to import the Maxmind GeoIP database
 *
 * @package		TYPO3
 * @subpackage	country2language
 */
class tx_country2language_scheduler extends tx_scheduler_Task {
	
	/**
	 * Function executed from the Scheduler.
	 *
	 * @return	void
	 */
	public function execute() {
		$importer = t3lib_div::makeInstance('tx_country2language_import');
		return $importer->doImport();
	}
}
