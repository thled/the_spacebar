<?php

namespace App\Form;

use App\Entity\Article;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    /** @var UserRepository */
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Article|null $article */
        $article = $options['data'] ?? null;
        $isEdit = $article && $article->getId();

        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'help' => 'Choose something catchy!',
                ]
            )
            ->add('content', null, [
                'rows' => 15,
            ])
            ->add(
                'author',
                UserSelectTextType::class,
                [
                    'disabled' => $isEdit,
                ]
            );

        if ($options['include_published_at']) {
            $builder->add(
                'publishedAt',
                null,
                [
                    'widget' => 'single_text',
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'include_published_at' => false,
        ]);
    }
}
