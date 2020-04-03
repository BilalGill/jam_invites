<?php


namespace JamInvites\repository;

use JamInvites\helper\Database;
use JamInvites\model\User;

class UserRepository
{
    public function __construct()
    {
    }

    public function getUserById(int $userId)
    {
        $query = "select * from user where userId = " . $userId;
        $result = Database::getInstance()->query($query);

        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            return new User($row["userId"], $row["userName"]);
        }
        else
        {
            return null;
        }
    }

    public function getUserByName(string $sender)
    {
        $query = "select * from user where userName = " . $sender;
        $result = Database::getInstance()->query($query);

        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            return new User($row["userId"], $row["userName"]);
        }
        else
        {
            return null;
        }
    }
}