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
 *
 * Un champ obligatoire absent prend une valeur vide ('' ou 0) que le Validator signale ;
 * un champ présent, mais du mauvais type lève une InvalidArgumentException.
 */
class PropositionMapper
{
    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function fromJSON(string $json): PropositionDTO
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($data)) {
            throw new InvalidArgumentException('La payload doit être un objet JSON');
        }

        return $this->fromArray($data);
    }

    public function fromArray(array $data): PropositionDTO
    {
        return new PropositionDTO(
            emetteur: $this->mapEmetteur($this->toObject($data, 'emetteur')),
            dateValidite: $this->toDate($data, 'date_validite'),
            pointsDeVente: array_map(
                fn (array $pdv) => $this->mapPointDeVente($pdv),
                $this->toList($data, 'points_de_vente')
            ),
        );
    }

    private function mapEmetteur(array $data): EmetteurDTO
    {
        return new EmetteurDTO(
            type: $this->toString($data, 'type'),
            raisonSociale: $this->toString($data, 'raison_sociale'),
            logo: $this->toNullableString($data, 'logo'),
            couleur: $this->toNullableString($data, 'couleur'),
            commercial: $this->mapCommercial($this->toObject($data, 'commercial')),
        );
    }

    private function mapCommercial(array $data): CommercialDTO
    {
        return new CommercialDTO(
            prenom: $this->toString($data, 'prenom'),
            nom: $this->toString($data, 'nom'),
            tel: $this->toNullableString($data, 'tel'),
            email: $this->toNullableString($data, 'email'),
        );
    }

    private function mapPointDeVente(array $data): PointDeVenteDTO
    {
        return new PointDeVenteDTO(
            nomMarque: $this->toNullableString($data, 'nom_marque'),
            nom: $this->toString($data, 'nom'),
            logo: $this->toNullableString($data, 'logo'),
            logoMarque: $this->toNullableString($data, 'logo_marque'),
            adresse: $this->toString($data, 'adresse'),
            cp: $this->toString($data, 'cp'),
            commune: $this->toString($data, 'commune'),
            tel: $this->toNullableString($data, 'tel'),
            fax: $this->toNullableString($data, 'fax'),
            latitude: $this->toNullableFloat($data, 'latitude'),
            longitude: $this->toNullableFloat($data, 'longitude'),
            contrats: array_map(
                fn (array $contrat) => $this->mapContrat($contrat),
                $this->toList($data, 'contrats')
            ),
            totalContrats: $this->mapTotal($this->toObject($data, 'total_contrats')),
            propositions: array_map(
                fn (array $proposition) => $this->mapContrat($proposition),
                $this->toList($data, 'propositions')
            ),
            totalPropositions: $this->mapTotal($this->toObject($data, 'total_propositions')),
        );
    }

    private function mapContrat(array $data): ContratDTO
    {
        return new ContratDTO(
            numero: $this->toInt($data, 'numero'),
            codePanneau: $this->toString($data, 'code_panneau'),
            adresse: $this->toString($data, 'adresse'),
            cp: $this->toString($data, 'cp'),
            commune: $this->toString($data, 'commune'),
            dateDebut: $this->toDate($data, 'date_debut'),
            dateFin: $this->toDate($data, 'date_fin'),
            dureeMois: $this->toInt($data, 'duree_mois'),
            tarifEspace: $this->toNullableFloat($data, 'tarif_espace'),
            tarifRemise: $this->toNullableFloat($data, 'tarif_remise'),
            honoraires: $this->toNullableFloat($data, 'honoraires'),
            tlpe: $this->toNullableFloat($data, 'tlpe'),
            fraisTechniques: $this->toNullableFloat($data, 'frais_techniques'),
            total: $this->toNullableFloat($data, 'total'),
            note: $this->toNullableString($data, 'note'),
            face: $this->mapFace($this->toObject($data, 'face')),
        );
    }

    private function mapFace(array $data): FaceDTO
    {
        return new FaceDTO(
            media: $this->toString($data, 'media'),
            afficheur: $this->toString($data, 'afficheur'),
            format: $this->toString($data, 'format'),
            type: $this->toString($data, 'type'),
            eclaire: $this->toBool($data, 'eclaire'),
            venantDe: $this->toNullableString($data, 'venant_de'),
            allantVers: $this->toNullableString($data, 'allant_vers'),
            visibleA: $this->toNullableString($data, 'visible_a'),
            orientation: $this->toNullableInt($data, 'orientation'),
            latitude: $this->toNullableFloat($data, 'latitude'),
            longitude: $this->toNullableFloat($data, 'longitude'),
            tarif: $this->toNullableFloat($data, 'tarif'),
            photo: $this->toNullableString($data, 'photo'),
        );
    }

    private function mapTotal(array $data): TotalDTO
    {
        return new TotalDTO(
            tarifEspace: $this->toNullableFloat($data, 'tarif_espace'),
            tarifRemise: $this->toNullableFloat($data, 'tarif_remise'),
            honoraires: $this->toNullableFloat($data, 'honoraires'),
            tlpe: $this->toNullableFloat($data, 'tlpe'),
            fraisTechniques: $this->toNullableFloat($data, 'frais_techniques'),
            total: $this->toNullableFloat($data, 'total'),
        );
    }

    private function toString(array $data, string $champ): string
    {
        return $this->toNullableString($data, $champ) ?? '';
    }

    private function toNullableString(array $data, string $champ): ?string
    {
        $value = $data[$champ] ?? null;

        if ($value !== null && !is_string($value)) {
            throw new InvalidArgumentException(sprintf('"%s" doit être une chaîne, %s reçu', $champ, get_debug_type($value)));
        }

        return $value;
    }

    private function toInt(array $data, string $champ): int
    {
        return $this->toNullableInt($data, $champ) ?? 0;
    }

    private function toNullableInt(array $data, string $champ): ?int
    {
        $value = $data[$champ] ?? null;

        if ($value !== null && !is_int($value)) {
            throw new InvalidArgumentException(sprintf('"%s" doit être un entier, %s reçu', $champ, get_debug_type($value)));
        }

        return $value;
    }

    private function toNullableFloat(array $data, string $champ): ?float
    {
        $value = $data[$champ] ?? null;

        // json_decode renvoie un int pour 1200 et un float pour 1200.5 : les deux sont acceptés
        if ($value !== null && !is_int($value) && !is_float($value)) {
            throw new InvalidArgumentException(sprintf('"%s" doit être un nombre, %s reçu', $champ, get_debug_type($value)));
        }

        return $value === null ? null : (float) $value;
    }

    private function toBool(array $data, string $champ): bool
    {
        $value = $data[$champ] ?? null;

        if (!is_bool($value)) {
            throw new InvalidArgumentException(sprintf('"%s" doit être un booléen, %s reçu', $champ, get_debug_type($value)));
        }

        return $value;
    }

    private function toObject(array $data, string $champ): array
    {
        $value = $data[$champ] ?? [];

        if (!is_array($value) || (array_is_list($value) && $value !== [])) {
            throw new InvalidArgumentException(sprintf('"%s" doit être un objet, %s reçu', $champ, get_debug_type($value)));
        }

        return $value;
    }

    private function toList(array $data, string $champ): array
    {
        $value = $data[$champ] ?? [];

        if (!is_array($value) || !array_is_list($value)) {
            throw new InvalidArgumentException(sprintf('"%s" doit être une liste, %s reçu', $champ, get_debug_type($value)));
        }

        foreach ($value as $index => $element) {
            if (!is_array($element) || (array_is_list($element) && $element !== [])) {
                throw new InvalidArgumentException(sprintf('"%s" doit être un objet, %s reçu', sprintf('%s[%d]', $champ, $index), get_debug_type($element)));
            }
        }

        return $value;
    }

    private function toDate(array $data, string $champ): DateTimeImmutable
    {
        $value = $data[$champ] ?? null;
        $date = is_string($value) ? DateTimeImmutable::createFromFormat('!Y-m-d', $value) : false;

        // createFromFormat accepte des dates débordantes (2026-02-31) : on compare au format d'origine
        if ($date === false || $date->format('Y-m-d') !== $value) {
            throw new InvalidArgumentException(sprintf('Date invalide pour "%s" (format attendu : AAAA-MM-JJ) : %s', $champ, json_encode($value)));
        }

        return $date;
    }
}
