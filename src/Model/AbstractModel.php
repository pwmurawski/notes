<?php
declare(strict_types=1);

namespace App\Model;

require_once('src\Exception\StoargeException.php');
require_once('src\Exception\ConfigurationException.php');

use PDO;
use PDOException;
use App\Exception\StoargeException;
use App\Exception\ConfigurationException;

abstract class AbstractModel {
    protected PDO $connect;

    public function __construct(array $config) {
        try {
            $this->validConfig($config);
            $this->createConnect($config);
        } catch(PDOException $e) {
            throw new StoargeException('Connect error');
        }
    }

    private function createConnect(array $config): void {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->connect = new PDO(
            $dsn,
            $config['user'],
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
    }

    private function validConfig(array $config): void {
        if(empty($config['database'])
            || empty($config['host'])
            || empty($config['user'])
            || empty($config['password'])) {
            throw new ConfigurationException('Configuration error');
        }
    }
}