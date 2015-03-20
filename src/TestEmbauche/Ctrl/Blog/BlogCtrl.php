<?php

namespace TestEmbauche\Ctrl\Blog;

use Silex\Application;



class BlogCtrl
{
    public function indexAction(Application $app)
    {
        $articles = $app['repository.article']->getAll();
        $token = $app['session'];
        var_dump($token);
        die();
        if (null !== $token) {
            $user = $token->getUser();
        }
        return $app['twig']->render('/Blog/index.twig', array("articles" => $articles));
    }
}