<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $owner1 = new Author();
        $owner1->setEmail('owner1@hatch.com');
        $owner1->setName('owner1Name');
        $owner1->setSurname('owner1Surname');
        $owner1->setPosition('Lider de Lideres');
        $manager->persist($owner1);

        $post1 = new Blog();
        $post1->setTitle('Advanced process control: the engine of Industry 4.0');
        $post1->setAuthor('autor 1');
        $post1->setDate(new \DateTime());
        $post1->setText('texto del post');
        $post1->setOwner($owner1);
        $post1->setIsActive(true);
        $manager->persist($post1);

        $manager->flush();
    }
}
