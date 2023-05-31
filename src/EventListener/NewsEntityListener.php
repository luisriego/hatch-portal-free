<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\News;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class NewsEntityListener
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
    }

    public function prePersist(News $news, LifecycleEventArgs $eventArgs)
    {
        $news->computeSlug($this->slugger);
    }

    public function preUpdate(News $news, LifecycleEventArgs $eventArgs)
    {
        $news->computeSlug($this->slugger);
    }
}
