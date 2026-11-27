<?php

namespace App\Entity;

use App\Repository\PropositionPartageeRepository;
use DateTime;
use DateTimeZone;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\Entity(repositoryClass: PropositionPartageeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class PropositionPartagee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?DateTime $created_at = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $proposition = null;

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        try {
            $this->created_at = new DateTime('now', new DateTimeZone('Europe/Paris'));
        } catch (Exception $e) {

        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTime $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getProposition(): ?string
    {
        return $this->proposition;
    }

    public function setProposition(?string $proposition): static
    {
        $this->proposition = $proposition;

        return $this;
    }
}
