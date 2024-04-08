<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $movie = new Movie();
        $movie-> setTitle('Oppenheimer');
        $releaseDate1 = new \DateTime('2023-07-21');
        $movie->setReleaseDate($releaseDate1);
        $movie->setDescription('Discription of Oppenheimer');
        $movie->setImagePath('https://posterspy.com/wp-content/uploads/2023/08/Oppenheimer-PosterSpy-4.jpg');
        $movie->addActor($this->getReference('actor_1'));
        $movie->addActor($this->getReference('actor_2'));
        $movie->addActor($this->getReference('actor_3'));
        $manager->persist($movie);

        $movie2 = new Movie();
        $movie2-> setTitle('Poor Things');
        $releaseDate2 = new \DateTime('2024-02-27');
        $movie2->setReleaseDate($releaseDate2);
        $movie2->setDescription('The incredible tale about the fantastical evolution of Bella Baxter, a young woman brought back to life by the brilliant and unorthodox scientist Dr. Godwin Baxter.');
        $movie2->setImagePath('https://image.tmdb.org/t/p/original/kCGlIMHnOm8JPXq3rXM6c5wMxcT.jpg');
        $movie2->addActor($this->getReference('actor_4'));
        $movie2->addActor($this->getReference('actor_5'));
        $movie2->addActor($this->getReference('actor_6'));
        $manager->persist($movie2);

        $manager->flush();
    }
}
