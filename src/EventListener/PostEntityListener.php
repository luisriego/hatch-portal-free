<?php

declare(strict_types=1);

namespace App\EventListener;


use App\Entity\Blog;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class PostEntityListener
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
    }

    public function prePersist(Blog $blog, LifecycleEventArgs $eventArgs)
    {
        $blog->computeSlug($this->slugger);
    }

    public function preUpdate(Blog $blog, LifecycleEventArgs $eventArgs)
    {
        $blog->computeSlug($this->slugger);
    }
}
