<?php

namespace JamInvites\controller;

use JamInvites\service\InviteService;

class InviteController
{
    private InviteService $userService;

    function __construct()
    {
        $this->userService = new InviteService();
    }

    public static function create()
    {
        return new InviteController();
    }

    public function sendInvite( array $params=null )
    {
        $userId = $params['userId'] ?? null;
        $userName = $params['userName'] ?? null;

        $response["message"] = $this->userService->sendInvite($userId, $userName);
        echo json_encode($response);
    }

    public function acceptInvite( array $params=null )
    {
        $receiverId = $params['receiverId'] ?? null;
        $sender = $params['sender'] ?? null;
        $isAccepted = $params['isAccepted'] ?? true;

        $response["message"] = $this->userService->acceptInvite($receiverId, $sender, $isAccepted);
        echo json_encode($response);
    }

    public function cancelInvite( array $params=null )
    {
        $sender = $params['sender'] ?? null;
        $receiver = $params['receiver'] ?? null;
        $response["message"] = $this->userService->cancelInvite($sender, $receiver);
        echo json_encode($response);
    }
}