<?php

declare(strict_types=1);

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;

trait UpdatedOnTrait
{
    #[ORM\Column(type: 'datetime')]
    protected \DateTime $updatedOn;

    public function getUpdatedOn(): \DateTime
    {
        return $this->updatedOn;
    }

    #[ORM\PrePersist]
    public function markAsUpdated(): void
    {
        $this->updatedOn = new \DateTime();
    }
}
