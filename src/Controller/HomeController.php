<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $repoArticle;
    private $repoCategorie;

    public function __construct(ArticleRepository $repoArticle, CategorieRepository $repoCategorie)
    {
        $this->repoArticle = $repoArticle;
        $this->repoCategorie = $repoCategorie;
    }

    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        // $repo = $this->getDoctrine()->getRepository(Article::class); queda obsoleta al crear un metodo constructor gracias a la injection de dependencias

        $categories = $this->repoCategorie->findAll();
        // dd($categories);
        $articles = $this->repoArticle->findAll();
        
        return $this->render("home/index.html.twig",[
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Article $article): Response
    {
        if(!$article){
            return $this->redirectToRoute('home');
        }
        
        return $this->render("show/index.html.twig",[
            'article' => $article,
        ]);
    }

    /**
     * @Route("/showArticles/{id}", name="show_article")
     */
    public function showArticle(?Categorie $categorie): Response
    {
        if($categorie){
            $articles = $categorie->getArticles()->getValues();
        }else{
            return $this->redirectToRoute('home');
        }
        $categories = $this->repoCategorie->findAll();
        return $this->render("show/showArticle.html.twig",[
            'articles' => $articles,
            'categories' => $categories,
        ]);
        
    }

}
