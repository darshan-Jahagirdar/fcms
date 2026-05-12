#!/usr/bin/php -q
<?php
require_once dirname(dirname(__FILE__)).'/test/lib/utils.php';

require_once TEST.'lib/Test-More.php';
require_once INC.'config_inc.php';
require_once INC.'utils.php';

diag('cleanCsvField');

plan(6);

$quote = chr(39);

is(cleanCsvField(chr(61).'cmd'), $quote.chr(61).'cmd', 'formula prefix');
is(cleanCsvField(chr(43).'SUM(1,1)'), $quote.chr(43).'SUM(1,1)', 'plus prefix');
is(cleanCsvField(chr(45).'10'), $quote.chr(45).'10', 'minus prefix');
is(cleanCsvField(chr(64).'cmd'), $quote.chr(64).'cmd', 'at prefix');
is(cleanCsvField(chr(32).chr(9).chr(61).'cmd'), $quote.chr(32).chr(9).chr(61).'cmd', 'whitespace before formula prefix');
is(cleanCsvField('normal value'), 'normal value', 'normal value');
