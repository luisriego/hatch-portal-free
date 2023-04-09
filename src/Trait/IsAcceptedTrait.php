<?php

declare(strict_types=1);

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;

trait IsAcceptedTrait
{
    #[ORM\Column(type: 'boolean')]
    protected bool $isAccepted = false;

    #[ORM\Column(type: 'datetime_immutable')]
    protected \DateTimeImmutable $acceptedOn;

    public function isAccepted(): bool
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(bool $isAccepted): void
    {
        $this->isAccepted = $isAccepted;
    }

    public function getAcceptedOn(): \DateTimeImmutable
    {
        return $this->acceptedOn;
    }

    public function setAcceptedOn(): void
    {
        $this->acceptedOn = new \DateTimeImmutable();
    }

    public function toggleAccepted(): void
    {
        $this->isAccepted = !$this->isAccepted;
    }
}
