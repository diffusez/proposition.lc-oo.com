<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class EmetteurDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $type,
        #[Assert\NotBlank]
        public string $raisonSociale,
        #[Assert\Url(requireTld: true)]
        public ?string $logo,
        #[Assert\CssColor(formats: Assert\CssColor::HEX_LONG)]
        public ?string $couleur,
        #[Assert\Valid]
        public CommercialDTO $commercial,
    )
    {
    }
}
