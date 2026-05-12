#!/usr/bin/php -q
<?php
require_once dirname(dirname(__FILE__)).'/test/lib/utils.php';

require_once TEST.'lib/Test-More.php';
require_once INC.'config_inc.php';
require_once INC.'utils.php';

diag('cleanCsvField');

plan(6);

is(cleanCsvField('=cmd|/C calc!A0'), "'=cmd|/C calc!A0", 'formula prefix');
is(cleanCsvField('+SUM(1,1)'), "'+SUM(1,1)", 'plus prefix');
is(cleanCsvField('-10'), "'-10", 'minus prefix');
is(cleanCsvField('@cmd'), "'@cmd", 'at prefix');
is(cleanCsvField(" \t=cmd"), "' \t=cmd", 'whitespace before formula prefix');
is(cleanCsvField('normal value'), 'normal value', 'normal value');
