<?php

namespace App\Services;

use Slim\Http\Request;
use Respect\Validation\Validator as v;

use App\Models\Page;

class PagesService {

    private $page;
    private $request;
    private $args;
    private $type;

    public function __construct(Page &$page, Request &$request, array &$args) {
        $this->page = &$page;
        $this->request = $request;
        $this->args = $args;

        $type = explode('/', $request->getUri()->getPath())[1];
        $this->type = preg_replace('/s$/', '', $type);;
        $page->type = $this->type;
    }

    public function index(): array {
        $params = $this->params();

        if ($params && $params[0] === 'slug') {
            $this->_show($params[0], $params[1]);

        } else {
            if ($params && $params[0] === 'user_id')
                $this->page->user_id = $params[1];

            $this->page->setRowsPerPage(8);
            $this->page->index();
        }

        return $this->page->toArray();
    }

    public function show(): array {
        $idValidator = v::numeric()->positive();

        if ($idValidator->validate($this->args['id']))
            $this->_show('id', $this->args['id']);
        else
            throw new \Exception('Not Found', 404);

        return $this->page->toArray();
    }

    private function _show($col, $row) {
        $this->page->$col = $row;
        $this->page->show($col);
    }

    private function params() {
        $params = $this->request->getQueryParams();

        foreach ($params as $key => $value) {
            if ($key === 'slug') {
                $slugValidator = v::slug();

                if ($slugValidator->validate($value))
                    return [$key, $value];

            } elseif ($key === 'user_id') {
                $idValidator = v::numeric()->positive();

                if ($idValidator->validate($value))
                    return [$key, $value];
            }
        }

        return false;
    }
}