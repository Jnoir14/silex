<?php

namespace TestEmbauche\Ctrl;

use TestEmbauche\Model\Article;
use TestEmbauche\Form\Type\ArticleType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class BlogCtrl
{
    public function indexAction(Application $app){
        $articles= $app['repository.article']->showAll();
        return $app['twig']->render('blog.twig', array("articles" => $articles));
    }

    public function createAction( Application $app)
    {
        $article = new Article();
        $form = $app['form.factory']->create(new ArticleType(),$article);
        return $app['twig']->render('blog-add.twig', array('form' => $form->createView()));
    }

    public function postAction(Request $request, Application $app)
    {
        $form = $app['form.factory']->create(new ArticleType());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $dataArticle = $form->getData();
                $article = new Article();
                $article->setArticles($dataArticle['articles']);
                $app['repository.article']->save($article);
            }
        }
        return new Response("ok");
    }
}