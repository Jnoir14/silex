<?php

namespace TestEmbauche\Ctrl;

use Silex\Application;



class AdminCtrl
{
    public function indexAction(Application $app)
    {
        return $app['twig']->render('/user/admin-index.twig');
    }
}