<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

readonly class PointDeVenteDTO
{
    /**
     * @param ContratDTO[] $contrats
     * @param ContratDTO[] $propositions
     */
    public function __construct(
        public ?string $nomMarque,
        #[Assert\NotBlank]
        public string $nom,
        #[Assert\Url(requireTld: true)]
        public ?string $logo,
        #[Assert\Url(requireTld: true)]
        public ?string $logoMarque,
        #[Assert\NotBlank]
        public string $adresse,
        #[Assert\NotBlank]
        #[Assert\Regex(pattern: '/^\d{5}$/', message: 'Le code postal doit contenir 5 chiffres.')]
        public string $cp,
        #[Assert\NotBlank]
        public string $commune,
        public ?string $tel,
        public ?string $fax,
        #[Assert\Range(min: -90, max: 90)]
        public ?float $latitude,
        #[Assert\Range(min: -180, max: 180)]
        public ?float $longitude,
        #[Assert\Valid]
        public array $contrats,
        #[Assert\Valid]
        public TotalDTO $totalContrats,
        #[Assert\Valid]
        public array $propositions,
        #[Assert\Valid]
        public TotalDTO $totalPropositions,
    )
    {
    }
}
