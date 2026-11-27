<?php

namespace App\DTO;

readonly class FaceDTO
{
    public function __construct(
        public string $media,
        public string $afficheur,
        public string $format,
        public string $type,
        public bool $eclaire,
        public ?string $venantDe,
        public ?string $allantVers,
        public ?string $visibleA,
        public ?int $orientation,
        public ?float $latitude,
        public ?float $longitude,
        public ?float $tarif,
        public ?string $photo,
    )
    {
    }
}
