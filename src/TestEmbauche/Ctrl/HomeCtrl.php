<?php

namespace TestEmbauche\Ctrl;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class HomeCtrl
{
   public function indexAction(Request $request, Application $app){
       return $app['twig']->render('index.twig');
   }
}