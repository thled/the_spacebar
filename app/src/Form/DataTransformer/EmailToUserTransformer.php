<?php

declare(strict_types=1);

namespace App\Form\DataTransformer;

use App\Entity\User;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Types\Callable_;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EmailToUserTransformer implements DataTransformerInterface
{
    /** @var UserRepository */
    private $userRepo;
    /** @var callable */
    private $finderCallback;

    public function __construct(
        UserRepository $userRepo,
Callable $finderCallback
    )
    {
        $this->userRepo = $userRepo;
        $this->finderCallback = $finderCallback;
    }
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        if (!$value instanceof User) {
            throw new \LogicException('The UserSelectTextType can only be used with Users');
        }

        return $value->getEmail();
    }

    public function reverseTransform($value)
    {
        if (empty($value)) {
            return;
        }

        $callback = $this->finderCallback;
        $user = $callback($this->userRepo, $value);

        if (!$user instanceof User) {
            throw new TransformationFailedException(sprintf(
                'No user found with email %s',
                $value
            ));
        }

        return $user;
    }
}
