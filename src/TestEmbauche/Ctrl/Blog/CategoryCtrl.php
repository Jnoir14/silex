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

    public function createAction( Application $app)
    {
        $category = new Category();
        $form = $app['form.factory']->create(new CategoryType(),$category);
        return $app['twig']->render('Blog/Category/blog-add-category.twig', array('form' => $form->createView()));
    }

    public function postAction(Request $request, Application $app)
    {
        $form = $app['form.factory']->create(new CategoryType());
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $dataCategory = $form->getData();
                $category =  new Category();
                $category->setName($dataCategory['name']);
                $app['repository.category']->save($category);
            }
        }
        return $app['url_generator']->generate('blog');
    }

    /*
 *
 */
    public function deleteAction( Application $app, $id)
    {
        $app['repository.category']->delete();
        return $app['url_generator']->generate('blog');
    }
}