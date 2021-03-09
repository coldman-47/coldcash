<?php

namespace App\DataPersister;

use DateTime;
use App\Entity\TransactionEnCours;
use App\Entity\TransactionTermine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\HttpFoundation\Request;

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
        return $data instanceof TransactionEnCours && isset($context['item_operation_name']);
    }

    public function persist($data, array $context = [])
    {
        $em = $this->manager;
        $receveur = $em->getUnitOfWork()->getOriginalEntityData($data)['receveur']->setCni($data->getReceveur()->getCni());
        $montant = $data->getMontant();
        $agentRetrait = $this->security->getUser();
        $data->setReceveur($receveur)
            ->setAgentRetrait($agentRetrait)
            ->setDateRetrait(new DateTime());
        $agentRetrait->getAgence()->setSolde($montant + $data->getFraisRetrait());
        $response = $this->normalizer->normalize($data);
        $retrait = $this->normalizer->denormalize($response, TransactionTermine::class);
        $retrait->setAgenceRetrait($agentRetrait->getAgence());
        $em->remove($data);
        $em->persist($retrait);
        $em->flush($retrait);
        return new JsonResponse($response, 200);
    }

    public function remove($data, array $context = [])
    {
        $data->getAgentDepot()->getAgence()->setSolde($data->getMontant() + $data->getFrais() - $data->fraisDepot());
        $this->manager->remove($data);
        $this->manager->flush();
        return new JsonResponse("Transaction annulée", 200);
    }
}

// $uow = $this->manager->getUnitOfWork();
// $uow->registerManaged($retrait, ["id" => $retrait->getId()], $this->normalizer->normalize($data));
// $uow->scheduleForUpdate($retrait);
// dd($uow);
// $metadata = $this->manager->getClassMetaData(TransactionTermine::class);
// $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
// $metadata->setIdGenerator(new AssignedGenerator());