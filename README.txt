~~Install~~
=> Créer un vhost et config pour utiliser le site en local
=> /!\ Créer un config.inc.sample.php sous la forme de
---------------------------------------------------------------------------
return array(
    'twig'  => array('twig.path' => __DIR__.'/src/TestEmbauche/templates'),
    'debug' => true,
    'password' => 'MDP',
);
---------------------------------------------------------------------------
=> /!\ Créer une base de données en UTF8 nomée "silex"

=> Silex/ Route index site & /admin/ + @parm pour l'admin
=> Verifier la db générer par Db_creator.php
=> Enfin si le fonctionement du site est defaillant prendre une Version plus
stable dans un commit plus ancien
