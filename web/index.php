<?php
$app = include(__DIR__.'/../src/app.php');

$app -> registerProviders();
$app -> registerRoutes();

$app->run();
