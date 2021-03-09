<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\TransactionEnCours;
use App\Repository\FraisRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class EnvoisDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(EntityManagerInterface $manager, Security $security, FraisRepository $repo, NormalizerInterface $normalizer)
    {
        $this->manager = $manager;
        $this->security = $security;
        $this->repo = $repo;
        $this->normalizer = $normalizer;
    }

    public function supports($data, array $context = []): bool
    {
        return ($data instanceof TransactionEnCours) && isset($context['collection_operation_name']);
    }

    public function persist($data, array $context = [])
    {
        $rand = str_shuffle(date('shiydm'));
        $rand[6] = $rand[6] + rand(0, 20);
        $montant = $data->getMontant();
        if ($montant <= 0) {
            throw new BadRequestHttpException("Montant incorrect!");
        }
        $agentDepot = $this->security->getUser();
        if ($montant < 5000 || $montant > $agentDepot->getAgence()->getSolde()) {
            throw new BadRequestHttpException("Solde du compte de l'agence insuffisant!");
        }
        $frais = $this->repo->getFrais($montant);
        if ($frais < 1) {
            $frais *= $montant;
        }
        $data->setFrais($frais)
            ->setFraisEtat($frais * 0.4)
            ->setFraisSystem($frais * 0.3)
            ->setFraisDepot($frais * 0.1)
            ->setFraisRetrait($frais * 0.2)
            ->setAgentDepot($agentDepot)
            ->setAgenceDepot($agentDepot->getAgence())
            ->setDateDepot(new DateTime())
            ->setCode($rand)
            ->setStatut(true);
        $data->getAgenceDepot()->setSolde(-$montant - $data->getFrais() + $data->getFraisDepot());
        $this->manager->persist($data);
        $this->manager->flush();
        return new JsonResponse($this->normalizer->normalize($data), 200);
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
    }
}
