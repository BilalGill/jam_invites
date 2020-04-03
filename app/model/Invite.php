<?php


namespace JamInvites\model;


use InviteStatus\InviteStatus;

class Invite
{
    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * @return string
     */
    public function getReceiver(): string
    {
        return $this->receiver;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    private int $id;
    private string $sender;
    private string $receiver;
    private int $status;

    public function __construct($sender, $receiver, $status, $id = -1)
    {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->status = $status;
        $this->id = $id;
    }
}