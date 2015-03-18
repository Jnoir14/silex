<?php
$app = include(__DIR__.'/../src/app.php');
require __DIR__.'/../src/routes.php';
$app -> registerProviders();

$app->run();
