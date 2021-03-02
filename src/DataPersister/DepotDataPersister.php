<?php

namespace App\DataPersister;

use DateTime;
use App\Entity\Depot;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Repository\AgenceRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class DepotDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(EntityManagerInterface $manager, Security $security, AgenceRepository $repo)
    {
        $this->manager = $manager;
        $this->security = $security;
        $this->repo = $repo;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Depot;
    }

    public function persist($data, array $context = [])
    {
        $montant = $data->getMontant();
        $data->getAgence()->setSolde($montant);
        $data->setCaissier($this->security->getUser());
        $this->manager->persist($data);
        $this->manager->flush();
        return new JsonResponse("success", 200);
    }

    public function remove($data, array $context = [])
    {
        if ($data->getStatut()) {
            $agence = $data->getAgence();
            $lastDepot = $agence->getTransactionsDepot()->last();
            if ((isset($lastDepot) && $data->getDate() > $lastDepot->getDateDepot()) || !$lastDepot) {
                $agence->setSolde(-$data->getMontant());
                $data->setAgence($agence)
                    ->setStatut(false);
                $this->manager->persist($data);
                $this->manager->flush();
                return new JsonResponse("Dépôt annulé", 200);
            }
            throw new BadRequestHttpException("Merci de contacter un administrateur pour l'annulation du dépot");
        }
        throw new BadRequestHttpException("Not Found");
    }
}
