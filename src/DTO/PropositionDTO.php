<?php

namespace App\DTO;

use DateTimeImmutable;

readonly class PropositionDTO
{
    /**
     * @param EmetteurDTO $emetteur
     * @param DateTimeImmutable $dateValidite
     * @param PointDeVenteDTO[] $pointsDeVente
     */
    public function __construct(
        public EmetteurDTO $emetteur,
        public DateTimeImmutable $dateValidite,
        public array $pointsDeVente = [],
    )
    {
    }
}
