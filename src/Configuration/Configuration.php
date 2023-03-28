<?php

namespace App\PlusCourtChemin\Configuration;

use Exception;

class Configuration
{

    // la variable debug est un boolean
    static private bool $debug = true;

    public ConfigurationBDDInterface $configurationBDD;

    public function __construct(ConfigurationBDDInterface $configurationBDD)
    {
        $this->configurationBDD= $configurationBDD;
    }

    public function getConfigurationBDD(): ConfigurationBDDInterface
    {
        return $this->configurationBDD;
    }

    static public function getDebug(): bool
    {
        return Configuration::$debug;
    }

    public static function getDureeExpirationSession() : string
    {
        // Durée d'expiration des sessions en secondes
        return 120;
    }

    public static function getAbsoluteURL() : string
    {
        return "http://localhost:88/sae/web/controleurFrontal.php?";
    }

}