<?php

namespace App\DTO;

readonly class PointDeVenteDTO
{
    /**
     * @param string|null $nomMarque
     * @param string $nom
     * @param string|null $logo
     * @param string|null $logoMarque
     * @param string $adresse
     * @param string $cp
     * @param string $commune
     * @param string|null $tel
     * @param string|null $fax
     * @param float|null $latitude
     * @param float|null $longitude
     * @param ContratDTO[] $contrats
     * @param TotalDTO $totalContrats
     * @param ContratDTO[] $propositions
     * @param TotalDTO $totalPropositions
     */
    public function __construct(
        public ?string $nomMarque,
        public string $nom,
        public ?string $logo,
        public ?string $logoMarque,
        public string $adresse,
        public string $cp,
        public string $commune,
        public ?string $tel,
        public ?string $fax,
        public ?float $latitude,
        public ?float $longitude,
        public array $contrats,
        public TotalDTO $totalContrats,
        public array $propositions,
        public TotalDTO $totalPropositions,
    )
    {
    }
}
