<?php

require APP . 'config/constants.php';

namespace JamInvites\service;

use JamInvites\model\Invite;
use JamInvites\repository\UserRepository;
use JamInvites\repository\InviteRepository;
use JamInvites\model\User;

class InviteService
{
    private UserRepository $userRepository;
    private InviteRepository $inviteRepository;
    private ?User $sender = null;
    private ?User $receiver = null;
    private ?Invite $invite = null;
    private string $responseMessage = "Success";

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->inviteRepository = new UserRepository();
    }

    public function sendInvite(int $userId, string $receiver)
    {
        if(is_null($userId) || is_null($receiver))
        {
            $this->responseMessage = "Invalid Params";
            return $this->responseMessage;
        }

        $this->sender = $this->userRepository->getUserById($userId);
        if(is_null($this->sender))
        {
            $this->responseMessage = "Invalid User Id";
            return $this->responseMessage;
        }

        $this->receiver = $this->userRepository->getUserByName($receiver);
        if(is_null($this->receiver))
        {
            $this->responseMessage = "Invalid Receiver";
            return $this->responseMessage;
        }

        $this->invite = $this->inviteRepository->getInviteStatus($this->sender->getUserName(), $this->receiver->getUserName());
        if(!is_null($this->invite))
        {
            if($this->invite->getStatus() == ACCEPTED)
            {
                $this->responseMessage = "User already accepted your invitation";
            }
            else if($this->invite->getStatus() == DECLINED)
            {
                $this->responseMessage = "Invitation sent";
                $this->inviteRepository->updateInvite($this->invite->getId(), SENT)
            }
        }
        else
        {
            $this->responseMessage = "Invitation sent";
            $result = $this->inviteRepository->insertInvite($this->invite->getSender(), $this->invite->getReceiver(), SENT)
        }

        return $this->responseMessage;
    }

    public function cancelInvite(string $sender, string $receiver){
        if(is_null($sender) || is_null($receiver))
        {
            $this->responseMessage = "Invalid Params";
            return $this->responseMessage;
        }

        $this->sender = $this->userRepository->getUserByName($sender);
        if(is_null($this->sender))
        {
            $this->responseMessage = "Invalid Sender";
            return $this->responseMessage;
        }

        $this->receiver = $this->userRepository->getUserByName($receiver);
        if(is_null($this->receiver))
        {
            $this->responseMessage = "Invalid Sender";
            return $this->responseMessage;
        }

        $this->invite = $this->inviteRepository->getInviteStatus($sender, $receiver);
        if(is_null($this->invite)){
            $this->responseMessage = "Invite not found";
        }
        else if($this->invite->getStatus() == SENT){
            $this->inviteRepository->deleteInvite($this->invite->getId())
            $this->responseMessage = "Invite cancelled succesfully";
        }
        else if($this->invite->getStatus() == ACCEPTED){
            $this->responseMessage = "Invitation  already accepted";
        }

        return $this->responseMessage;
    }
}