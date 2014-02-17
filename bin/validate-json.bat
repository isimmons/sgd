@ECHO OFF
SET BIN_TARGET=%~dp0/../src/vendor/justinrainbow/json-schema/bin/validate-json
php "%BIN_TARGET%" %*
