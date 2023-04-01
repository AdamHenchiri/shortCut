<?php

namespace App\PlusCourtChemin\Configuration;

use Exception;
use PDO;

class ConfigurationBDDPostgreSQL implements ConfigurationBDDInterface
{
    private string $nomBDD = "gis";
    private string $hostname = "localhost";
    private string $port = "25432";

    //private string $nomBDD = "iut";
    //private string $hostname = "162.38.222.142";

    public function getLogin(): string
    {
        return "docker";
        //return "rathiers";
    }

    public function getMotDePasse(): string
    {
        return "7adb0UQWiszfqWHZpOYS";
    }

    public function getDSN() : string{
        return "pgsql:host={$this->hostname};port={$this->port};dbname={$this->nomBDD};options='--client_encoding=UTF8'";
        //return "pgsql:host={$this->hostname};dbname={$this->nomBDD};options='--client_encoding=UTF8'";
    }

    public function getOptions() : array {
        return array();
    }
}
