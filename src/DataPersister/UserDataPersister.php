<?php

namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\AdminAgence;
use App\Entity\AdminSystem;
use App\Entity\Agent;
use App\Entity\Caissier;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UserDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof AdminSystem || $data instanceof AdminAgence || $data instanceof Agent || $data instanceof Caissier;
    }

    public function persist($data, array $context = [])
    {
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setStatut(false);
        $this->manager->persist($data);
        $this->manager->flush();
        return new JsonResponse("Utilisateur bloqué", 200);
    }
}
