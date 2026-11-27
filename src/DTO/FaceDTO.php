<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class FaceDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $media,
        #[Assert\NotBlank]
        public string $afficheur,
        #[Assert\NotBlank]
        public string $format,
        #[Assert\NotBlank]
        public string $type,
        public bool $eclaire,
        public ?string $venantDe,
        public ?string $allantVers,
        public ?string $visibleA,
        #[Assert\PositiveOrZero]
        public ?int $orientation,
        #[Assert\Range(min: -90, max: 90)]
        public ?float $latitude,
        #[Assert\Range(min: -180, max: 180)]
        public ?float $longitude,
        #[Assert\PositiveOrZero]
        public ?float $tarif,
        #[Assert\Url(requireTld: true)]
        public ?string $photo,
    )
    {
    }
}
