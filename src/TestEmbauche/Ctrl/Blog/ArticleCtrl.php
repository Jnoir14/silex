<?php

namespace TestEmbauche\Ctrl\Blog;

use TestEmbauche\Model\Article;
use TestEmbauche\Form\Type\ArticleType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;



class ArticleCtrl
{

    /* showAction
     *  Affiche le l'article
     */
    public function showAction( Application $app, $id)
    {
        $article= $app['repository.article']->getById($id);
        return $app['twig']->render('blog-article-show.twig', array('article' => $article));
    }
    /*
     *  createAction
     *  Creation du formulaire Template
     */
    public function createAction( Application $app)
    {
        $article = new Article();
        $articles= $app['repository.category']->getAll();
        $form = $app['form.factory']->create(new ArticleType(), $article, array('data' => $articles));
        return $app['twig']->render('blog-add.twig', array('form' => $form->createView()));
    }

    /*
     *
     */
    public function postAction(Request $request, Application $app)
    {
        $article = new Article();
        $articles= $app['repository.category']->getAll();
        $form = $app['form.factory']->create(new ArticleType(), $article, array('data' => $articles));
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $dataArticle = $form->getData();
                $article->setTitle($dataArticle['title']);
                $article->setContent($dataArticle['content']);
                $article->setCategory($dataArticle['category']);
                $app['repository.article']->save($article);
            }
        }
        return $app['url_generator']->generate('blog');
    }

    /*
     *
     */
    public function deleteAction( Application $app, $id)
    {
        $app['repository.article']->delete();
        return $app['url_generator']->generate('blog');
    }
}