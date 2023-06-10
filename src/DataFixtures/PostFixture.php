<?php

namespace App\DataFixtures;

use App\Entity\Area;
use App\Entity\Author;
use App\Entity\Blog;
use App\Entity\ChallengeSet;
use App\Entity\Media;
use App\Entity\News;
use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $owner = new Author();
        $owner->setEmail('owner1@hatch.com');
        $owner->setName('owner1Name');
        $owner->setSurname('owner1Surname');
        $owner->setPosition('Lider de Lideres');
        $manager->persist($owner);

        $owner1 = new Author();
        $owner1->setEmail('owner1@hatch.com');
        $owner1->setName('owner1Name');
        $owner1->setSurname('owner1Surname');
        $owner1->setPosition('Lider de Lideres');
        $manager->persist($owner1);

        $area = new Area();
        $area->setName('Metais');
        $manager->persist($area);
        $area1 = new Area();
        $area1->setName('Infra');
        $manager->persist($area1);
        $area2 = new Area();
        $area2->setName('Minas');
        $manager->persist($area2);

        $post1 = new Blog();
        $post1->setTitle('Advanced process control: the engine of Industry 4.0');
        $post1->setAuthor('autor 1');
        $post1->setDate(new \DateTime());
        $post1->setText('texto del post');
        $post1->setOwner($owner1);
        $post1->setIsActive(true);
        $manager->persist($post1);

        $post1 = new Blog();
        $post1->setTitle('Not advanced process control');
        $post1->setAuthor('autor');
        $post1->setDate(new \DateTime());
        $post1->setText('texto del post');
        $post1->setOwner($owner);
        $post1->setIsActive(true);
        $manager->persist($post1);

        $project = new Project();
        $project->setTitle('Título do projeto');
        $project->setSubtitle('Subtítulo do projeto');
        $project->addAuthor($owner1);
        $project->setArea($area);
        $project->setLocation('BH');
        $project->setStatus(5);
        $manager->persist($project);

        $news = new News();
        $news->setTitle('Título da notícia');
        $news->setSubtitle('Subtítulo da notícia');
        $news->setUrl('www.google.com');
        $news->setDate('06/08/23');
        $news->setAuthor($owner1);
        $news->setToPublish(true);
        $manager->persist($news);

        $challenge = new ChallengeSet();
        $challenge->setAuthor($owner1);
        $challenge->setName('Desafio 1');
        $challenge->setSumary('Sumário');
        $challenge->setStatus(0);
        $challenge->setIsSolved(false);
        $challenge->setIsActive(true);
        $manager->persist($challenge);

        $media = new Media();
        $media->setName('public/media/projects/b60672a396df.jpg');
        $media->setChallenge($challenge);
        $manager->persist($media);

        $manager->flush();
    }
}
