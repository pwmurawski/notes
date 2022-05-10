<?php
declare(strict_types=1);

namespace App;

require_once('src\Utils\debug.php');
require_once('src\Request.php');
require_once('src\Controller\NoteController.php');
require_once('src\Exception\AppException.php');
require_once('src\Exception\ConfigurationException.php');

$configuration =  require_once('config\config.php');

use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Exception\AppException;
use App\Exception\ConfigurationException;
use Throwable;

$request = new Request($_GET, $_POST, $_SERVER);

try {
    AbstractController::initConfiguration($configuration);
    (new NoteController($request))->run();
}
catch(ConfigurationException $e) {
    echo '<h1>Wystąpił błąd</h1>';
    echo '<h3>Problem z konfiguracja.</h3>';
}
catch(AppException $e) {
    echo '<h1>Wystąpił błąd</h1>';
    echo "<h3>{$e->getMessage()}</h3>";
}
catch(Throwable $e) {
    echo '<h1>Wystąpił błąd</h1>';
}