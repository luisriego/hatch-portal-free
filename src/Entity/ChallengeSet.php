<?php

namespace App\Entity;

use App\Repository\ChallengeSetRepository;
use App\Trait\IdentifierTrait;
use App\Trait\IsActiveTrait;
use App\Trait\TimestampableTrait;
use App\ValueObjects\Uuid;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChallengeSetRepository::class)]
class ChallengeSet
{
    use IdentifierTrait, IsActiveTrait, TimestampableTrait;

    #[ORM\Column(length: 200)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $sumary = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $due = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(nullable: true)]
    private ?int $status = 0;

    #[ORM\Column]
    private ?bool $isSolved = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author = null;

    #[ORM\OneToMany(mappedBy: 'challenge', targetEntity: Media::class, orphanRemoval: true)]
    private Collection $media;

    public function __construct()
    {
        $this->id = Uuid::random()->value();
        $this->isActive = false;
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

    public function getSumary(): ?string
    {
        return $this->sumary;
    }

    public function setSumary(string $sumary): self
    {
        $this->sumary = $sumary;

        return $this;
    }

    public function getDue(): ?\DateTimeInterface
    {
        return $this->due;
    }

    public function setDue(?\DateTimeInterface $due): self
    {
        $this->due = $due;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function isIsSolved(): ?bool
    {
        return $this->isSolved;
    }

    public function setIsSolved(bool $isSolved): self
    {
        $this->isSolved = $isSolved;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): self
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
            $medium->setChallenge($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): self
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getChallenge() === $this) {
                $medium->setChallenge(null);
            }
        }

        return $this;
    }
}
