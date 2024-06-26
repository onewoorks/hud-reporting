<?php

//chdir('__DIR__');

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->handle(
	$input = new Symfony\Component\Console\Input\ArgvInput($_SERVER['argv']),
	new Symfony\Component\Console\Output\ConsoleOutput
);

exit($status);
