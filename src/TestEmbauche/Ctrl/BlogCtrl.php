<?php

namespace TestEmbauche\Ctrl;

use TestEmbauche\Models\Comment;
use TestEmbauche\Form\Type\CommentType;
use Silex\Application;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;


class BlogCtrl
{
    public function indexAction(Request $request, Application $app){
        return $app['twig']->render('blog.twig');
    }

    public function addAction(Request $request, Application $app)
    {
        $comment = new Comment();
        $form = $app['form.factory']->create(new CommentType(), $comment);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.comment']->save($comment);
                return $app->redirect("blogpage");
            }
        }

        $data = array(
            'form' => $form->createView(),
            'title' => 'Add new user',
        );
        return $app['twig']->render('blog-add.twig', $data);
    }
}