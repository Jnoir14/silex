<?php

namespace TestEmbauche\Ctrl\Blog;

use TestEmbauche\Model\Article;
use TestEmbauche\Form\Type\ArticleType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;



class ArticleCtrl
{

    /*
     * Montre l'article sectionner
     * @parm   Id
     * @return $app['repository.article']->getById($id),
     * render twig page show (blog-article-show)
     */
    public function showAction( Application $app, $id)
    {
        $article= $app['repository.article']->getById($id);
        return $app['twig']->render('Blog/Article/blog-show-article.twig', array('article' => $article));
    }

    /*
     * Ajoute un article
     * @parm   post[form]
     * @return $app['repository.article']->save(), render twig (blog-article-add)
     */
    public function addAction(Request $request, Application $app)
    {
        $category= $app['repository.category']->getAll();
        $article =  new Article($category);
        $form = $app['form.factory']->create(new ArticleType(), $article);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.article']->save($article);
                return $app->redirect($app['url_generator']->generate('blog'));
            }
        }
        return $app['twig']->render('Blog/Article/blog-add-article.twig', array('form' => $form->createView()));
    }

    /*
     * Editer un article
     * @parm   post[form], $id
     * @return $app['repository.article']->save(), render twig (blog-edit)
     */
    public function editAction(Request $request, Application $app, $id)
    {

        $category = array('category_all' => $app['repository.category']->getAll());
        $article = $app['repository.article']->getById($id);
        $article->setCategoryAll($category);
        $form = $app['form.factory']->create(new ArticleType(), $article);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.article']->save($article);
                return $app->redirect($app['url_generator']->generate('blog'));
            }
        }

        $data = array(
            'form' => $form->createView()
        );
        return $app['twig']->render('/Blog/Article/blog-edit-article.twig', $data);
    }


    /*
     * Suppr un article
     * @parm    $id
     * @return $app['repository.article']->delete($id), redirect (blog)
     */
    public function deleteAction( Application $app, $id)
    {
        $app['repository.article']->delete($id);
        return $app->redirect($app['url_generator']->generate('blog'));
    }
}