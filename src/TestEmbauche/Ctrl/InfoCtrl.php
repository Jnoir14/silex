<?php

namespace TestEmbauche\Ctrl;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class InfoCtrl
{
   public function indexAction(Request $request, Application $app){
       return $app['twig']->render('info.twig');
   }
}