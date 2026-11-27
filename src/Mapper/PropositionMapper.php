<?php

namespace App\Mapper;

use App\DTO\CommercialDTO;
use App\DTO\ContratDTO;
use App\DTO\EmetteurDTO;
use App\DTO\FaceDTO;
use App\DTO\PointDeVenteDTO;
use App\DTO\PropositionDTO;
use App\DTO\TotalDTO;
use DateTimeImmutable;
use InvalidArgumentException;
use JsonException;

/**
 * Convertit le JSON d'une proposition (clés snake_case) en DTO.
 */
class PropositionMapper
{
    /**
     * @throws JsonException
     */
    public function fromJSON(string $json): PropositionDTO
    {
        return $this->fromArray(json_decode($json, true, 512, JSON_THROW_ON_ERROR));
    }

    public function fromArray(array $data): PropositionDTO
    {
        return new PropositionDTO(
            emetteur: $this->mapEmetteur($data['emetteur'] ?? []),
            dateValidite: $this->toDate($data['date_validite'] ?? null, 'date_validite'),
            pointsDeVente: array_map(
                fn (array $pdv) => $this->mapPointDeVente($pdv),
                $data['points_de_vente'] ?? []
            ),
        );
    }

    private function mapEmetteur(array $data): EmetteurDTO
    {
        return new EmetteurDTO(
            type: (string) ($data['type'] ?? ''),
            raisonSociale: (string) ($data['raison_sociale'] ?? ''),
            logo: $data['logo'] ?? null,
            couleur: $data['couleur'] ?? null,
            commercial: $this->mapCommercial($data['commercial'] ?? []),
        );
    }

    private function mapCommercial(array $data): CommercialDTO
    {
        return new CommercialDTO(
            prenom: (string) ($data['prenom'] ?? ''),
            nom: (string) ($data['nom'] ?? ''),
            tel: $data['tel'] ?? null,
            email: $data['email'] ?? null,
        );
    }

    private function mapPointDeVente(array $data): PointDeVenteDTO
    {
        return new PointDeVenteDTO(
            nomMarque: $data['nom_marque'] ?? null,
            nom: (string) ($data['nom'] ?? ''),
            logo: $data['logo'] ?? null,
            logoMarque: $data['logo_marque'] ?? null,
            adresse: (string) ($data['adresse'] ?? ''),
            cp: (string) ($data['cp'] ?? ''),
            commune: (string) ($data['commune'] ?? ''),
            tel: $data['tel'] ?? null,
            fax: $data['fax'] ?? null,
            latitude: $this->toFloat($data['latitude'] ?? null),
            longitude: $this->toFloat($data['longitude'] ?? null),
            contrats: array_map(
                fn (array $contrat) => $this->mapContrat($contrat),
                $data['contrats'] ?? []
            ),
            totalContrats: $this->mapTotal($data['total_contrats'] ?? []),
            propositions: array_map(
                fn (array $proposition) => $this->mapContrat($proposition),
                $data['propositions'] ?? []
            ),
            totalPropositions: $this->mapTotal($data['total_propositions'] ?? []),
        );
    }

    private function mapContrat(array $data): ContratDTO
    {
        return new ContratDTO(
            numero: (int) ($data['numero'] ?? 0),
            codePanneau: (string) ($data['code_panneau'] ?? ''),
            adresse: (string) ($data['adresse'] ?? ''),
            cp: (string) ($data['cp'] ?? ''),
            commune: (string) ($data['commune'] ?? ''),
            dateDebut: $this->toDate($data['date_debut'] ?? null, 'date_debut'),
            dateFin: $this->toDate($data['date_fin'] ?? null, 'date_fin'),
            dureeMois: (int) ($data['duree_mois'] ?? 0),
            tarifEspace: $this->toFloat($data['tarif_espace'] ?? null),
            tarifRemise: $this->toFloat($data['tarif_remise'] ?? null),
            honoraires: $this->toFloat($data['honoraires'] ?? null),
            tlpe: $this->toFloat($data['tlpe'] ?? null),
            fraisTechniques: $this->toFloat($data['frais_techniques'] ?? null),
            total: $this->toFloat($data['total'] ?? null),
            note: $data['note'] ?? null,
            face: $this->mapFace($data['face'] ?? []),
        );
    }

    private function mapFace(array $data): FaceDTO
    {
        return new FaceDTO(
            media: (string) ($data['media'] ?? ''),
            afficheur: (string) ($data['afficheur'] ?? ''),
            format: (string) ($data['format'] ?? ''),
            type: (string) ($data['type'] ?? ''),
            eclaire: (bool) ($data['eclaire'] ?? false),
            venantDe: $data['venant_de'] ?? null,
            allantVers: $data['allant_vers'] ?? null,
            visibleA: $data['visible_a'] ?? null,
            orientation: isset($data['orientation']) ? (int) $data['orientation'] : null,
            latitude: $this->toFloat($data['latitude'] ?? null),
            longitude: $this->toFloat($data['longitude'] ?? null),
            tarif: $this->toFloat($data['tarif'] ?? null),
            photo: $data['photo'] ?? null,
        );
    }

    private function mapTotal(array $data): TotalDTO
    {
        return new TotalDTO(
            tarifEspace: $this->toFloat($data['tarif_espace'] ?? null),
            tarifRemise: $this->toFloat($data['tarif_remise'] ?? null),
            honoraires: $this->toFloat($data['honoraires'] ?? null),
            tlpe: $this->toFloat($data['tlpe'] ?? null),
            fraisTechniques: $this->toFloat($data['frais_techniques'] ?? null),
            total: $this->toFloat($data['total'] ?? null),
        );
    }

    private function toFloat(mixed $value): ?float
    {
        return $value === null ? null : (float) $value;
    }

    private function toDate(?string $value, string $champ): DateTimeImmutable
    {
        $date = $value !== null ? DateTimeImmutable::createFromFormat('!Y-m-d', $value) : false;

        if ($date === false) {
            throw new InvalidArgumentException(sprintf('Date invalide pour "%s" : %s', $champ, $value ?? 'null'));
        }

        return $date;
    }
}
