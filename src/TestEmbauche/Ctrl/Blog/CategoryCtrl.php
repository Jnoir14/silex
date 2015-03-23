<?php

namespace TestEmbauche\Ctrl\Blog;

use TestEmbauche\Form\Type\CategoryType;
use TestEmbauche\Model\Category;
use TestEmbauche\Form\Type\ArticleType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class CategoryCtrl
{
    public function showAction( Application $app, $id)
    {
        $category = $app['repository.category']->getById($id);
        $articles = $app['repository.article']->getByCategory($id);
        return $app['twig']->render('Blog/Category/blog-show-category.twig', array('category' => $category, "articles" => $articles));
    }

    public function addAction(Request $request, Application $app)
    {
        $category =  new Category();
        $form = $app['form.factory']->create(new CategoryType(), $category);
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.category']->save($category);
                return $app->redirect($app['url_generator']->generate('blog'));
            }
        }
        return $app['twig']->render('Blog/Category/blog-add-category.twig', array('form' => $form->createView()));
    }

    public function editAction(Request $request, Application $app, $id)
    {

        $category = $app['repository.category']->getById($id);
        $form = $app['form.factory']->create(new CategoryType(), $category);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.category']->save($category);
                return $app->redirect($app['url_generator']->generate('blog'));
            }
        }
        $data = array(
            'form' => $form->createView()
        );
        return $app['twig']->render('/Blog/Category/blog-edit-category.twig', $data);
    }

    /*
     *
     */
    public function deleteAction( Application $app, $id)
    {
        $app['repository.category']->delete();
        return $app->redirect($app['url_generator']->generate('blog'));
    }
}