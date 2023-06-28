<?php

namespace Admin\Models;

require_once __DIR__ . '/../../config/database.php';

class Comment
{
    public int $id;
    private int $id_author;
    private int $id_article;
    private string $uuid;
    private string $comment;

    public function __construct(
        int $id_author,
        int $id_article,
        string $uuid,
        string $comment
    ) {
        $this->id_author = $id_author;
        $this->id_article = $id_article;
        $this->uuid = $uuid;
        $this->comment = $comment;
    }

    public static function getComment(string $uuid): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT * FROM comments WHERE uuid = :uuid"
        );
        $statement->bindParam(':uuid', $uuid, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public static function getCommentsNotValidate(): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT * FROM comments WHERE validate = 0 ORDER BY creation_date ASC"
        );

        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getCommentsByArticle(string $slug): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT comments.* FROM comments
            INNER JOIN articles ON comments.id_article = articles.id
            WHERE articles.slug = :slug AND comments.validate = 1
            ORDER BY comments.creation_date DESC"
        );
        $statement->bindParam(':slug', $slug, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getCommentsNotValidateByArticle(string $slug): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT comments.* FROM comments
            INNER JOIN articles ON comments.id_article = articles.id
            WHERE articles.slug = :slug AND comments.validate = 0
            ORDER BY comments.creation_date DESC"
        );
        $statement->bindParam(':slug', $slug, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getCommentsNotValidateByArticleByAuthor(string $slug, int $id_author): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT comments.* FROM comments
            INNER JOIN articles ON comments.id_article = articles.id
            WHERE articles.slug = :slug AND comments.validate = 0 AND comments.id_author = :id_author
            ORDER BY comments.creation_date DESC"
        );
        $statement->bindParam(':slug', $slug, \PDO::PARAM_STR);
        $statement->bindParam(':id_author', $id_author, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getAuthorByComment(string $uuid): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT users.* FROM users
            INNER JOIN comments ON users.id = comments.id_author
            WHERE comments.uuid = :uuid"
        );
        $statement->bindParam(':uuid', $uuid, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public static function CommentUuidExists(string $uuid): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT COUNT(*) FROM comments WHERE uuid = :uuid"
        );
        $statement->bindParam(':uuid', $uuid, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn();
    }

    public function validateComment(): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "UPDATE comments SET validate = 1 WHERE id = :id"
        );
        $statement->bindParam(':id', $this->id, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->rowCount();
    }

    public function addComment(): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "INSERT INTO comments (id_author, id_article, uuid, comment, validate, creation_date)
            VALUES (:id_author, :id_article, :uuid, :comment, 0, NOW())"
        );
        $statement->bindParam(':id_author', $this->id_author, \PDO::PARAM_INT);
        $statement->bindParam(':id_article', $this->id_article, \PDO::PARAM_INT);
        $statement->bindParam(':uuid', $this->uuid, \PDO::PARAM_STR);
        $statement->bindParam(':comment', $this->comment, \PDO::PARAM_STR);

        $statement->execute();

        return $statement->rowCount();
    }

    public function addCommentValidate(): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "INSERT INTO comments (id_author, id_article, uuid, comment, validate, creation_date)
            VALUES (:id_author, :id_article, :uuid, :comment, 1, NOW())"
        );
        $statement->bindParam(':id_author', $this->id_author, \PDO::PARAM_INT);
        $statement->bindParam(':id_article', $this->id_article, \PDO::PARAM_INT);
        $statement->bindParam(':uuid', $this->uuid, \PDO::PARAM_STR);
        $statement->bindParam(':comment', $this->comment, \PDO::PARAM_STR);

        $statement->execute();

        return $statement->rowCount();
    }

    public function deleteComment(): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "DELETE FROM comments WHERE id = :id"
        );
        $statement->bindParam(':id', $this->id, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->rowCount();
    }
}