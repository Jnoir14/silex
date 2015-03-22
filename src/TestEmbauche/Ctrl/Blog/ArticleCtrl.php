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
    public function addAction(Request $request, Application $app)
    {
        $category= $app['repository.category']->getAll();
        // Pas top :(
        $data= array();
        foreach ($category as $dataRows){
            $data +=array($dataRows['id'] => $dataRows['name']);
        }
        $article =  new Article();
        $form = $app['form.factory']->create(new ArticleType(), $article, array('data'=>$data));
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $dataArticle = $form->getData();
                $article->setTitle($dataArticle['title']);
                $article->setContent($dataArticle['content']);
                $article->setCategory($dataArticle['category']);
                $app['repository.article']->save($article);
                return $app->redirect($app['url_generator']->generate('blog'));
            }
        }
        return $app['twig']->render('Blog/Article/blog-article-add.twig', array('form' => $form->createView()));
    }
    

    /*
     *
     */
    public function deleteAction( Application $app, $id)
    {
        $app['repository.article']->delete($id);
        return $app->redirect($app['url_generator']->generate('blog'));
    }
}