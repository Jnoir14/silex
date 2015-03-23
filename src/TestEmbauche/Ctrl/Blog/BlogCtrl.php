<?php

namespace TestEmbauche\Ctrl\Blog;

use Silex\Application;



class BlogCtrl
{
    public function indexAction(Application $app)
    {

        $articles = $app['repository.article']->getAll();
        for ($i = 0 ;$i < count($articles);$i++ ){
            $categoryData = $app['repository.category']->getById($articles[$i]["category_id"]);
            $articles[$i]["category_id"] = $categoryData;
        }
        return $app['twig']->render('/Blog/index.twig', array("articles" => $articles ));
    }
}