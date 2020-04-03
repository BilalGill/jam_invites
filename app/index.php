<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);

require ROOT . 'vendor/autoload.php';

//require '/vendor/autoload.php';

//require APP . 'config/database.php';

use JamInvites\App;

$app = new App();
