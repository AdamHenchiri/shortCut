<?php

namespace App\PlusCourtChemin\Modele\Repository;

use App\PlusCourtChemin\Modele\DataObject\AbstractDataObject;
use App\PlusCourtChemin\Modele\DataObject\NoeudRoutier;
use PDO;

class TronconRouteNoeudsRepository extends AbstractRepository
{
    //à revoir !!!
    protected function construireDepuisTableau(array $noeudRoutierTableau): AbstractDataObject
    {
        return new NoeudRoutier(
            $noeudRoutierTableau["id"],
            $noeudRoutierTableau["id_rte500"],
            null
        );
    }

    protected function getNomTable(): string
    {
        return 'noeud_routier_noeuds';
    }

    protected function getNomClePrimaire(): string
    {
        return 'id';
    }

    protected function getNomsColonnes(): array
    {
        return ["id","id_rte500","vocation","nb_chausse","nb_voies","etat","acces","res_vert","sens","num_route","res_europe","cost","class_adm","source","target","geom"];
    }

    // On bloque l'ajout, la màj et la suppression pour ne pas modifier la table
    // Normalement, j'ai restreint l'accès à SELECT au niveau de la BD
    public function supprimer(string $valeurClePrimaire): bool
    {
        return false;
    }

    public function mettreAJour(AbstractDataObject $object): void
    {
        return;
    }

    public function ajouter(AbstractDataObject $object): bool
    {
        return false;
    }

    /**
     *
     **/
    public function getPlusCourtChemin(int $comDepartGid, int $comArriveeGid): array
    {
        $requeteSQL = <<<SQL
        SELECT agg_cost from pgr_astar(
        'SELECT id, source, target, cost, x1, y1, x2, y2 FROM troncon_route_noeuds',
        :gidDepartTag::bigint,
        :gidArriveeTag::bigint,
        directed := false
        );
        SQL;
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($requeteSQL);
        $pdoStatement->execute(array(
            "gidDepartTag" => $comDepartGid,
            "gidArriveeTag" => $comArriveeGid
        ));
        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDonneesChemin(int $comDepartGid, int $comArriveeGid): array
    {
        $requeteSQL = <<<SQL
        select ST_AsGeoJSON(the_geom) from troncon_route_noeuds
        WHERE id in (
        SELECT edge from pgr_dijkstra(
        'SELECT id, source, target, cost FROM troncon_route_noeuds',
        :gidDepartTag::bigint,
        :gidArriveeTag::bigint,
        directed := false
        ));
        SQL;
        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($requeteSQL);
        $pdoStatement->execute(array(
            "gidDepartTag" => $comDepartGid,
            "gidArriveeTag" => $comArriveeGid
        ));
        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }


}
