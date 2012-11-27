t3ext-country2language
======================

TYPO3 Extension: Country-To-Language GEO Mapping


Possible PagesTSconfig
======================

# Activate the country2language mappings
tx_country2language.enable = 1
# map "DE" to the GET variable &C=DE when the country is detected
tx_country2language.countryCodeGetVariable = C
tx_country2language.mapping {
	# Country Website Australia
	# Set the Language parameter to 45
	au.L = 45
	au.no_cache = 1

	# Country Website Germany
	# Set the Language parameter to 12
	de.L = 12

	# when no other mapping fits, then set the default values
	# default language is not "0", but "20" in this case
	default.L = 20
	default.renderInPink = 1
}
