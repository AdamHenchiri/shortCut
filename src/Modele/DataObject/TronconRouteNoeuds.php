<?php

namespace App\PlusCourtChemin\Modele\DataObject;


class TronconRouteNoeuds extends AbstractDataObject
{

    public function __construct(
        private int $id,
        private string $id_rte500,
        private string $sens,
        private string $numeroRoute,
        private float $cost,
        private int $source,
        private int $target,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getId_rte500(): string
    {
        return $this->id_rte500;
    }

    public function getSens(): string
    {
        return $this->sens;
    }

    public function getNumeroRoute(): string
    {
        return $this->numeroRoute;
    }

    public function getCost(): float
    {
        return $this->cost;
    }

    /**
     * @return int
     */
    public function getSource(): int
    {
        return $this->source;
    }

    /**
     * @return int
     */
    public function getTarget(): int
    {
        return $this->target;
    }


    public function exporterEnFormatRequetePreparee(): array
    {
        // Inutile car pas d'ajout ni de màj
        return [];
    }
}
