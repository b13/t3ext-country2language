# TYPO3 Extension: Country-To-Language GEO Mapping (country2language)

The extension allows to take the free GeoIP database, which can be automatically updated by a Scheduler task, downloaded and unzipped from MaxMind. Then, on a per-pagetree-basis, one can enable the language detection in the PageTSconfig section on the root page of a pagetree.

## PageTSconfig options

Please note that the following options are only used when there is no language parameter given in the URL.


### Activate the country2language mappings

You can enable the language-detection based on the country with the following option

	tx_country2language.enable = 1


### Set language-parameter based on the country

Set &L=45 and &no_cache=1 when the visitor is from Australia

	tx_country2language.mapping {
		au.L = 45
		au.no_cache = 1
	}


### Default GET parameters when no country options are set

When no other mapping fits, then set the default values default language is not "0", but "20" in this case.

	tx_country2language.mapping {
		default.L = 20
		default.renderInPink = 1
	}

### different languages based on browser languages

	tx_country2language.mapping {
		# in canada, english is default
		ca.L = 4
		# canadians with a french browser should go canadian french
		fr-ca.L = 3
	}


### Default redirects in countries

Redirect to this URL when no language is set and coming from this country.

	tx_country2language.defaultRedirect {
		fr = /fr-FR/
		en = /en-INT/
		de = /de-DE/
		ca = /en-CA/
		fr-ca = /fr-CA/
		uk = /en-UK/
	}


### Map the country code to a GET variable

Map the detected country code to the GET variable "C", which means that users from Germany will have &C=DE in their URL.

	tx_country2language.countryCodeGetVariable = C

### Set a default country code, if the IP couldn't be found

Sometimes, it is necessary to set the default country code, if the GeoIP detection has failed.

	tx_country2language.defaultCountryCode = UK
