<?php

namespace App\PlusCourtChemin\Lib;
use App\PlusCourtChemin\Modele\Repository\TronconRouteNoeudsRepository;

class PlusCourtChemin
{
    //tab [ GID => numero ]
    private float $distances;
    //tab [ GID => bool ]
    private array $noeudsALaFrontiere;


    /**
     * @param int $noeudRoutierDepartGid code GID du noeud de route de depart
     * @param int $noeudRoutierArriveeGid code GID du noeud de route d'arrivee
     */
    public function __construct(
        private int $noeudRoutierDepartGid,
        private int $noeudRoutierArriveeGid
    ) {
    }

    public function calculer(bool $affichageDebug = false): float
    {
        $tronconRouteNoeudsRepository = new TronconRouteNoeudsRepository();

        // Distance en km, table indexé par NoeudRoutier::gid
        //$this->distances = [$this->noeudRoutierDepartGid => 0];
        //$i=0;

        // Fini
        if ($this->noeudRoutierArriveeGid === $this->noeudRoutierDepartGid) {
           $this->distances=0;
        }
        else{
            $tabDijkstra = $tronconRouteNoeudsRepository->getPlusCourtChemin($this->noeudRoutierDepartGid,$this->noeudRoutierArriveeGid);
                $lastNoeud=$tabDijkstra[count($tabDijkstra)-1];
                $this->distances = $lastNoeud["agg_cost"];
        }
        return $this->distances;

        /*
        $this->noeudsALaFrontiere[$this->noeudRoutierDepartGid] = true;

        while (count($this->noeudsALaFrontiere) !== 0) {
            $noeudRoutierGidCourant = $this->noeudALaFrontiereDeDistanceMinimale();//44 485

            // Fini
            if ($noeudRoutierGidCourant === $this->noeudRoutierArriveeGid) {
                return $this->distances[$noeudRoutierGidCourant];
            }

            // Enleve le noeud routier courant de la frontiere
            unset($this->noeudsALaFrontiere[$noeudRoutierGidCourant]);

            /** @var NoeudRoutier $noeudRoutierCourant
            $noeudRoutierCourant = $noeudRoutierRepository->recupererParClePrimaire($noeudRoutierGidCourant);
            $voisins = $noeudRoutierCourant->getVoisins();

            foreach ($voisins as $voisin) {
                $noeudVoisinGid = $voisin["noeud_routier_gid"];
                $distanceTroncon = $voisin["longueur"];
                $distanceProposee = $this->distances[$noeudRoutierGidCourant] + $distanceTroncon;

                if (!isset($this->distances[$noeudVoisinGid]) || $distanceProposee < $this->distances[$noeudVoisinGid]) {
                    $this->distances[$noeudVoisinGid] = $distanceProposee;
                    $this->noeudsALaFrontiere[$noeudVoisinGid] = true;
                }
            }
        }
        */
    }

    private function noeudALaFrontiereDeDistanceMinimale()
    {
        $noeudRoutierDistanceMinimaleGid = -1;
        $distanceMinimale = PHP_INT_MAX;
        foreach ($this->noeudsALaFrontiere as $noeudRoutierGid => $valeur) {
            if ($this->distances[$noeudRoutierGid] < $distanceMinimale) {
                $noeudRoutierDistanceMinimaleGid = $noeudRoutierGid;
                $distanceMinimale = $this->distances[$noeudRoutierGid];
            }
        }
        return $noeudRoutierDistanceMinimaleGid;
    }
}
