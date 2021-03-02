<?php


namespace App\Services;


use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ValidatorPost
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;


    /**
     * ValidatorPost constructor.
     */
    public function __construct(ValidatorInterface $validator, SerializerInterface $serializer)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function ValidateFields($obj)
    {
        $this->validator->validate($obj);
    }
}
