<?php

use Metrics\Core\Interactor\AuthenticateInteractor;
use Metrics\Core\Interactor\ShowProjectsInteractor;
use Metrics\Web\Presenter\JsonShowProjectsPresenter;
use Metrics\Web\Presenter\JsonShowVersionsPresenter;
use Metrics\Web\Repository\File\FileRepositoryFactory;
use Metrics\Web\Repository\RepositoryFactory;
use Silex\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../../../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;
$app->register(
    new Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => __DIR__,
    )
);
$app->register(new Silex\Provider\SessionServiceProvider());

$config = \Symfony\Component\Yaml\Yaml::parse(file_get_contents('../../config/application.yml'));
$superadmin = $config['user']['superadmin'];

/** @var RepositoryFactory $repositoryFactory */
$repositoryFactory = new FileRepositoryFactory('/tmp', $superadmin['name'], $superadmin['pass']);
$app->before(
    function (Request $request) use ($app, $repositoryFactory) {
        /** @var Route $route */
        $route = $app['routes']->get($request->get('_route'));
        if ($route->getPath() !== '/login') {
            $user = $app['session']->get('user');
            $authenticateInteractor = new AuthenticateInteractor($repositoryFactory->getUserRepository());
            $authenticateInteractor->execute($user['username'], $user['password']);
        }
    }
);
$app->error(
    function (\Metrics\Core\Interactor\Exception\AuthenticationRequiredException $e, $code) {
        return new Response($e->getMessage(), 401, ['X-Status-Code' => 401]);
    }
);

$app->get(
    '/',
    function () use ($app) {
        return "hallo!";
    }
);
$app->get(
    '/projects',
    function () use ($repositoryFactory) {
        $presenter = new JsonShowProjectsPresenter();
        $interactor = new ShowProjectsInteractor($repositoryFactory->getProjectRepository(), $presenter);
        return $interactor->execute();
    }
);
$app->post(
    '/login',
    function (Request $request) use ($repositoryFactory, $app) {
        $content = json_decode($request->getContent());
        $interactor = new AuthenticateInteractor($repositoryFactory->getUserRepository());
        $user = $interactor->execute($content->name, $content->password);
        $app['session']->set('user', ['username' => $user->getName(), 'password' => $user->getPassword()]);
        return new Response("", 200);
    }
);
$app->get(
    '/versions/{project}',
    function ($project) use ($repositoryFactory) {
        $presenter = new JsonShowVersionsPresenter();
        $projectRepository = $repositoryFactory->getProjectRepository();
        $versionRepository = $repositoryFactory->getVersionRepository();
        $interactor = new \Metrics\Core\Interactor\ShowVersionsInteractor(
            $versionRepository,
            $projectRepository,
            $presenter
        );

        return $interactor->execute($project);
    }
);
$app->post(
    '/projects',
    function (Request $request) use ($repositoryFactory) {
        $content = json_decode($request->getContent());
        $name = $content->name;
        $interactor = new \Metrics\Core\Interactor\AddProjectInteractor($repositoryFactory->getProjectRepository());
        $interactor->execute($name);
        return new Response('', 201);
    }
);
$app->get(
    '/metrics/file/{project}',
    function ($project) use ($repositoryFactory) {
        $projectRepository = $repositoryFactory->getProjectRepository();
        $versionRepository = $repositoryFactory->getVersionRepository();
        $fileVersionRepository = $repositoryFactory->getFileVersionRepository();
        $metricsRepository = $repositoryFactory->getMetricsRepository();
        $presenter = new \Metrics\Web\Presenter\JsonShowFileHierarchyPresenter();

        $interactor = new \Metrics\Core\Interactor\ShowFileHierarchyInteractor(
            $projectRepository,
            $versionRepository,
            $fileVersionRepository,
            $metricsRepository,
            $presenter
        );

        return $interactor->execute($project);
    }
);
$app->get(
    '/timeseries/{project}/{metric}',
    function ($project, $metric) use ($repositoryFactory) {
        $projectRepository = $repositoryFactory->getProjectRepository();
        $versionRepository = $repositoryFactory->getVersionRepository();
        $metricsRepository = $repositoryFactory->getMetricsRepository();
        $presenter = new \Metrics\Web\Presenter\JsonShowTimeSeriesPresenter();

        $interactor = new \Metrics\Core\Interactor\ShowTimeSeriesInteractor(
            $projectRepository,
            $versionRepository,
            $metricsRepository,
            $presenter
        );

        return $interactor->execute($project, $metric);
    }
);
$app->get(
    '/metrics/file/{project}/{version}',
    function ($project, $version) use ($repositoryFactory) {
        $projectRepository = $repositoryFactory->getProjectRepository();
        $versionRepository = $repositoryFactory->getVersionRepository();
        $fileVersionRepository = $repositoryFactory->getFileVersionRepository();
        $metricsRepository = $repositoryFactory->getMetricsRepository();
        $presenter = new \Metrics\Web\Presenter\JsonShowFileHierarchyPresenter();

        $interactor = new \Metrics\Core\Interactor\ShowFileHierarchyInteractor(
            $projectRepository,
            $versionRepository,
            $fileVersionRepository,
            $metricsRepository,
            $presenter
        );

        return $interactor->execute($project, $version);
    }
);
$app->post(
    '/material/{project}/{version}/{materialType}',
    function (Request $request, $project, $version, $materialType) use ($repositoryFactory) {
        if ($request->get('material')) {
            $material = $request->get('material');
        } elseif ($request->files->count() > 0) {
            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $request->files->all()['file'];
            $file->move('/tmp', 'materialupload');
            $material = file_get_contents('/tmp/materialupload');
            unlink('/tmp/materialupload');
        }

        $fileRepository = $repositoryFactory->getFileRepository();
        $fileVersionRepository = $repositoryFactory->getFileVersionRepository();
        $metricsRepository = $repositoryFactory->getMetricsRepository();
        $projectRepository = $repositoryFactory->getProjectRepository();
        $versionRepository = $repositoryFactory->getVersionRepository();

        $interactor = new \Metrics\Core\Interactor\AddMaterialInteractor(
            $fileRepository,
            $fileVersionRepository,
            $metricsRepository,
            $projectRepository,
            $versionRepository
        );
        $interactor->execute($project, $version, $materialType, $material);
        return new Response('', 201);
    }
);

$app->run();
