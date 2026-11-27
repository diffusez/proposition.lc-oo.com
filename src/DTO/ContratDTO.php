<?php

namespace App\DTO;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ligne d'un point de vente : utilisée pour les contrats comme pour les propositions.
 */
readonly class ContratDTO
{
    public function __construct(
        #[Assert\Positive]
        public int $numero,
        #[Assert\NotBlank]
        public string $codePanneau,
        #[Assert\NotBlank]
        public string $adresse,
        #[Assert\NotBlank]
        #[Assert\Regex(pattern: '/^\d{5}$/', message: 'Le code postal doit contenir 5 chiffres.')]
        public string $cp,
        #[Assert\NotBlank]
        public string $commune,
        public DateTimeImmutable $dateDebut,
        #[Assert\GreaterThanOrEqual(propertyPath: 'dateDebut', message: 'La date de fin doit être postérieure à la date de début.')]
        public DateTimeImmutable $dateFin,
        #[Assert\Positive]
        public int $dureeMois,
        #[Assert\PositiveOrZero]
        public ?float $tarifEspace,
        #[Assert\PositiveOrZero]
        public ?float $tarifRemise,
        #[Assert\PositiveOrZero]
        public ?float $honoraires,
        #[Assert\PositiveOrZero]
        public ?float $tlpe,
        #[Assert\PositiveOrZero]
        public ?float $fraisTechniques,
        #[Assert\PositiveOrZero]
        public ?float $total,
        public ?string $note,
        #[Assert\Valid]
        public FaceDTO $face,
    )
    {
    }
}
