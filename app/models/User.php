<?php

namespace App\Models;

require_once __DIR__ . '/../../config/database.php';

class User
{
    private int $id;
    private string $pseudo;
    private string $email;
    private string $password;
    private string $password_confirm;
    private string $role;
    private string $token;
    private string $token_creation_date;
    private string $reset_password_token;
    private string $reset_password_token_creation_date;
    private string $last_connexion;
    private string $creation_date;

    public function __construct(
        string $pseudo,
        string $email,
        string $password,
        string $token
    ) {
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->password = $password;
        $this->token = $token;
    }

    public static function getUsers(): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT * FROM users ORDER BY pseudonym ASC"
        );
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function getUser(string $pseudo): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT * FROM users WHERE pseudonym = :pseudonym"
    );
        $statement->bindParam(':pseudonym', $pseudo, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public static function getUserByEMail(string $email): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT * FROM users WHERE mail_adress = :mail_adress"
        );
        $statement->bindParam(':mail_adress', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public static function getUserByResetPasswordToken(string $resetPasswordToken): array
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT * FROM users WHERE reset_password_token = :reset_password_token"
        );
        $statement->bindParam(':reset_password_token', $resetPasswordToken, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public static function userPseudoExists(string $pseudo): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT COUNT(*) FROM users WHERE pseudonym = :pseudonym"
        );
        $statement->bindParam(':pseudonym', $pseudo, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn();
    }

    public static function userEmailExists(string $email): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT COUNT(*) FROM users WHERE mail_adress = :mail_adress"
        );
        $statement->bindParam(':mail_adress', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn();
    }

    public static function userTokenExists(string $token): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT COUNT(*) FROM users WHERE token = :token"
        );
        $statement->bindParam(':token', $token, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn();
    }

    public static function userResetPasswordTokenExists(string $resetPasswordToken): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT COUNT(*) FROM users WHERE reset_password_token = :reset_password_token"
        );
        $statement->bindParam(':reset_password_token', $resetPasswordToken, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn();
    }

    public static function userMailConfirm(string $token): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "UPDATE users SET role = 1, token = NULL, token_creation_date = NULL WHERE token = :token"
        );
        $statement->bindParam(':token', $token, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->rowCount();
    }

    public static function addResetPasswordToken(string $email, string $token): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "UPDATE users SET reset_password_token = :reset_password_token, reset_password_token_creation_date = NOW() WHERE mail_adress = :mail_adress"
        );
        $statement->bindParam(':reset_password_token', $token, \PDO::PARAM_STR);
        $statement->bindParam(':mail_adress', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->rowCount();
    }

    public function addUser()
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "INSERT INTO users (pseudonym, mail_adress, password, token, token_creation_date, creation_date) VALUES (:pseudonym, :mail_adress, :password, :token, NOW(), NOW())"
        );
        $statement->bindParam(':pseudonym', $this->pseudo, \PDO::PARAM_STR);
        $statement->bindParam(':mail_adress', $this->email, \PDO::PARAM_STR);
        $statement->bindParam(':password', $this->password, \PDO::PARAM_STR);
        $statement->bindParam(':token', $this->token, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->rowCount();
    }

    public static function updatePassword(string $id, string $password): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "UPDATE users SET password = :password, reset_password_token = NULL, reset_password_token_creation_date = NULL WHERE id = :id"
        );
        $statement->bindParam(':password', $password, \PDO::PARAM_STR);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->rowCount();
    }
}