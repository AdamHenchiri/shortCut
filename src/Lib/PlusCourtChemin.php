<?php

namespace App\PlusCourtChemin\Lib;
use App\PlusCourtChemin\Controleur\ControleurTronconRouteNoeuds;
use App\PlusCourtChemin\Modele\Repository\NoeudCommuneRepository;
use App\PlusCourtChemin\Modele\Repository\TronconRouteNoeudsRepository;

class PlusCourtChemin
{
    //tab [ GID => numero ]
    private float $distances;
    //tab [ GID => bool ]
    private array $noeudsALaFrontiere;
    private array $tabRoute;
    private int $noeudRoutierDepartGid;
    private int $noeudRoutierArriveeGid;
    /**
     * @param int $noeudRoutierDepartGid code GID du noeud de route de depart
     * @param int $noeudRoutierArriveeGid code GID du noeud de route d'arrivee
     */
    public function __construct(
        private string $communeDepart,
        private string $communeArrivee
    ) {
        $noeudCommuneRepository = new NoeudCommuneRepository();
        $this->noeudRoutierDepartGid= (($noeudCommuneRepository->recupererGidDuNom($this->communeDepart))[0])->gid;
        $this->noeudRoutierArriveeGid= (($noeudCommuneRepository->recupererGidDuNom($this->communeArrivee))[0])->gid;
    }

    public function calculer(bool $affichageDebug = false): array
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
            $tabDijkstra = $tronconRouteNoeudsRepository->getDonneesChemin($this->noeudRoutierDepartGid,$this->noeudRoutierArriveeGid);
            $lastNoeud=$tabDijkstra[count($tabDijkstra)-1];
            $this->distances = $lastNoeud->agg_cost;
            $this->tabRoute=$tabDijkstra;
        }
        return $this->tabRoute;
    }

}
