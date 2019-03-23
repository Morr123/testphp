<?php

require __DIR__.'/../vendor/autoload.php';

use back\{App, Request};

session_start();

$app = new App(Request::initFromGlobal());
$app->start();