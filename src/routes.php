<?php

$app->match('/index.html','TestEmbauche\Ctrl\HomeCtrl::indexAction')->bind('homepage');
$app->match('/info','TestEmbauche\Ctrl\InfoCtrl::indexAction')->bind('infopage');

//BLOG
$app->match('/blog','TestEmbauche\Ctrl\BlogCtrl::indexAction')->bind('blogpage');
//BLOG=>ARTICLE
$app->get("/blog/create", 'TestEmbauche\Ctrl\BlogCtrl::createAction')->bind("article.create");
$app->post("/blog/post", 'TestEmbauche\Ctrl\BlogCtrl::postAction')->bind("article.post");

$app->match('/realisations','TestEmbauche\Ctrl\WorkCtrl::indexAction')->bind('workpage');
$app->match('/contact','TestEmbauche\Ctrl\ContactCtrl::indexAction')->bind('contactpage');