<?php

namespace App\PlusCourtChemin\Controleur;

use App\PlusCourtChemin\Lib\Conteneur;
use App\PlusCourtChemin\Lib\MessageFlash;

class ControleurGenerique {

    protected static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres);
        $messagesFlash = MessageFlash::lireTousMessages();
        require __DIR__ . "/../vue/$cheminVue";
    }

    // https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php
    protected static function rediriger(string $nom = "", ?array $query = []) : void
    {
        /*$queryString = [];
        if ($action != "") {
            $queryString[] = "action=" . rawurlencode($action);
        }
        if ($controleur != "") {
            $queryString[] = "controleur=" . rawurlencode($controleur);
        }
        foreach ($query as $name => $value) {
            $name = rawurldecode($name);
            $value = rawurldecode($value);
            $queryString[] = "$name=$value";
        }*/
        $generateur = Conteneur::recupererService("generateur");

        if (!empty($query)) {
            $queryString = $generateur->generate($nom, [$query[0] => $query[1]]);
        }else{
            $queryString = $generateur->generate($nom);
        }

        $url = "Location: ./controleurFrontal.php?" . join("&", $queryString);
        header($url);
        exit();
    }

    public static function afficherErreur($errorMessage = "", $controleur = ""): void
    {
        $errorMessageView = "Problème";
        if ($controleur !== "")
            $errorMessageView .= " avec le contrôleur $controleur";
        if ($errorMessage !== "")
            $errorMessageView .= " : $errorMessage";

        ControleurGenerique::afficherVue('vueGenerale.php', [
            "pagetitle" => "Problème",
            "cheminVueBody" => "erreur.php",
            "errorMessage" => $errorMessageView
        ]);
    }

}