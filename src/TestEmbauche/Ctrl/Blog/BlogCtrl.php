<?php

namespace TestEmbauche\Ctrl\Blog;

use Silex\Application;



class BlogCtrl
{
    public function indexAction(Application $app)
    {
        $articles = $app['repository.article']->getAll();
        return $app['twig']->render('/Blog/index.twig', array("articles" => $articles));
    }
}