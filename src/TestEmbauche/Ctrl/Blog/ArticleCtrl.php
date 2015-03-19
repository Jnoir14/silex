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
        return $app['twig']->render('Blog/Article/blog-article-show.twig', array('article' => $article));
    }
    /*
     *  createAction
     *  Creation du formulaire Template
     */
    public function newAction( Application $app)
    {
        $article = new Article();
        $form   = $this->createCreateForm($app,$article);
        return $app['twig']->render('Blog/Article/blog-article-add.twig', array('form' => $form->createView()));
    }

    public function createCreateForm(Application $app, $article){
        $articles= $app['repository.category']->getAll();
        $form = $app['form.factory']->create(new ArticleType(), $article, array('data' => $articles));
        return $form;
    }

    /*
     *
     */
    public function postAction(Request $request, Application $app)
    {
        $article = new Article();
        $form   = $this->createCreateForm($app,$article);
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