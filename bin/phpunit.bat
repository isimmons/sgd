@ECHO OFF
SET BIN_TARGET=%~dp0/../src/vendor/phpunit/phpunit/composer/bin/phpunit
php "%BIN_TARGET%" %*
