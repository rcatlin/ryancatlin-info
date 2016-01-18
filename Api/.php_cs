<?php

$config = new Refinery29\CS\Config\Refinery29();
$config->getFinder()
    ->exclude(['_tests', 'app', 'bower_components', 'node_modules', 'old_web', 'web']) // Remove/reduce after Refactor
    ->in(__DIR__)
;

$cacheDir = getenv('TRAVIS') ? getenv('HOME') . '/.php-cs-fixer' : __DIR__;

$config->setCacheFile($cacheDir . '/.php_cs.cache');

return $config;

