<?php

namespace App\Models;

require __DIR__ . '/../../config/database.php';

class Article
{
    public int $id;
    private int $id_author;
    private string $title;
    private string $illustration;
    private string $subtitle;
    private string $content;
    private string $slug;
    public int $validate;
    public int $visible;

    public function __construct(
        int $id_author,
        string $title,
        string $illustration,
        string $subtitle,
        string $content,
        string $slug
    ) {
        $this->id_author = $id_author;
        $this->title = $title;
        $this->illustration = $illustration;
        $this->subtitle = $subtitle;
        $this->content = $content;
        $this->slug = $slug;
    }

    public static function getArticles(): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT * FROM articles ORDER BY creation_date DESC"
        );
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getArticle(string $slug): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT * FROM articles WHERE slug = :slug"
    );
        $statement->bindParam(':slug', $slug, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public static function getAuthorByArticle(string $slug): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT users.* FROM users
            INNER JOIN articles ON users.id = articles.id_author
            WHERE articles.slug = :slug"
        );
        $statement->bindParam(':slug', $slug, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public static function ArticleSlugExists(string $slug): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT COUNT(*) FROM articles WHERE slug = :slug"
        );
        $statement->bindParam(':slug', $slug, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn();
    }
}