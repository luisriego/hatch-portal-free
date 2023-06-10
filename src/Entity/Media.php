<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use App\Trait\IdentifierTrait;
use App\Trait\TimestampableTrait;
use App\ValueObjects\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    use IdentifierTrait, TimestampableTrait;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'media')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ChallengeSet $challenge = null;

    #[ORM\Column(nullable: true)]
    private ?int $heigth = null;

    #[ORM\Column(nullable: true)]
    private ?int $width = null;

    public function __construct()
    {
        $this->id = Uuid::random()->value();
        $this->createdOn = new \DateTimeImmutable();
        $this->markAsUpdated();
        $this->media = new ArrayCollection();
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getChallenge(): ?ChallengeSet
    {
        return $this->challenge;
    }

    public function setChallenge(?ChallengeSet $challenge): self
    {
        $this->challenge = $challenge;

        return $this;
    }

    public function getHeigth(): ?int
    {
        return $this->heigth;
    }

    public function setHeigth(?int $heigth): self
    {
        $this->heigth = $heigth;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): self
    {
        $this->width = $width;

        return $this;
    }
}
