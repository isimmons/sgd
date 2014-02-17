@ECHO OFF
SET BIN_TARGET=%~dp0/../src/vendor/seld/jsonlint/bin/jsonlint
php "%BIN_TARGET%" %*
