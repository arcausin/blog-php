<?php

namespace Admin\Models;

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

    public static function getAuthors(): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT * FROM users WHERE role = 2 ORDER BY pseudonym ASC"
        );
        $statement->execute();

        return $statement->fetchAll();
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

    public function addArticle(): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "INSERT INTO articles (id_author, title, illustration, subtitle, content, slug, creation_date) VALUES (:id_author, :title, :illustration, :subtitle, :content, :slug, NOW())"
        );

        $statement->bindParam(':id_author', $this->id_author, \PDO::PARAM_INT);
        $statement->bindParam(':title', $this->title, \PDO::PARAM_STR);
        $statement->bindParam(':illustration', $this->illustration, \PDO::PARAM_STR);
        $statement->bindParam(':subtitle', $this->subtitle, \PDO::PARAM_STR);
        $statement->bindParam(':content', $this->content, \PDO::PARAM_STR);
        $statement->bindParam(':slug', $this->slug, \PDO::PARAM_STR);

        $statement->execute();

        return $statement->rowCount();
    }

    public function updateArticle(): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "UPDATE articles SET id_author = :id_author, title = :title, illustration = :illustration, subtitle = :subtitle, content = :content, slug = :slug, validate = :validate, visible = :visible, update_date = NOW() WHERE id = :id"
        );

        $statement->bindParam(':id', $this->id, \PDO::PARAM_INT);
        $statement->bindParam(':id_author', $this->id_author, \PDO::PARAM_INT);
        $statement->bindParam(':title', $this->title, \PDO::PARAM_STR);
        $statement->bindParam(':illustration', $this->illustration, \PDO::PARAM_STR);
        $statement->bindParam(':subtitle', $this->subtitle, \PDO::PARAM_STR);
        $statement->bindParam(':content', $this->content, \PDO::PARAM_STR);
        $statement->bindParam(':slug', $this->slug, \PDO::PARAM_STR);
        $statement->bindParam(':validate', $this->validate, \PDO::PARAM_INT);
        $statement->bindParam(':visible', $this->visible, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->rowCount();
    }

    public function deleteArticle(): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "DELETE FROM articles WHERE id = :id"
        );

        $statement->bindParam(':id', $this->id, \PDO::PARAM_INT);
        
        $statement->execute();

        return $statement->rowCount();
    }
}