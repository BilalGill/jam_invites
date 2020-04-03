<?php


namespace JamInvites\model;


class User
{
    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    private int $userId;
    private string $userName;

    public function __construct(int $userId, string $userName)
    {
        $this->userId = $userId;
        $this->userName = $userName;
    }
}