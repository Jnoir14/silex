<?php

$app->match('/index.html','TestEmbauche\Ctrl\HomeCtrl::indexAction')->bind('homepage');
$app->match('/info','TestEmbauche\Ctrl\InfoCtrl::indexAction')->bind('infopage');

//BLOG
$app->match('/blog','TestEmbauche\Ctrl\Blog\BlogCtrl::indexAction')->bind('blog');
//BLOG=>ARTICLE
$app->get("/blog/article/add", 'TestEmbauche\Ctrl\Blog\ArticleCtrl::newAction')->bind("blog.article.create");
$app->post("/blog/article/post", 'TestEmbauche\Ctrl\Blog\ArticleCtrl::postAction')->bind("blog.article.post");
$app->get("/blog/article/show/{id}", 'TestEmbauche\Ctrl\Blog\ArticleCtrl::showAction')->bind("blog.article.show");
$app->get("/blog/article/delete/{id}", 'TestEmbauche\Ctrl\Blog\ArticleCtrl::deleteAction')->bind("blog.article.delete");
//BLOG=>CATEGORY
$app->get("/blog/category/create", 'TestEmbauche\Ctrl\Blog\CategoryCtrl::createAction')->bind("blog.category.create");
$app->post("/blog/category/post", 'TestEmbauche\Ctrl\Blog\CategoryCtrl::postAction')->bind("blog.category.post");

$app->match('/realisations','TestEmbauche\Ctrl\WorkCtrl::indexAction')->bind('workpage');
$app->match('/contact','TestEmbauche\Ctrl\ContactCtrl::indexAction')->bind('contactpage');