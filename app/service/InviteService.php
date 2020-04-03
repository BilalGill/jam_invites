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

    /**
     * @param int $userId
     * @param string $receiver
     * @return string
     */
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

    /**
     * @param int $sender
     * @param string $receiver
     * @return string
     */
    public function cancelInvite(string $senderId, string $receiver){
        if(is_null($senderId) || is_null($receiver))
        {
            $this->responseMessage = "Invalid Params";
            return $this->responseMessage;
        }

        $this->sender = $this->userRepository->getUserById($senderId);
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

        $this->invite = $this->inviteRepository->getInviteStatus($this->sender->getUserName(), $this->receiver->getUserName());
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

    /**
     * @param int $receiverId
     * @param string $sender
     * @param bool $isAccepted
     * @return string
     */
    public function acceptInvite(int $receiverId, string $sender, bool $isAccepted)
    {
        if(is_null($receiverId) || is_null($sender))
        {
            $this->responseMessage = "Invalid Params";
            return $this->responseMessage;
        }

        $this->receiver = $this->userRepository->getUserById($receiverId);
        if(is_null($this->receiver))
        {
            $this->responseMessage = "Invalid Receiver Id";
            return $this->responseMessage;
        }

        $this->sender = $this->userRepository->getUserByName($sender);
        if(is_null($this->sender))
        {
            $this->responseMessage = "Invalid Receiver";
            return $this->responseMessage;
        }

        $this->invite = $this->inviteRepository->getInviteStatus($this->sender->getUserName(), $this->receiver->getUserName());
        if(is_null($this->invite))
        {
            $this->responseMessage = "Invite cancelled";
            return $this->responseMessage;
        }
        else if($this->invite->getStatus() == SENT)
        {
            if($isAccepted)
            {
                $this->inviteRepository->updateInvite($this->invite->getId(), ACCEPTED);
                $this->responseMessage = "Invite Accpeted";
            }
            else
            {
                $this->inviteRepository->updateInvite($this->invite->getId(), DECLINED);
                $this->responseMessage = "Invite Accpeted";
            }

            return$this->responseMessage
        }
    }
}