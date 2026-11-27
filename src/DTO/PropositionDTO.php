<?php

namespace App\DTO;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

readonly class PropositionDTO
{
    /**
     * @param PointDeVenteDTO[] $pointsDeVente
     */
    public function __construct(
        #[Assert\Valid]
        public EmetteurDTO $emetteur,
        public DateTimeImmutable $dateValidite,
        #[Assert\Count(min: 1, minMessage: 'La proposition doit contenir au moins un point de vente.')]
        #[Assert\Valid]
        public array $pointsDeVente = [],
    )
    {
    }
}
