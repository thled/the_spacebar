<?php

namespace App\Controller;

use App\Service\SlackClient;
use Psr\Log\LoggerInterface;
use App\Service\MarkdownHelper;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render('article/homepage.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(Article $article, SlackClient $slack)
    {
        if ($article->getSlug() === 'khaaan') {
            $slack->sendMessage('Khaan', 'Hi there! I\'m calling from a Service!');
        }

        return $this->render(
            'article/show.html.twig',
            [
                'article' => $article,
            ]
        );
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart(
        Article $article,
        LoggerInterface $logger,
        EntityManagerInterface $em
    ) {
        $article->incrementHeartCount();
        $em->flush();

        $logger->info('Article is being hearted');

        return $this->json(['hearts' => $article->getHeartCount()]);
    }
}
