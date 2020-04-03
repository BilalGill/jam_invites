<?php


namespace JamInvites\repository;

use JamInvites\helper\Database;
use JamInvites\model\Invite;

class InviteRepository
{
    private ?Invite $invite = null;

    public function __construct()
    {
    }
    public function getInviteStatus(string $sender, string $receiver)
    {
        $query = "select * from invites where sender = " . $sender . " AND receiver = " . $receiver;
        $result = Database::getInstance()->query($query);

        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            return new Invite($row["sender"], $row["receiver"], $row["status"], $row["id"]);
        }
        else
        {
            return null;
        }
    }
    public function insertInvite($sender, $receiver, $status)
    {
        $sender = Database::getInstance()->real_escape_string($sender);
        $receiver = Database::getInstance()->real_escape_string($receiver);
        $status = Database::getInstance()->real_escape_string($status);

        $query = "insert into invites  (sender, receiver, status)
                    VALUES ('$sender','$receiver','$status')";

        if(Database::getInstance()->query($query))
            return true;
        else
            return false;
    }
    public function updateInvite($id, $status)
    {
        $status = Database::getInstance()->real_escape_string($status);

        $query = "update into invites SET status = '$status' where id = '$id'";

        if(Database::getInstance()->query($query))
            return true;
        else
            return false;
    }

    public function deleteInvite($id)
    {
        $query = "DELETE from invites where id = '$id'";

        if(Database::getInstance()->query($query))
            return true;
        else
            return false;
    }
}