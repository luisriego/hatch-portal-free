<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 5,
        max: 255
    )]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank()]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subtitle = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Area $area = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Fact::class, orphanRemoval: true)]
    private Collection $fact;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $sumary = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Challenge::class, orphanRemoval: true)]
    private Collection $challenges;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Solution::class, orphanRemoval: true)]
    private Collection $solutions;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Highlight::class, orphanRemoval: true)]
    private Collection $highlights;

    #[ORM\Column(nullable: true)]
    private ?int $status = 0;

    public function __construct()
    {
        $this->status = 0;
        $this->fact = new ArrayCollection();
        $this->challenges = new ArrayCollection();
        $this->solutions = new ArrayCollection();
        $this->highlights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getArea(): ?Area
    {
        return $this->area;
    }

    public function setArea(?Area $area): self
    {
        $this->area = $area;

        return $this;
    }

    /**
     * @return Collection<int, Fact>
     */
    public function getFact(): Collection
    {
        return $this->fact;
    }

    public function addFact(Fact $fact): self
    {
        if (!$this->fact->contains($fact)) {
            $this->fact->add($fact);
            $fact->setProject($this);
        }

        return $this;
    }

    public function removeFact(Fact $fact): self
    {
        if ($this->fact->removeElement($fact)) {
            // set the owning side to null (unless already changed)
            if ($fact->getProject() === $this) {
                $fact->setProject(null);
            }
        }

        return $this;
    }

    public function getSumary(): ?string
    {
        return $this->sumary;
    }

    public function setSumary(?string $sumary): self
    {
        $this->sumary = $sumary;

        return $this;
    }

    /**
     * @return Collection<int, Challenge>
     */
    public function getChallenges(): Collection
    {
        return $this->challenges;
    }

    public function addChallenge(Challenge $challenge): self
    {
        if (!$this->challenges->contains($challenge)) {
            $this->challenges->add($challenge);
            $challenge->setProject($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): self
    {
        if ($this->challenges->removeElement($challenge)) {
            // set the owning side to null (unless already changed)
            if ($challenge->getProject() === $this) {
                $challenge->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Solution>
     */
    public function getSolutions(): Collection
    {
        return $this->solutions;
    }

    public function addSolution(Solution $solution): self
    {
        if (!$this->solutions->contains($solution)) {
            $this->solutions->add($solution);
            $solution->setProject($this);
        }

        return $this;
    }

    public function removeSolution(Solution $solution): self
    {
        if ($this->solutions->removeElement($solution)) {
            // set the owning side to null (unless already changed)
            if ($solution->getProject() === $this) {
                $solution->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Highlight>
     */
    public function getHighlights(): Collection
    {
        return $this->highlights;
    }

    public function addHighlight(Highlight $highlight): self
    {
        if (!$this->highlights->contains($highlight)) {
            $this->highlights->add($highlight);
            $highlight->setProject($this);
        }

        return $this;
    }

    public function removeHighlight(Highlight $highlight): self
    {
        if ($this->highlights->removeElement($highlight)) {
            // set the owning side to null (unless already changed)
            if ($highlight->getProject() === $this) {
                $highlight->setProject(null);
            }
        }

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
}
