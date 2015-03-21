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
                'salt' => '740921876550bfb58c38c7',
                'password' => 'BCKy17YZwdTYXE67stbIqMce15bgsrIKtdpiJEScZlT3BcS5glZYTXUHf5z1p6PxCSC0kijV9cU/Jfo09b5YuQ==',
                'mail'   =>'admin@gmail.com',
                'role' => 'ROLE_ADMIN',
                'created_at' => '1379889332'
            ));
        }

        if (!$schema->tablesExist('works')) {
            $works = new Table('works');
            $works->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
            $works->setPrimaryKey(array('id'));
            $works->addColumn('title', 'string', array('length' => 32));
            $works->addColumn('content', 'string', array('length' => 255));
            $works->addColumn('image_path', 'string', array('length' => 32));
            $works->addColumn('created_at', 'integer', array('length' => 11));

            $schema->createTable($works);
        }

        return new Response("Db create ok");
    }
}