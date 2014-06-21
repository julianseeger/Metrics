<?php

use Metrics\Core\Interactor\ShowProjectsInteractor;
use Metrics\Web\Presenter\JsonShowProjectsPresenter;
use Metrics\Web\Repository\File\FileRepositoryFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../../../vendor/autoload.php';

$app = new Silex\Application();
$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => __DIR__,
    )
);

$repositoryFactory = new FileRepositoryFactory('/tmp');
$app->get(
    '/',
    function () use ($app) {
        return "hallo!";
    }
);
$app->get('/projects', function () use ($repositoryFactory) {
        $presenter = new JsonShowProjectsPresenter();
        $interactor = new ShowProjectsInteractor($repositoryFactory->getProjectRepository(), $presenter);
        return $interactor->execute();
    }
);
$app->post('/projects', function(Request $request) use ($repositoryFactory) {
        $name = $request->get('name');
        $interactor = new \Metrics\Core\Interactor\AddProjectInteractor($repositoryFactory->getProjectRepository());
        $interactor->execute($name);
        return new Response('', 201);
    }
);

$app->run();
