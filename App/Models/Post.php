<?php

namespace App\Models;

use App\Models\Model;

class Post extends Model {

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
            posts AS p
            LEFT JOIN users AS u ON (u.id = p.user_id)
        ';

    public function index() {
        $stmt = $this->paginate($this->querySelect, 'p.date_posted DESC');
        $stmt->execute();

        $this->setData($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function indexByType() {
        $query = $this->querySelect;
        $query .= '
            WHERE
                p.type = :type
        ';

        $stmt = $this->paginate($query, 'p.date_posted DESC');
        $stmt->bindValue(':type', $this->type);
        $stmt->execute();

        $this->setData($stmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function show() {
        $query = $this->querySelect;
        $query .= '
            WHERE
                p.id = :id
        ';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();

        $this->setData($stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public function showBySlug() {
        $query = $this->querySelect;
        $query .= '
            WHERE
                p.slug = :slug
        ';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':slug', $this->slug);
        $stmt->execute();

        $this->setData($stmt->fetch(\PDO::FETCH_ASSOC));
    }
}
