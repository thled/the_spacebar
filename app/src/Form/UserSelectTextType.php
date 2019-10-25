<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\DataTransformer\EmailToUserTransformer;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class UserSelectTextType extends AbstractType
{
    /** @var UserRepository */
    private $userRepo;
    /** @var RouterInterface */
    private $router;

    public function __construct(
        UserRepository $userRepo,
        RouterInterface $router)
    {
        $this->userRepo = $userRepo;
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer(
            new EmailToUserTransformer(
                $this->userRepo,
                $options['finder_callback']
            )
        );
    }

    public function getParent(): string
    {
        return TextType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'invalid_message' => 'Hmm, user not found!',
            'finder_callback' => function (
                UserRepository $userRepository,
                string $email
            ) {
                return $userRepository->findOneBy(['email' => $email]);
            },
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $attr = $view->vars['attr'];
        $class = isset($attr['class']) ? $attr['class']. ' ' : '';
        $class .= 'js-user-autocomplete';

        $attr['class'] = $class;
        $attr['data-autocomplete-url'] = $this->router->generate('admin_utility_users');
        $view->vars['attr'] = $attr;
    }
}
