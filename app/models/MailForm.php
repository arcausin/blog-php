<?php

namespace App\Models;

require_once __DIR__ . '/../../config/database.php';

class MailForm
{
    public int $id;
    private string $uuid;
    private string $firstname;
    private string $lastname;
    private string $email;
    private string $subject;
    private string $message;

    public function __construct(
        string $uuid,
        string $firstname,
        string $lastname,
        string $email,
        string $subject,
        string $message
    ) {
        $this->uuid = $uuid;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
    }

    public static function MailFormUuidExists(string $uuid): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "SELECT COUNT(*) FROM mail_form WHERE uuid = :uuid"
        );
        $statement->bindParam(':uuid', $uuid, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn();
    }

    public function addMailForm(): int
    {
        $database = dbConnect();

        $statement = $database->prepare(
            "INSERT INTO mail_form (uuid, first_name, last_name, mail_adress, subject, message, creation_date)
            VALUES (:uuid, :first_name, :last_name, :mail_adress, :subject, :message, NOW())"
        );
        $statement->bindParam(':uuid', $this->uuid, \PDO::PARAM_STR);
        $statement->bindParam(':first_name', $this->firstname, \PDO::PARAM_STR);
        $statement->bindParam(':last_name', $this->lastname, \PDO::PARAM_STR);
        $statement->bindParam(':mail_adress', $this->email, \PDO::PARAM_STR);
        $statement->bindParam(':subject', $this->subject, \PDO::PARAM_STR);
        $statement->bindParam(':message', $this->message, \PDO::PARAM_STR);

        $statement->execute();

        return $statement->rowCount();
    }
}