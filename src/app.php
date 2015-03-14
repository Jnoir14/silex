<?php
$config = require __DIR__ . '/../config.inc.sample.php';

require __DIR__ . '/../vendor/autoload.php';


return new TestEmbauche\TestEmbaucheApplication($config);