<?php

namespace TestEmbauche\Ctrl;

use Silex\Application;
use TestEmbauche\Model\Work;
use TestEmbauche\Form\Type\WorkType;
use Symfony\Component\HttpFoundation\Request;


class WorkCtrl
{
    public function indexAction(Application $app){
        $works = $app['repository.work']->getAll();
       return $app['twig']->render('Work/work.twig', array('works' => $works));
    }

    /* showAction
     *  Affiche la réa
     */
    public function showAction( Application $app, $id)
    {
        $work= $app['repository.work']->getById($id);
        return $app['twig']->render('Work/work-show.twig', array('work' => $work));
    }
    /*
     *  createAction
     *  Creation du formulaire Template
     */
    public function addAction(Request $request, Application $app)
    {
        $works = new Work();
        $form   = $form = $app['form.factory']->create(new WorkType(), $works);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.work']->save($works);
                return $app->redirect($app['url_generator']->generate('workpage'));
            }
        }
        return $app['twig']->render('Work/work-add.twig', array('form' => $form->createView()));
    }

    public function editAction(Request $request, Application $app, $id)
    {

        $work = $app['repository.work']->getById($id);
        $form = $app['form.factory']->create(new WorkType(), $work);

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $app['repository.work']->save($work);
                return $app->redirect($app['url_generator']->generate('workpage'));
            }
        }
        $data = array(
            'form' => $form->createView()
        );
        return $app['twig']->render('Work/work-edit.twig', $data);
    }

    /*
     *
     */
    public function deleteAction( Application $app, $id)
    {
        $app['repository.work']->delete();
        return $app->redirect($app['url_generator']->generate('workpage'));
    }

}