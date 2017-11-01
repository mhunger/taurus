<?php
require_once __DIR__ . "/../vendor/autoload.php";

use legaltech\Application;

(new Application)
    ->boot()
    ->run();