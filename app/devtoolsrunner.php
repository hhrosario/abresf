<?php
set_time_limit(0);

require_once __DIR__.'/bootstrap.php.cache';
require_once __DIR__.'/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;

$input = new ArgvInput();
$env = $input->getParameterOption(array('--env', '-e'), getenv('SYMFONY_ENV') ?: 'dev');
$debug = !$input->hasParameterOption(array('--no-debug', ''));

$kernel = new AppKernel($env, $debug);

$devTools = new \SF\DevToolsBundle\DevTools($kernel);
$devTools->run();