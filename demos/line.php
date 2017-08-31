<?php
# debug
ini_set("error_reporting", E_ALL);
ini_set("display_errors", true);
ini_set("display_startup_errors", true);

# init
$path = __DIR__.'/../vendor/autoload.php';
include $path;
\PMVC\Load::plug();
\PMVC\addPlugInFolders([__DIR__.'/../../']);

$cli = \PMVC\plug('cli');
$cli->line();

