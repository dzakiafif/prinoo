<?php
/**
 * Created by PhpStorm.
 * User: dzaki
 * Date: 09/03/17
 * Time: 15:45
 */

$loader = require __DIR__ . '/../vendor/autoload.php';

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$config = require __DIR__ . '/../app/config.php';

$app = new \Silex\Application($config['common']);

require 'bootstrap.php';

$app->mount('/', new \Komal\prinoo\Http\Controller\ClientController($app));
$app->mount('/admin', new \Komal\prinoo\Http\Controller\AdminController($app));
//$app->mount('/admin/user', new \Jimmy\fifo\Http\Controller\UserController($app));

//$app->get('/logout', function () use ($app) {
//    $app['session']->clear();
//    return $app->redirect($app['url_generator']->generate('homeClient'));
//})->bind('logout');

$app->run();