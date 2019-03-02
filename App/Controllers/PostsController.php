<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Respect\Validation\Validator as v;

use App\Controllers\Controller;
use App\Models\Post;

class PostsController extends Controller {

    public function index(Request $request, Response $response) {
        $post = $this->model(Post::class);
        $post->setRowsPerPage(8);

        try {
            $post->index();
            return $response->withJson($post->toArray());

        } catch (\Exception $e) { }

        return $response->withJson(['status' => 'empty'])->withStatus(204);
    }

    public function indexByType(Request $request, Response $response, array $args) {
        $typeValidator = v::alpha()->lowercase();

        if ($typeValidator->validate($args['type'])) {
            $post = $this->model(Post::class);
            $post->type = $args['type'];
            $post->setRowsPerPage(8);

            try {
                $post->indexByType();
                return $response->withJson($post->toArray());

            } catch (\Exception $e) { }
        }
        return ($this->notFoundHandler)($request, $response);
    }

    public function show(Request $request, Response $response, array $args) {
        $idValidator = v::numeric()->positive();

        if ($idValidator->validate($args['id'])) {
            $post = $this->model(Post::class);
            $post->id = $args['id'];

            try {
                $post->show();
                return $response->withJson($post->toArray());

            } catch (\Exception $e) { }
        }

        return ($this->notFoundHandler)($request, $response);
    }

    public function showBySlug(Request $request, Response $response, array $args) {
        $slugValidator = v::slug();

        if ($slugValidator->validate($args['slug'])) {
            $post = $this->model(Post::class);
            $post->slug = $args['slug'];

            try {
                $post->showBySlug();
                return $response->withJson($post->toArray());

            } catch (\Exception $e) { }
        }

        return ($this->notFoundHandler)($request, $response);
    }
}