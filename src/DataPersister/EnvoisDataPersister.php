<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\TransactionEnCours;
use App\Repository\FraisRepository;
use DateTime;
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
        return ($data instanceof TransactionEnCours) && isset($context['collection_operation_name']);
    }

    public function persist($data, array $context = [])
    {
        $rand = strval(date('shiydm'));
        $rand[6] = $rand[6] + rand(0, 20);
        $montant = $data->getMontant();
        $frais = $this->repo->getFrais($montant);
        if ($frais < 1) {
            $frais *= $montant;
        }
        $data->setFrais($frais)
            ->setFraisEtat($frais * 0.4)
            ->setFraisSystem($frais * 0.3)
            ->setFraisDepot($frais * 0.1)
            ->setFraisRetrait($frais * 0.2)
            ->setAgentDepot($this->security->getUser())
            ->setDateDepot(new DateTime())
            ->setCode($rand)
            ->setStatut(true);
        $this->manager->persist($data);
        $this->manager->flush();
        return new JsonResponse("success", 200);
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
    }
}
