<?php

namespace App\DTO;

use DateTimeImmutable;

/**
 * Ligne d'un point de vente : utilisée pour les contrats comme pour les propositions.
 */
readonly class ContratDTO
{
    public function __construct(
        public int $numero,
        public string $codePanneau,
        public string $adresse,
        public string $cp,
        public string $commune,
        public DateTimeImmutable $dateDebut,
        public DateTimeImmutable $dateFin,
        public int $dureeMois,
        public ?float $tarifEspace,
        public ?float $tarifRemise,
        public ?float $honoraires,
        public ?float $tlpe,
        public ?float $fraisTechniques,
        public ?float $total,
        public ?string $note,
        public FaceDTO $face,
    )
    {
    }
}
