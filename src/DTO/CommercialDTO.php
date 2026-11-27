<?php

namespace App\DTO;

readonly class CommercialDTO
{
    public function __construct(
        public string $prenom,
        public string $nom,
        public ?string $tel,
        public ?string $email,
    )
    {
    }
}
