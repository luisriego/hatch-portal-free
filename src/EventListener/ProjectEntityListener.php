<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Project;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProjectEntityListener
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
    }

    public function prePersist(Project $project, LifecycleEventArgs $eventArgs)
    {
        $project->computeSlug($this->slugger);
    }

    public function preUpdate(Project $project, LifecycleEventArgs $eventArgs)
    {
        $project->computeSlug($this->slugger);
        $project->markAsUpdated();
    }
}