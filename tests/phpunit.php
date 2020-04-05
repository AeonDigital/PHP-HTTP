<?php
$rootDir    = realpath(__DIR__ . "/..");
$tstSrcDir  = $rootDir . "/tests/src";
$tstFileDir = str_replace("/", DIRECTORY_SEPARATOR, $rootDir . "/tests/files");

require_once $rootDir . "/vendor/autoload.php";



// Stream
require_once $tstSrcDir . "/Stream/__provider.php";


// Uri
require_once $tstSrcDir . "/Uri/__provider.php";
require_once $tstSrcDir . "/Uri/concrete/BasicUri.php";
require_once $tstSrcDir . "/Uri/concrete/HierPartUri.php";
require_once $tstSrcDir . "/Uri/concrete/AbsoluteUri.php";


// Data
require_once $tstSrcDir . "/Data/__provider.php";


// Message
require_once $tstSrcDir . "/Message/__provider.php";
require_once $tstSrcDir . "/Message/concrete/Message.php";
