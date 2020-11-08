<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use App\Service\SwearCleaner;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Form\ArticleType;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $articleRepository->findLastArticles(3);
        // dump($articles);
        
        return $this->render('home/home.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/{page<\d+>?1}", name="show_post")
     */
    public function showPost(int $page): Response
    {
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $article = $articleRepository->find($page);

        $swearCleaner = new  SwearCleaner();
        $article = $swearCleaner->cleanSwear($article);

        return $this->render('home/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/admin/article/add", name="add_post")
     */
    public function addPost(Request $request): Response
    {
        $article = new Article;
        $form = $this->CreateForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $article->setTitle('test');
            // $article->setContent('test');
            // $article->setAuthor('test');
            // $article->setDate(new \DateTime());
            // $article->setCategory('test');
            // $article->setViewCount(0);

            $article = $form->getdata();
            $em =$this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('add_post');
        }

        return $this->render('home/add.html.twig', [
            'form' => $form->createView()
        ]);

        // return $this->render('home/add.html.twig', [
        //     'controller_name' => 'Ajouter Article',
        // ]);
    }
}
