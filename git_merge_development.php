#!/usr/bin/env php
<?php 

use App\Cmd;
use App\Environment;

require __DIR__.'/lib/vendor/autoload.php';
Environment::init(__DIR__);

// specify the spec as human readable text and run validation and help:
$values = CLIOpts\CLIOpts::run("
  Usage:
  -m, --master master only
  -p, --prod prod only
  -h, --help show this help
");

$do_all = (!isset($values['m']) AND !isset($values['p']));
$do_master = ($do_all OR isset($values['m']));
$do_production = ($do_all OR isset($values['p']));

// get current branch
try {
    $current_branch = null;
    $current_branch = Cmd::doCmd('git rev-parse --abbrev-ref HEAD 2>&1');
} catch (Exception $e) { handleException($e); }

if (!$current_branch) { echo "Current Branch not found\n"; exit(1); }
if ($current_branch != "development") { echo "Unexpected current branch of $current_branch\n"; exit(1); }


if ($do_master) {
    // push to master
    echo "Checkout Master\n";
    try {
        Cmd::doCmd('git checkout master 2>&1');
    } catch (Exception $e) { handleException($e); }

    echo "Merge development into Master\n";
    try {
        Cmd::doCmd('git merge development 2>&1');
    } catch (Exception $e) { handleException($e); }
}


if ($do_production) {
    // push to production
    echo "Checkout Production\n";
    try {
        Cmd::doCmd('git checkout production 2>&1');
    } catch (Exception $e) { handleException($e); }

    echo "Merge development into Production\n";
    try {
        Cmd::doCmd('git merge development 2>&1');
    } catch (Exception $e) { handleException($e); }
}


echo "Checkout Development\n";
try {
    Cmd::doCmd('git checkout development 2>&1');
} catch (Exception $e) { handleException($e); }






function handleException($e) {
    echo "################################################\nFailed [".$e->getCode()."]: ".$e->getMessage()."\n################################################\n";
}