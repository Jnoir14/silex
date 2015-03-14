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

        // Error
        $app->error(function (\Exception $e, $code) use ($app) {
            if ($app['debug']) {
                return new Response("jkjk");
            }
            switch ($code) {
                case 404:
                    $message = 'Page non trouvé';
                    break;
                default:
                    $message = 'Erreur iconnue';
            }
            return new Response($message, $code);
        });
    }

    public function registerRoutes()
    {
        $app = $this;
        $app->match('/home','TestEmbauche\Ctrl\HomeCtrl::indexAction')->bind('homepage');
        $app->match('/info','TestEmbauche\Ctrl\InfoCtrl::indexAction')->bind('infopage');
        $app->match('/blog','TestEmbauche\Ctrl\BlogCtrl::indexAction')->bind('blogpage');
        $app->get('/blog/add','TestEmbauche\Ctrl\BlogCtrl::addAction')->bind('blog_addpage');
        $app->match('/realisations','TestEmbauche\Ctrl\WorkCtrl::indexAction')->bind('workpage');
        $app->match('/contact','TestEmbauche\Ctrl\ContactCtrl::indexAction')->bind('contactpage');
    }

}