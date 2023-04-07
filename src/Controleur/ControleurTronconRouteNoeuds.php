<?php

namespace App\PlusCourtChemin\Controleur;

use App\PlusCourtChemin\Lib\PlusCourtChemin;
use App\PlusCourtChemin\Modele\DataObject\NoeudCommune;
use App\PlusCourtChemin\Modele\Repository\NoeudCommuneRepository;
use App\PlusCourtChemin\Modele\Repository\NoeudRoutierRepository;
use App\PlusCourtChemin\Modele\Repository\TronconRouteNoeudsRepository;

class ControleurTronconRouteNoeuds extends ControleurGenerique
{

    public static function donneesRoute ($nomCommuneDepart,$nomCommuneArrivee)
    {

            $pcc = new PlusCourtChemin($nomCommuneDepart, $nomCommuneArrivee);
            $tab = $pcc->calculer();
            echo json_encode($tab);



    }


}