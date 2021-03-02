<?php

namespace App\Services;

use App\Repository\ProfilRepository;
use App\Validator\Constraints\MyValidator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserServices
{
    private $encoder, $serializer, $repo, $validator, $fileService;

    public function __construct(UserPasswordEncoderInterface $encoder, DenormalizerInterface $serializer, ProfilRepository $repo, MyValidator $validator, fileService $fileService)
    {
        $this->encoder = $encoder;
        $this->serializer = $serializer;
        $this->repo = $repo;
        $this->validator = $validator;
        $this->fileService = $fileService;
    }

    public function newUser($request, $profil)
    {
        $userTab = $request->request->all();
        foreach ($userTab as $key => $field) {
            $notBlank = $this->validator->notBlank($field, $key);
            if (!is_null($notBlank)) {
                throw new BadRequestHttpException($notBlank);
            }
        }
        $userTab['avatar'] = $this->fileService->getFile($request, 'avatar', "image");
        $userNamspace = "App\\Entity\\$profil";
        if (class_exists($userNamspace)) {
            $newUser = $this->serializer->denormalize($userTab, $userNamspace);
            $newUser->setProfil($this->repo->findOneBy(['libelle' => $profil]));
            $newUser->setPassword($this->encoder->encodePassword($newUser, $userTab['password']));
            return $newUser;
        } else {
            throw new BadRequestException("Le profil renseigné n'éxiste pas");
        }
    }

    function putFormData($request, string $fileName)
    {
        $raw = $request->getContent();
        $delimiter = "multipart/form-data; boundary=";
        $boundary = "--" . explode($delimiter, $request->headers->get("content-type"))[1];
        $elements = str_replace([$boundary, "Content-Disposition: form-data;", "name="], "", $raw);
        $elementsTab = explode("\r\n\r\n", $elements);
        $data = [];
        for ($i = 0; isset($elementsTab[$i + 1]); $i += 2) {
            $key = str_replace(["\r\n", ' "', '"'], '', $elementsTab[$i]);
            if (strchr($key, $fileName)) {
                $type = explode("Content-Type: ", $key)[1];
                $ftype = explode("/", $type)[0];
                if ($ftype == 'image') {
                    $stream = fopen('php://memory', 'r+');
                    fwrite($stream, $elementsTab[$i + 1]);
                    rewind($stream);
                    $data[$fileName] =  $stream;
                } else {
                    throw new BadRequestException("L'avatar de l'utilisateur doit être une image", 400);
                }
            } else {
                $val = str_replace(["\r\n", "--"], '', $elementsTab[$i + 1]);
                $data[$key] =  $val;
            }
        }
        return $data;
    }
}
