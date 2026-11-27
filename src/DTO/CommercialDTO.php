<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CommercialDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $prenom,
        #[Assert\NotBlank]
        public string $nom,
        public ?string $tel,
        #[Assert\Email]
        public ?string $email,
    )
    {
    }
}
