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
    }
}
