<?php

declare(strict_types=1);

use Controllers\ArticleController;
use Controllers\AuthController;
use Controllers\CommentController;
use Models\ArticleModel;
use Models\AuthModel;
use Models\CommentModel;

require_once 'db.php';
require_once 'models/ArticleModel.php';
require_once 'models/CommentModel.php';
require_once 'models/AuthModel.php';
require_once 'controllers/ArticleController.php';
require_once 'controllers/CommentController.php';
require_once 'controllers/AuthController.php';

$articleModel = new ArticleModel($mysqli);
$articleController = new ArticleController($articleModel);

$commentModel = new CommentModel($mysqli);
$commentController = new CommentController($commentModel);

$authModel = new AuthModel($mysqli);
$authController = new AuthController($authModel);

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getArticles':
        $articlesPerPage = 3;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $articlesPerPage;

        $totalArticles = $articleModel->getTotalArticlesCount();
        $totalPages = ceil($totalArticles / $articlesPerPage);

        $articles = $articleController->getAllArticles($articlesPerPage, $offset);

        $response = [
            'articles' => $articles,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];

        echo json_encode($response);
        break;

    case 'getArticle':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 1;

        $article = $articleController->getArticleById($id);

        echo json_encode($article);
        break;

    case 'postArticle':
        $input = json_decode(file_get_contents('php://input'), true);

        $title = $input['title'];
        $content = $input['text'];
        $url = $input['url'];

        $articleController->postArticle($title, $content, $url);
        break;

    case 'getComments':
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 1;

        $comments = $commentController->getComments($id);

        echo json_encode($comments);
        break;

    case 'deleteComment':
        $commentId = (int) $_GET['commentId'];
        $commentController->deleteComment($commentId);
        break;

    case 'postComment':
        $input = json_decode(file_get_contents('php://input'), true);

        $article_id = $input['articleId'];
        $name = $input['name'];
        $email = $input['email'];
        $url = $input['url'];
        $comment_text = $input['commentText'];

        $commentController->postComment($article_id, $name, $email, $url, $comment_text);
        break;

    case 'login':
        $input = json_decode(file_get_contents('php://input'), true);

        if ($input && isset($input['username']) && isset($input['password'])) {
            $username = $input['username'];
            $password = $input['password'];

            $authController->login($username, $password);
        }
        break;

    case 'logout':
        $authController->logout();
        break;

    default:
        'Welcome to the Blog!';
        break;
}
