<?php

namespace App\DataFixtures;

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
        $type = new Type();
        $type->setType('Energy');
        $type->setTitle('Responding to the energy transition');
        $type->setImage('https://www.hatch.com/-/media/Hatch-Corporate/Banner/Responding-to-the-energy-transition-home.jpg?h=440&iar=0&w=1200&hash=66CB2AE82FDDCEC00C59F26E7EBB463B');
        $type->setSubtitle('Championing a low carbon future');
        $type->setLink('https://www.hatch.com/Expertise/Topics/Responsible-Energy');
        $manager->persist($type);

        $type1 = new Type();
        $type1->setType('Mining');
        $type1->setTitle('Innovation in Mining');
        $type1->setImage('https://www.hatch.com/-/media/Hatch-Corporate/Banner/Innovation-in-Mining.jpg?h=580&iar=0&w=1920&hash=C5D1730B1A75F24F84B195A8D98BFFF8');
        $type1->setSubtitle('A step change begins with a vision of what is possible');
        $type1->setLink('https://www.hatch.com/Expertise/Topics/Innovation-in-Mining');
        $manager->persist($type1);

        $type2 = new Type();
        $type2->setType('Urban');
        $type2->setTitle('Innovation in Urban Solutions');
        $type2->setImage('https://www.hatch.com/-/media/Hatch-Corporate/Homepage/Urban-Solutions-home.jpg?h=400&iar=0&w=1200&hash=DBD88FB0BA1B49EAB0FF22B03BBEDC73');
        $type2->setSubtitle('Smarter cities arent a social ideal, theyre an economic imperative');
        $type2->setLink('https://www.hatch.com/Projects/Infrastructure/The-socioeconomic-impact-of-the-Gautrain-study');
        $manager->persist($type2);

        $topic = new Topic();
        $topic->setTitle('Bécancour Green Hydrogen Plant');
        $topic->setSubtitle('Championing a low carbon future');
        $topic->setCaseStudy('20-megawatt proton exchange membrane electrolyzer');
        $topic->setLocation('Air Liquide Canada | Canada | 2019-2020');
        $topic->setChallenges('Global trends for a low-emission environment has required the search for alternative power sources, such as green hydrogen. When industrial processes are combined with renewable energy sources in the generation of electricity for the electrolysis of water, green hydrogen is produced without carbon emissions.');
        $topic->setSolutions('Provided civil, structural, and architectural, heating, ventilation, air conditioning engineering and construction and health and safety management services in the installation of proton exchange membrane (PEM) electrolyzers technology to form a 20-megawatt (MW) system.');
        $topic->setHighlights('This cutting-edge project will implement the first large-scale use of novel PEM technology. Once this project enters commercial production, it will be the largest-of-its kind to produce green hydrogen in the world. Becancour’s proximity to major industrial markets in Canada and the United States will help ensure North America’s supply of low-carbon hydrogen for both industry and mobility usage.');
        $topic->setImage('https://www.hatch.com/-/media/Hatch-Corporate/Projects/Energy/Bcancour-Green-Hydrogen-Plant.jpg');
        $topic->setLink('https://www.hatch.com/Expertise/Topics/Responsible-Energy');
        $topic->setType($type);
        $manager->persist($topic);

        $topic1 = new Topic();
        $topic1->setTitle('The socioeconomic impact of the Gautrain study');
        $topic1->setSubtitle('Championing a low carbon future');
        $topic1->setCaseStudy('20-megawatt proton exchange membrane electrolyzer');
        $topic1->setLocation('Gautrain Management Agency | South Africa | 2018-2019');
        $topic1->setChallenges('Increasing levels of travel and tourism in the Gauteng province have influenced the need for construction on the Gautrain light rail infrastructure system, connecting Johannesburg, Pretoria, and the O.R. Tambo International Airport. Understanding and maximizing the economic impacts and social benefits that the light rail system has, and will deliver, is becoming a critical factor in influencing the need for investment, expansion, and construction of the system so that the Gauteng province remains globally competitive.');
        $topic1->setSolutions('Hatch partnered with the Gautrain Management Agency (GMA) to understand the impact of the project by combining the economic insights, transportation planning skills, and deep understanding of local issues. The study demonstrated the full range of economic and social benefits that Gautrain provides and can continue to deliver with further investment. Our analysis provided fresh insight that addressed employment, property development, time savings, reducing inequality, emission savings, attracting foreign inward investment, current and future economic returns on investment, and annual contribution to regional GDP to successfully make the case for integrating this wider transport system across the Gauteng region.');
        $topic1->setHighlights('The study demonstrates how this world-class rapid transit system has positively transformed a city region that is home to 14 million people. The study validated the original motivation for the Gautrain, while demonstrating and communicating the impact in a way that resonated with multiple stakeholders.');
        $topic1->setImage('https://www.hatch.com/-/media/Hatch-Corporate/Projects/Infrastructure/The-socioeconomic-impact-of-the-Gautrain-study.jpg');
        $topic1->setLink('https://www.hatch.com/Projects/Infrastructure/The-socioeconomic-impact-of-the-Gautrain-study');
        $topic1->setType($type1);
        $manager->persist($topic1);

        $topic2 = new Topic();
        $topic2->setTitle('AP60 Smelter');
        $topic2->setSubtitle('Approaches for a new era of mining');
        $topic2->setCaseStudy('Pilot plant produces 40% more aluminum');
        $topic2->setLocation('Rio Tinto Alcan | Canada | 2007–2013');
        $topic2->setChallenges('This greenfield plant wanted to demonstrate new proprietary AP60-smelting technology at an industrial scale.   The smelter was to produce 40% more aluminum per cell than the previous generation of AP technology.');
        $topic2->setSolutions('We provided project management, lean engineering, procurement, construction management, pre-commissioning, and commissioning services.');
        $topic2->setHighlights('Recognized by the Project Management Institute with the International Project of the Year Award in 2014, and the Project of the Year Award—Montréal  in 2013.');
        $topic2->setImage('https://www.hatch.com/-/media/Hatch-Corporate/Projects/MetalsMinerals/AP60_cropped.jpg');
        $topic2->setLink('https://www.hatch.com/Projects/Metals-And-Minerals/AP60');
        $topic2->setType($type2);
        $manager->persist($topic2);

        $user = new User();
        $user->setEmail('admin@hatch.com');

        $password = $this->hasher->hashPassword($user, '123456');
        $user->setPassword($password);

        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
