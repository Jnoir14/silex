<?php
namespace TestEmbauche;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Silex\Application\UrlGeneratorTrait;

class TestEmbaucheApplication extends \Silex\Application
{

	protected $_configArray = array();

    public function __construct(array $options = array())
    {
        parent::__construct($options);
        if ($options['debug'] === true) {
            ini_set('display_errors', 'on');
        }
		$this->_configArray = $options;
    }

    public function registerProviders()
    {
        $app = $this;

        // session
        $app->register(new \Silex\Provider\SessionServiceProvider());

        // generateur d'url
        $app->register(new \Silex\Provider\UrlGeneratorServiceProvider());

        // twig
        $app->register(
            new \Silex\Provider\TwigServiceProvider(),
			$this->_configArray
        );

        $app->register(new \Silex\Provider\TranslationServiceProvider(), array(
            'translator.messages' => array(),
        ));

        # form
        $app->register(new \Silex\Provider\FormServiceProvider());

        //Db
        $app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver' => 'pdo_mysql',
                'dbhost' => 'localhost',
                'dbname' => 'silex',
                'user' => 'root',
                'password' => '',
            )
        ));

        // Register repositories.
        $app['repository.article'] = $app->share(function ($app) {
            return new \TestEmbauche\Repository\ArticleRepository($app['db']);
        });

        $app['repository.category'] = $app->share(function ($app) {
            return new \TestEmbauche\Repository\CategoryRepository($app['db']);
        });

        $app['repository.user'] = $app->share(function ($app) {
            return new \TestEmbauche\Repository\UserRepository($app['db'], $app['security.encoder.digest']);
        });

        $app['repository.work'] = $app->share(function ($app) {
            return new \TestEmbauche\Repository\WorkRepository($app['db']);
        });

        // Error
        $app->error(function (\Exception $e, $code) use ($app) {
            if ($app['debug']) {
                return ;
            }
            switch ($code) {
                case 404:
                    $message = 'Page non trouvé';
                    break;
                default:
                    return;
            }
            return new Response($message, $code);
        });

        // Users
        $app->register(new \Silex\Provider\SecurityServiceProvider(), array(
            'security.firewalls' => array(
                'admin' => array(
                    'pattern' => '^.*$',
                    'form' => array(
                        'login_path' => '/login',
                        'check_path' => '/admin/login_check',
                        'username_parameter' => 'form[username]',
                        'password_parameter' => 'form[password]',
                    ),
                    'logout' => array('logout_path' => '/admin/logout'),
                    'anonymous' => true,
                    'users' => $app->share(function () use ($app) {
                        return new \TestEmbauche\Repository\UserRepository($app['db'], $app['security.encoder.digest']);
                    }),
                ),
            ),
            'security.role_hierarchy' => array(
                'ROLE_ADMIN' => array('ROLE_USER'),
            ),
            'security.access_rules' => array(
                array('^/admin', 'ROLE_ADMIN')
            )
        ));

        /*
         *  Return Db table /!\ ONLY FOR DEV
         *  @parm $app
         *  @return class db
         */
        return new Db_creator($app);

    }
}
