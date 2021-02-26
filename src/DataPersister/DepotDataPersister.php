<?php

namespace App\DataPersister;

use App\Entity\Depot;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class DepotDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Depot;
    }

    public function persist($data, array $context = [])
    {
        $montant = $data->getMontant();
        $data->getAgence()->setSolde($montant);
        $this->manager->persist($data);
        $this->manager->flush();
        return new JsonResponse("success", 200);
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
    }
}
