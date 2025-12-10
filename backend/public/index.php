<?php

declare(strict_types=1);

use Factories\RepositoryFactory;
use Factories\ServiceFactory;
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
use Symfony\Component\Yaml\Yaml;

require_once '../vendor/autoload.php';
require '../src/Database.php';
require '../src/Container.php';

$container = new Container();

$container->set(Database::class, function ()  {
    $config = Yaml::parseFile('../config/config.yaml');
    $db_config = $config['database'];

    return new Database(
        $db_config['host'],
        $db_config['user'],
        $db_config['pass'],
        $db_config['db'],
    );
});

$db     = $container->get(Database::class);
$mysqli = $db->getConnection();

$repoFactory = new RepositoryFactory($mysqli);
$serviceFactory = new ServiceFactory($container);

$repositories = [
    ArticleRepository::class,
    CommentRepository::class,
    AuthRepository::class,
];

foreach ($repositories as $repoClass) {
    $container->set($repoClass, function () use ($repoClass, $repoFactory) {
        return $repoFactory->create($repoClass);
    });
}

$services = [
    ArticleService::class => ArticleRepository::class,
    CommentService::class => CommentRepository::class,
    AuthService::class => AuthRepository::class,
];

foreach ($services as $serviceClass => $dependencyClass) {
    $container->set($serviceClass, function () use ($serviceClass, $dependencyClass, $serviceFactory) {
        return $serviceFactory->create($serviceClass, $dependencyClass);
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
