<?php

namespace App\Models;

use App\Models\Model;

class Page extends Model {

    private $querySelect = '
        SELECT
            p.id,
            p.type,
            p.title,
            p.slug,
            p.date_posted,
            p.date_modified,
            p.content,
            p.user_id,
            u.username AS user_username,
            u.fullName AS user_fullName,
            u.bio AS user_bio,
            u.website AS user_website,
            u.avatar AS user_avatar
        FROM
            pages AS p
            LEFT JOIN users AS u ON (u.id = p.user_id)
        ';

    public function index() {
        $query = $this->querySelect;
        $query .= '
            WHERE
                p.type = :type
        ';

        if ($this->user_id)
            $query .= 'AND user_id = :user_id';

        $stmt = $this->paginate($query, 'p.date_posted DESC');
        $stmt->bindValue(':type', $this->type);

        if ($this->user_id)
            $stmt->bindValue(':user_id', $this->user_id);

        $stmt->execute();
        $this->setData($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function show($col) {
        $query = $this->querySelect;
        $query .= "
            WHERE
                p.type = :type AND
                p.$col = :$col
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':type', $this->type);
        $stmt->bindValue(":$col", $this->$col);
        $stmt->execute();

        $this->setData($stmt->fetch(\PDO::FETCH_ASSOC));
    }
}
