<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Annonces;

class AnnoncesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1;$i <= 10;$i++){
            $annonce = new Annonces();
           # $annonce->setImage("http://placehold.it/350x150");
                
            $manager->persist($annonce);
        }
        $manager->flush();
    }
}
