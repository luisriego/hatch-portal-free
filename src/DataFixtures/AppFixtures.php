<?php

namespace App\DataFixtures;

use App\Entity\Area;
use App\Entity\Author;
use App\Entity\Blog;
use App\Entity\ChallengeSet;
use App\Entity\Media;
use App\Entity\News;
use App\Entity\Project;
use App\Entity\Topic;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@hatch.com');

        $password = $this->hasher->hashPassword($user, '123456');
        $user->setPassword($password);

        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
