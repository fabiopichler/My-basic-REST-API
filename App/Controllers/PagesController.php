<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

use App\Controllers\Controller;
use App\Services\PagesService;
use App\Models\Page;

class PagesController extends Controller {

    public function index(Request $request, Response $response, array $args) {
        $page = $this->model(Page::class);
        $service = new PagesService($page, $request, $args);

        try {
            return $response->withJson($service->index());

        } catch (\Exception $e) {
            return $this->error($e->getCode(), $request, $response);
        }
    }

    public function show(Request $request, Response $response, array $args) {
        $page = $this->model(Page::class);
        $service = new PagesService($page, $request, $args);

        try {
            return $response->withJson($service->show());

        } catch (\Exception $e) {
            return $this->error($e->getCode(), $request, $response);
        }
    }
}
