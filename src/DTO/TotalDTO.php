<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Totaux d'une liste de contrats ou de propositions.
 */
readonly class TotalDTO
{
    public function __construct(
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
    )
    {
    }
}
