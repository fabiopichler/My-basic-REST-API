<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

abstract class Controller {

    protected $container;

    public function __construct($container) {
        $this->container = $container;
        $this->notFoundHandler = $container->notFoundHandler;
    }

    protected function model(string $class) {
        return new $class($this->container->db);
    }

    protected function error($code, Request &$request, Response &$response) {
        if ($code === 404)
            return ($this->notFoundHandler)($request, $response);

        return $response->withJson(['status' => 'error'])->withStatus(500);
    }
}
