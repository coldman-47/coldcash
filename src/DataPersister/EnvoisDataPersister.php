<?php

namespace App\DataPersister;

use App\Entity\Depot;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\TransactionEnCours;
use App\Repository\FraisRepository;
use DateTime;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

final class EnvoisDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(EntityManagerInterface $manager, Security $security, FraisRepository $repo)
    {
        $this->manager = $manager;
        $this->security = $security;
        $this->repo = $repo;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof TransactionEnCours;
    }

    public function persist($data, array $context = [])
    {
        $montant = $data->getMontant();
        $frais = $this->repo->getFrais(20000);
        dd($frais);
        $data->setAgentDepot($this->security->getUser())
            ->setDateDepot(new DateTime());
        $this->manager->persist($data);
        $this->manager->flush();
        return new JsonResponse("success", 200);
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
    }
}
