<?php

namespace App\DTO;

/**
 * Totaux d'une liste de contrats ou de propositions.
 */
readonly class TotalDTO
{
    public function __construct(
        public ?float $tarifEspace,
        public ?float $tarifRemise,
        public ?float $honoraires,
        public ?float $tlpe,
        public ?float $fraisTechniques,
        public ?float $total,
    )
    {
    }
}
