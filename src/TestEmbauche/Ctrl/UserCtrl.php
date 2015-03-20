<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 19/03/15
 * Time: 16:00
 */

namespace TestEmbauche\Ctrl;

use TestEmbauche\Model\User;
use TestEmbauche\Form\Type\UserType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;


class UserCtrl {
    public function addAction(Request $request, Application $app)
    {
        $user = new User();
        $form = $app['form.factory']->create(new UserType(), $user);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.user']->save($user);
                $message = 'The user ' . $user->getUsername() . ' has been saved.';
                $app['session']->getFlashBag()->add('success', $message);
                // Redirect to the edit page.
                $redirect = $app['url_generator']->generate('homepage');
                return $app->redirect($redirect);
            }
        }

        $data = array(
            'form' => $form->createView(),
            'title' => 'Add new user',
        );
        return $app['twig']->render('/User/user-add.twig', $data);
    }

    public function loginAction(Request $request, Application $app)
    {
        $form = $app['form.factory']->createBuilder('form')
            ->add('username', 'text', array('label' => 'Username', 'data' => $app['session']->get('_security.last_username')))
            ->add('password', 'password', array('label' => 'Password'))
            ->add('login', 'submit')
            ->getForm();

        $data = array(
            'form'  => $form->createView(),
            'error' => $app['security.last_error']($request),
        );
        return $app['twig']->render('login.twig', $data);
    }

    public function logoutAction(Request $request, Application $app)
    {
        $data = $request;
        $app['session']->clear();
        return $app->redirect($app['url_generator']->generate('homepage'));
    }
} 