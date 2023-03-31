<?php

namespace App\PlusCourtChemin\Controleur;

use App\PlusCourtChemin\Lib\PlusCourtChemin;
use App\PlusCourtChemin\Modele\DataObject\NoeudCommune;
use App\PlusCourtChemin\Modele\Repository\NoeudCommuneRepository;
use App\PlusCourtChemin\Modele\Repository\NoeudRoutierRepository;
use App\PlusCourtChemin\Modele\Repository\TronconRouteNoeudsRepository;

class ControleurTronconRouteNoeuds extends ControleurGenerique
{

    public static function donneesRoute ()
    {

        if (!empty($_GET)) {
            $nomCommuneDepart = $_GET["nomCommuneDepart"];
            $nomCommuneArrivee = $_GET["nomCommuneArrivee"];


            $noeudCommuneRepository = new NoeudCommuneRepository();
            /** @var NoeudCommune $noeudCommuneDepart */
            //select * de la table noeud de commune ou le nom_comm == nomCommuneDepart
            //on recupere le GID dans noeudCommuneDepart
            $noeudCommuneDepart = $noeudCommuneRepository->recupererPar(["nom_comm" => $nomCommuneDepart])[0];
            /** @var NoeudCommune $noeudCommuneArrivee */
            //select * de la table noeud de commune ou le nom_comm == nomCommuneArrivee
            //on recupere le GID dans noeudCommuneArrivee
            $noeudCommuneArrivee = $noeudCommuneRepository->recupererPar(["nom_comm" => $nomCommuneArrivee])[0];

            $noeudRoutierRepository = new NoeudRoutierRepository();
            //recuperer le gid du noeud commune de depart dans la table noeud routier grace à id_nd_rte
            $noeudRoutierDepartGid = $noeudRoutierRepository->recupererPar([
                "id_rte500" => $noeudCommuneDepart->getId_nd_rte()
            ])[0]->getGid();
            //recuperer le gid du noeud commune d'arrivee dans la table noeud routier grace à id_nd_rte
            $noeudRoutierArriveeGid = $noeudRoutierRepository->recupererPar([
                "id_rte500" => $noeudCommuneArrivee->getId_nd_rte()
            ])[0]->getGid();

            $pcc = new PlusCourtChemin($noeudRoutierDepartGid, $noeudRoutierArriveeGid);
            $tab = $pcc->calculer();
            echo json_encode($tab);

        }

    }


}