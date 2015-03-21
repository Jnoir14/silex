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
    /*
     * Pas de showById
     * Non pertinant
     */

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

    /*
 *
 */
    public function deleteAction( Application $app, $id)
    {
        $app['repository.category']->delete();
        return $app->redirect($app['url_generator']->generate('blog'));
    }
}