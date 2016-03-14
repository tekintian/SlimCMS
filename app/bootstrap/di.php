<?php

// Register service provider
$container['cache'] = function () {
    return new \Slim\HttpCache\CacheProvider();
};

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

$container['flashMess'] = function () use ($container) {
    return $container['flash']->getMessages();
};

$container['view'] = function ($c) use ($config) {
    $view = new \Slim\Views\Twig($config['view']['template_path'], $config['view']['twig']);

    // Instantiate and add Slim specific extension
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        $heandler = new App\Controllers\Sites\UniversalPageController($c);
        return $heandler->notFound($request, $response)->withStatus(404);
    };
};

/*$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['view']->render($response, 'public/main/pages/404.twig')->withStatus(404);
    };
};*/