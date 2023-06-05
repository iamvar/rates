# Rates

This project is the small Single Page Application on vue js and symfony as the backend.
Allows converting amount from one currency to another.

Information about currency rates can be taken from different sources.

Currently supports 

* https://www.ecb.europa.eu
* https://api.coindesk.com

To add additional source, you need just implement RateSourceInterface, symfony ServiceLocator will do the trick. 

More detailed instructions how to run it will be provided later, most probably with docker files.

Project was updated to the latest symfony/doctrine/php version and now is in maintenance mode due to significant backward incompatibilities.
Tests were updated to use pestphp framework.