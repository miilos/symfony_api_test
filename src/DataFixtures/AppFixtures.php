<?php

namespace App\DataFixtures;

use App\Factory\EmployerFactory;
use App\Factory\JobFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $employers = [];
        foreach (EmployerFactory::EMPLOYERS as $employer) {
            $employers[] = EmployerFactory::createOne([
                'name' => $employer,
            ]);
        }

        JobFactory::createMany(20, function() use ($employers) {
            return [
                'employer' => EmployerFactory::random()
            ];
        });
    }
}
