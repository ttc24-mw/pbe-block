<?php

declare(strict_types=1);

use Factories\RepositoryFactory;
use Framework\Dispatcher;
use Controllers\GetSingleArticleController;
use Controllers\GetAllArticlesController;
use Controllers\PostArticleController;
use Controllers\LoginController;
use Controllers\LogoutController;
use Controllers\GetAllCommentsController;
use Controllers\DeleteCommentController;
use Controllers\PostCommentController;
use QueryHandlers\GetAllArticlesHandler;
use QueryHandlers\GetCommentsHandler;
use QueryHandlers\GetSingleArticleHandler;
use CommandHandlers\PostArticleHandler;
use CommandHandlers\DeleteCommentHandler;
use CommandHandlers\PostCommentHandler;
use CommandHandlers\LoginUserHandler;
use CommandHandlers\LogoutUserHandler;
use Repositories\ArticleRepository;
use Repositories\CommentRepository;
use Repositories\AuthRepository;
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
        $db_config['port'],
    );
});

$db     = $container->get(Database::class);
$mysqli = $db->getConnection();

$repoFactory = new RepositoryFactory($mysqli);

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

$getAllArticlesHandler   = $container->get(GetAllArticlesHandler::class);
$getSingleArticleHandler = $container->get(GetSingleArticleHandler::class);
$postArticleHandler      = $container->get(PostArticleHandler::class);
$getCommentsHandler      = $container->get(GetCommentsHandler::class);
$postCommentHandler      = $container->get(PostCommentHandler::class);
$deleteCommentHandler    = $container->get(DeleteCommentHandler::class);
$loginUserHandler        = $container->get(LoginUserHandler::class);
$logoutUserHandler       = $container->get(LogoutUserHandler::class);

$dispatcher = $container->get(Dispatcher::class);

$dispatcher->add('getArticles', GetAllArticlesController::class, 'GET', $getAllArticlesHandler);
$dispatcher->add('getArticle', GetSingleArticleController::class, 'GET', $getSingleArticleHandler);
$dispatcher->add('postArticle', PostArticleController::class, 'POST', $postArticleHandler);
$dispatcher->add('getComments', GetAllCommentsController::class, 'GET', $getCommentsHandler);
$dispatcher->add('deleteComment', DeleteCommentController::class, 'DELETE', $deleteCommentHandler);
$dispatcher->add('postComment', PostCommentController::class, 'POST', $postCommentHandler);
$dispatcher->add('login', LoginController::class, 'POST', $loginUserHandler);
$dispatcher->add('logout', LogoutController::class, 'POST', $logoutUserHandler);

run($dispatcher);

function run($dispatcher)
{
    return $dispatcher->dispatch();
}
