<?php

namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Agence;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AgenceDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Agence;
    }

    public function persist($data, array $context = [])
    {
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setStatut(false);
        $data->getAdmin->setStatut(false);
        foreach ($data->getAgents as $agent) {
            $agent->setStatut(false);
            $this->manager->persist($agent);
        }
        $this->manager->persist($data);
        $this->manager->flush();
        return new JsonResponse("Utilisateur bloqué", 200);
    }
}
