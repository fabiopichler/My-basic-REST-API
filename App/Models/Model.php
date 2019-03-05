<?php

namespace App\Models;

abstract class Model {

    protected $db;

    private $data = [];
    private $rowsPerPage = 5;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function __get(string $key) {
        return $this->data[$key] ?? null;
    }

    public function __set(string $key, $value) {
        $this->data[$key] = $value;
    }

    public function setRowsPerPage(int $rows) {
        $this->rowsPerPage = $rows;
    }

    public function toArray(): array {
        return $this->data;
    }

    protected function setData($data) {
        if (empty($data) || !is_array($data))
            throw new \Exception('Not Found', 404);

        $this->data = $data;
    }

    protected function paginate(string $query, string $order): \PDOStatement {
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $currentPage = $page > 0 ? $page : 1;
        $rowsPerPage = $this->rowsPerPage;

        $query .= " ORDER BY $order";
        $query .= ' LIMIT :paginate_start, :paginate_rows_per_page';

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':paginate_start', ($rowsPerPage * $currentPage) - $rowsPerPage, \PDO::PARAM_INT);
        $stmt->bindValue(':paginate_rows_per_page', $rowsPerPage, \PDO::PARAM_INT);
        
        return $stmt;
    }
}
