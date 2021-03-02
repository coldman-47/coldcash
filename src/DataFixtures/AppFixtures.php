<?php

namespace App\DataFixtures;

use App\Entity\Agence;
use Faker\Factory;
use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $profils = ['adminSystem', 'caissier', 'adminAgence', 'agent'];
        $faker = Factory::create('en_US');
        $agences = [];
        foreach ($profils as $libelle) {
            $profil = new Profil();
            $profil->setLibelle($libelle);
            $manager->persist($profil);
            $entity = 'App\\Entity\\' . ucfirst($libelle);
            if (class_exists($entity)) {
                for ($i = 0; $i < 3; $i++) {
                    $user = new $entity();
                    $user->setProfil($profil)
                        ->setUsername(strtolower($libelle) . ($i + 1))
                        ->setNom($faker->name)
                        ->setStatut(true)
                        ->setPassword($this->encoder->encodePassword($user, 'coldpass'));
                    if (in_array($libelle, ['adminAgence', 'agent'])) {
                        if ($libelle !== 'agent') {
                            $agence = new Agence();
                            $agence->setNom($faker->company)
                                ->setAdresse($faker->streetName)
                                ->setSolde(700000)
                                ->setAdmin($user);
                            $agences[] = $agence;
                        } else {
                            $user->setAgence($agences[$i]);
                        }
                    }
                    $manager->persist($user);
                }
            }
        }
        $manager->flush();
    }
}
