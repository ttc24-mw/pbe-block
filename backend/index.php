<?php

declare(strict_types=1);

use Framework\Router;
use Controllers\GetSingleArticleController;
use Controllers\GetAllArticlesController;
use Controllers\PostArticleController;
use Controllers\LoginController;
use Controllers\LogoutController;
use Controllers\GetAllCommentsController;
use Controllers\DeleteCommentController;
use Controllers\PostCommentController;
use Repositories\ArticleRepository;
use Repositories\CommentRepository;
use Repositories\AuthRepository;
use Services\ArticleService;
use Services\AuthService;
use Services\CommentService;

require 'src/Autoloader.php';
require 'src/Database.php';
require 'src/Container.php';

Autoloader::register();

$container = new Container();

$container->set(Database::class, function(){
                    return new Database('localhost',
                                        'root',
                                        'root',
                                        'blog_app');
                });

$db     = $container->get(Database::class);
$mysqli = $db->getConnection();

$repositories = [
    ArticleRepository::class => $mysqli,
    CommentRepository::class => $mysqli,
    AuthRepository::class => $mysqli,
];

$services = [
    ArticleService::class => ArticleRepository::class,
    CommentService::class => CommentRepository::class,
    AuthService::class => AuthRepository::class,
];

foreach ($repositories as $repoClass => $mysqliInstance) {
    $container->set($repoClass, function() use ($mysqliInstance, $repoClass) {
        return new $repoClass($mysqliInstance);
    });
}

foreach ($services as $serviceClass => $dependencyClass) {
    $container->set($serviceClass, function() use ($container, $dependencyClass, $serviceClass) {
        $dependencyInstance = $container->get($dependencyClass);
        return new $serviceClass($dependencyInstance);
    });
}

$articleService = $container->get(ArticleService::class);
$commentService = $container->get(CommentService::class);
$authService = $container->get(AuthService::class);

$router = $container->get(Router::class);

$router->add('getArticles', GetAllArticlesController::class, 'GET', $articleService);
$router->add('getArticle', GetSingleArticleController::class, 'GET', $articleService);
$router->add('postArticle', PostArticleController::class, 'POST', $articleService);
$router->add('getComments', GetAllCommentsController::class, 'GET', $commentService);
$router->add('deleteComment', DeleteCommentController::class, 'DELETE', $commentService);
$router->add('postComment', PostCommentController::class, 'POST', $commentService);
$router->add('login', LoginController::class, 'POST', $authService);
$router->add('logout', LogoutController::class, 'POST', $authService);

run($router);

function run($router)
{
    return $router->dispatch();
}
