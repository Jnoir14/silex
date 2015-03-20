<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 19/03/15
 * Time: 14:53
 */

namespace TestEmbauche;

use Doctrine\DBAL\Schema\Table;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;



class Db_creator{
    protected $db;

    public function __construct($app){
        $this->db = $app['db'];
        $this->ConstructDb($app);
    }

    public function ConstructDb($app){
        $schema = $this->db->getSchemaManager();
        if (!$schema->tablesExist('users')) {
            $users = new Table('users');
            $users->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
            $users->setPrimaryKey(array('id'));
            $users->addColumn('username', 'string', array('length' => 32));
            $users->addUniqueIndex(array('username'));
            $users->addColumn('salt', 'string', array('length' => 32));
            $users->addColumn('password', 'string', array('length' => 255));
            $users->addColumn('mail', 'string', array('length' => 32));
            $users->addColumn('role', 'string', array('length' => 255));
            $users->addColumn('created_at', 'integer', array('length' => 11));

            $schema->createTable($users);

            $app['db']->insert('users', array(
                'username' => 'admin',
                'salt' => '1260889385528018eda0a12',
                'password' => 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec',
                'mail'   =>'admin@gmail.com',
                'role' => 'ROLE_ADMIN',
                'created_at' => '1379889332'
            ));
        }

        return new Response("Db create ok");
    }
}