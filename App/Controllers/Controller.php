<?php

namespace App\Controllers;

abstract class Controller {

    protected $container;

    public function __construct($container) {
        $this->container = $container;
        $this->notFoundHandler = $container->notFoundHandler;
    }

    protected function model(string $class) {
        return new $class($this->container->db);
    }
}
