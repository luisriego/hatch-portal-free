<?php

declare(strict_types=1);

namespace App\Repository;

interface TopicRepositoryInterface
{
    public function findRandomTreeOrFail(): ?array;

    public function getTotalNumber(): ?int;
}
