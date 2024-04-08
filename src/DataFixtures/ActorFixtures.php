<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $actor = new Actor();
        $actor->setName('Cillian Murphy');
        $manager->persist($actor);

        $actor2 = new Actor();
        $actor2->setName('Robert Downey Jr.');
        $manager->persist($actor2);

        $actor3 = new Actor();
        $actor3->setName('Emily Blunt');
        $manager->persist($actor3);

        $actor4 = new Actor();
        $actor4->setName('Emma Stone');
        $manager->persist($actor4);

        $actor5 = new Actor();
        $actor5->setName('Mark Ruffalo');
        $manager->persist($actor5);

        $actor6 = new Actor();
        $actor6->setName('Willem Dafoe');
        $manager->persist($actor6);
        
        $manager->flush();

        $this->addReference('actor_1', $actor);
        $this->addReference('actor_2', $actor2);
        $this->addReference('actor_3', $actor3);
        $this->addReference('actor_4', $actor4);
        $this->addReference('actor_5', $actor5);
        $this->addReference('actor_6', $actor6);
    }
}
