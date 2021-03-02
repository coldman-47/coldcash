<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Caissier;
use App\Entity\AdminAgence;
use App\Entity\AdminSystem;
use App\Services\fileService;
use App\Services\UserServices;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    private $manager, $services, $encoder, $fservice, $repo;
    public function __construct(EntityManagerInterface $manager, UserServices $services,  UserPasswordEncoderInterface $encoder, fileService $fservice, ProfilRepository $repo)
    {
        $this->manager = $manager;
        $this->services = $services;
        $this->fservice = $fservice;
        $this->encoder = $encoder;
        $this->repo = $repo;
    }

    /**
     * @Route(
     *  "/api/coldcash/admin",
     *  name="addAdminSystem",
     *  methods = {"POST"},
     *  defaults={
     *      "_api_resource_class" = AdminSystem::class,
     *      "_api_collection_operation_name" = "post"
     *  }
     * )
     */
    public function addAdminSystem(Request $request)
    {
        $User = $this->services->newUser($request, "AdminSystem");
        $this->manager->persist($User);
        $this->manager->flush();
        return new JsonResponse("success", Response::HTTP_CREATED);
    }

    /**
     * @Route(
     *  "/api/coldcash/caissier",
     *  name="addCaissier",
     *  methods = {"POST"},
     *  defaults={
     *      "_api_resource_class" = Caissier::class,
     *      "_api_collection_operation_name" = "post"
     *  }
     * )
     */
    public function addCaissier(Request $request)
    {
        $User = $this->services->newUser($request, "Caissier");
        $this->manager->persist($User);
        $this->manager->flush();
        return new JsonResponse("success", Response::HTTP_CREATED);
    }

    /**
     * @Route(
     *  "/api/agence/user",
     *  name="addAgent",
     *  methods = {"POST"},
     *  defaults={
     *      "_api_resource_class" = Agent::class,
     *      "_api_collection_operation_name" = "post"
     *  }
     * )
     */
    public function addAgent(Request $request)
    {
        $User = $this->services->newUser($request, "Agent");
        $this->manager->persist($User);
        $this->manager->flush();
        return new JsonResponse("success", Response::HTTP_CREATED);
    }

    /**
     * @Route(
     *  "/api/agence/admin",
     *  name="addAdminAgence",
     *  methods = {"POST"},
     *  defaults={
     *      "_api_resource_class" = AdminAgence::class,
     *      "_api_collection_operation_name" = "post"
     *  }
     * )
     */
    public function addAdminAgence(Request $request)
    {
        $User = $this->services->newUser($request, "AdminAgence");
        $this->manager->persist($User);
        $this->manager->flush();
        return new JsonResponse("success", Response::HTTP_CREATED);
    }

    private function setUser($request, $profil)
    {
        $user = $request->attributes->get('data');
        $userTab = $this->fservice->putFormData($request, 'avatar', 'image');
        if (isset($userTab['oldpwd'])) {
            if (!password_verify($userTab['oldpwd'], $user->getPassword())) {
                throw new BadRequestHttpException('Mot de passe erroné');
            }
            unset($userTab['oldpwd']);
        }
        foreach ($userTab as $k => $val) {
            $setter = "set" . ucfirst(strtolower($k));
            if (method_exists("App\\Entity\\$profil", $setter)) {
                if ($k == 'password') {
                    $user->$setter($this->encoder->encodePassword($user, $val));
                } else {
                    $user->$setter($val);
                }
            }
        }
        return $user;
    }

    /**
     * @Route(
     *  "/api/agence/user/{id}",
     *  name="setAgent",
     *  methods = {"PUT"},
     *  defaults={
     *      "_api_resource_class" = Agent::class,
     *      "_api_item_operation_name" = "put"
     *  }
     * )
     */
    public function setAgent(Request $request)
    {
        $this->update($request, "Agent");
    }

    /**
     * @Route(
     *  "/api/coldcash/caissier/{id}",
     *  name="setCaissier",
     *  methods = {"PUT"},
     *  defaults={
     *      "_api_resource_class" = Caissier::class,
     *      "_api_item_operation_name" = "put"
     *  }
     * )
     */
    public function setCaissier(Request $request)
    {
        $this->update($request, "Caissier");
    }

    /**
     * @Route(
     *  "/api/coldcash/admin/{id}",
     *  name="setAdminSystem",
     *  methods = {"PUT"},
     *  defaults={
     *      "_api_resource_class" = AdminSystem::class,
     *      "_api_item_operation_name" = "put"
     *  }
     * )
     */
    public function setAdminSystem(Request $request)
    {
        $this->update($request, "Adminsystem");
    }

    /**
     * @Route(
     *  "/api/agence/admin/{id}",
     *  name="setAdminAgence",
     *  methods = {"PUT"},
     *  defaults={
     *      "_api_resource_class" = AdminAgence::class,
     *      "_api_item_operation_name" = "put"
     *  }
     * )
     */
    public function setAdminAgence(Request $request)
    {
        $this->update($request, "AdminAgence");
    }

    private function update(Request $request, string $profil)
    {
        $user = $this->setUser($request, $profil);
        $this->manager->persist($user);
        $this->manager->flush();
        return $this->json($user);
    }
}
