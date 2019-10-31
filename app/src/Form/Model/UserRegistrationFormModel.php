<?php

declare(strict_types=1);

namespace App\Form\Model;

use App\Validator\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationFormModel
{
    /**
     * @Assert\NotBlank(message="Please enter an email")
     * @Assert\Email()
     * @UniqueUser()
     */
    public $email;

    /**
     * @Assert\NotBlank(message="Choose a password!")
     * @Assert\Length(
     *     min=5,
     *     minMessage="Come on, take a longer PW!"
     * )
     */
    public $plainPassword;

    /**
     * @Assert\IsTrue(message="You must agree.")
     */
    public $agreeTerms;
}
