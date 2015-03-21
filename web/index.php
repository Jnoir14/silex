<?php
define('TESTEMBAUCHE_ROOT', __DIR__);
$app = include(__DIR__.'/../src/app.php');
require __DIR__.'/../src/routes.php';
require __DIR__.'/../src/TestEmbauche/Db_creator.php';
$app -> registerProviders();

$app->run();
