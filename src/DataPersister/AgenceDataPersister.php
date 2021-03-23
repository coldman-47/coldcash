<?php

namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Agence;
use App\Repository\ProfilRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AgenceDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(EntityManagerInterface $manager, ProfilRepository $repo)
    {
        $this->manager = $manager;
        $this->repo = $repo;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Agence;
    }

    public function persist($data, array $context = [])
    {
        $data->getAdmin()->setProfil($this->repo->findOneBy(['libelle' => 'adminAgence']));
        $this->manager->persist($data);
        $this->manager->flush();
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
