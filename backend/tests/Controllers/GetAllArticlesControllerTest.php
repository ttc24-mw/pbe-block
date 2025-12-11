<?php

use PHPUnit\Framework\TestCase;
use Controllers\GetAllArticlesController;
use Repositories\ArticleRepository;
use Services\ArticleService;
use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../src/Container.php';
require __DIR__ . '/../../src/Database.php';

class GetAllArticlesControllerTest extends TestCase
{
    private $container;

    protected function setUp(): void
    {
        $this->container = new Container();

        $this->container->set(Database::class, function () {
            $config = Yaml::parseFile(__DIR__ . '/../../config/config.yaml');
            $db_config = $config['database'];

            return new Database(
                $db_config['host'],
                $db_config['user'],
                $db_config['pass'],
                $db_config['db'],
                $db_config['port'],
            );
        });
    }

    public function testGetAllRealArticles()
    {
        $db = $this->container->get(Database::class);
        $mysqli = $db->getConnection();

        $articleRepo = new ArticleRepository($mysqli);
        $articleService = new ArticleService($articleRepo);
        $controller = new GetAllArticlesController($articleService);

        $GLOBALS['queryParams'] = ['page' => '1'];

        ob_start();
        $controller->handle();
        $output = ob_get_clean();

        $responseData = json_decode($output, true);

        $this->assertIsArray($responseData, 'Response is not a valid JSON array');

        $this->assertCount(3, $responseData['articles']);
        $this->assertEquals(1, $responseData['currentPage']);
    }
}
