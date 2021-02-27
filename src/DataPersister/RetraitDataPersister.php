<?php

namespace App\DataPersister;

use DateTime;
use Normalizer;
use App\Entity\TransactionEnCours;
use App\Entity\TransactionTermine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

final class RetraitDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(EntityManagerInterface $manager, Security $security, NormalizerInterface $normalizer)
    {
        $this->manager = $manager;
        $this->security = $security;
        $this->normalizer = $normalizer;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof TransactionEnCours;
    }

    public function persist($data, array $context = [])
    {
        $montant = $data->getMontant();
        $data->setAgentRetrait($this->security->getUser());
        $data->getAgentDepot()->getAgence()->setSolde(-$montant - $data->getFrais() + $data->getFraisDepot());
        $data->getAgentRetrait()->getAgence()->setSolde($montant + $data->getFraisRetrait());
        $data->setDateRetrait(new DateTime());
        $retrait = $this->normalizer->denormalize($this->normalizer->normalize($data), TransactionTermine::class);
        $retrait->setId($data->getId(), $context);
        $this->manager->remove($data);
        $this->manager->persist($retrait);
        $this->manager->flush();
        return new JsonResponse("success", 200);
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
    }
}
