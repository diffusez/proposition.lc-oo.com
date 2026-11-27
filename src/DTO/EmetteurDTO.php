<?php

namespace App\DTO;

readonly class EmetteurDTO
{
    public function __construct(
        public string $type,
        public string $raisonSociale,
        public ?string $logo,
        public ?string $couleur,
        public CommercialDTO $commercial,
    )
    {
    }
}
