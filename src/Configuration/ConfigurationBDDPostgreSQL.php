<?php

namespace App\PlusCourtChemin\Configuration;

use Exception;
use PDO;

class ConfigurationBDDPostgreSQL implements ConfigurationBDDInterface
{
    private string $nomBDD = "gis";
    private string $hostname = "localhost";
    private string $port = "25432";


    public function getLogin(): string
    {
        return "docker";
    }

    public function getMotDePasse(): string
    {
        return "AgzGlu96xxUL2ey7DzTi";
    }

    public function getDSN() : string{
        return "pgsql:host={$this->hostname};port={$this->port};dbname={$this->nomBDD};options='--client_encoding=UTF8'";
    }

    public function getOptions() : array {
        return array();
    }
}
