<?php
// DIC configuration

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $response->withJson(['status' => 'error', 'code' => 404])->withStatus(404);
    };
};

$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];

    try {
        $db = new PDO(
            "$settings[driver]:host=$settings[host];dbname=$settings[database];charset=$settings[charset]",
            $settings['username'],
            $settings['password']
        );
        $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

        return $db;

    } catch (PDOException $e) {
    }
};
