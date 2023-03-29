<?php

namespace App\PlusCourtChemin\Modele\Repository;

use App\PlusCourtChemin\Configuration\Configuration;
use App\PlusCourtChemin\Configuration\ConfigurationBDDPostgreSQL;
use PDO;

class ConnexionBaseDeDonnees
{
    private static ?ConnexionBaseDeDonnees $instance = null;

    private PDO $pdo;

    public static function getPdo(): PDO
    {
        return ConnexionBaseDeDonnees::getInstance()->pdo;
    }

    private function __construct()
    {
        $host = '172.16.21.29';
        $dbname = 'gis';
        $username = 'docker';
        $password = 'AgzGlu96xxUL2ey7DzTi';
        $port = '25432';

        $configuration = new Configuration(new ConfigurationBDDPostgreSQL());
        $configurationBDD = $configuration->getConfigurationBDD();

        // Connexion à la base de données
        $this->pdo = new PDO(
            "pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password"
        );


        // On active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private static function getInstance(): ConnexionBaseDeDonnees
    {
        if (is_null(ConnexionBaseDeDonnees::$instance))
            ConnexionBaseDeDonnees::$instance = new ConnexionBaseDeDonnees();
        return ConnexionBaseDeDonnees::$instance;
    }
}