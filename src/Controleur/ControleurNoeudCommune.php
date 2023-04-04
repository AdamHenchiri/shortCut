<?php

namespace App\PlusCourtChemin\Controleur;

use App\PlusCourtChemin\Lib\MessageFlash;
use App\PlusCourtChemin\Lib\PlusCourtChemin;
use App\PlusCourtChemin\Modele\DataObject\NoeudCommune;
use App\PlusCourtChemin\Modele\Repository\NoeudCommuneRepository;
use App\PlusCourtChemin\Modele\Repository\NoeudRoutierRepository;

class ControleurNoeudCommune extends ControleurGenerique
{

    public static function afficherErreur($errorMessage = "", $controleur = ""): void
    {
        parent::afficherErreur($errorMessage, "noeudCommune");
    }

    public static function afficherListe(): void
    {
        $noeudsCommunes = (new NoeudCommuneRepository())->recuperer();     //appel au modèle pour gerer la BD
        ControleurNoeudCommune::afficherVue('vueGenerale.php', [
            "noeudsCommunes" => $noeudsCommunes,
            "pagetitle" => "Liste des Noeuds Routiers",
            "cheminVueBody" => "noeudCommune/liste.php"
        ]);
    }

    public static function afficherDetail(): void
    {
        if (!isset($_REQUEST['gid'])) {
            MessageFlash::ajouter("danger", "Immatriculation manquante.");
            ControleurNoeudCommune::rediriger("noeudCommune", "afficherListe");
        }

        $gid = $_REQUEST['gid'];
        $noeudCommune = (new NoeudCommuneRepository())->recupererParClePrimaire($gid);

        if ($noeudCommune === null) {
            MessageFlash::ajouter("warning", "gid inconnue.");
            ControleurNoeudCommune::rediriger("noeudCommune", "afficherListe");
        }

        ControleurNoeudCommune::afficherVue('vueGenerale.php', [
            "noeudCommune" => $noeudCommune,
            "pagetitle" => "Détail de la noeudCommune",
            "cheminVueBody" => "noeudCommune/detail.php"
        ]);
    }

    public static function plusCourtChemin(): void
    {
       $parametres = [
            "pagetitle" => "Plus court chemin",
            "cheminVueBody" => "noeudCommune/plusCourtChemin.php",
        ];
        ControleurNoeudCommune::afficherVue('vueGenerale.php', $parametres);
    }


    public static function autocompletion(){
        $nomCommuneDepart = $_GET["nomCommuneDepart"];
        $noeudCommuneRepository = new NoeudCommuneRepository();
        $tab = $noeudCommuneRepository->selectByName("nom_comm",$nomCommuneDepart);

        echo json_encode($tab);

    }

    public static function donneesCarte(){
        $nomCommuneDepart = $_GET["nomCommuneDepart"];
        $noeudCommuneRepository = new NoeudCommuneRepository();
        $tab = $noeudCommuneRepository->selectGeom("nom_comm",$nomCommuneDepart);

        echo json_encode($tab);
    }

    public static function villeExist(){
        $nomCommuneDepart = $_GET["ville"];
        $noeudCommuneRepository = new NoeudCommuneRepository();
        $tab = $noeudCommuneRepository->verifierVille($nomCommuneDepart);

        echo json_encode($tab);
    }



}
