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

        $response = $this->userService->sendInvite($userId, $userName);
        echo json_encode($response);
    }

    public function acceptInvite( array $params=null )
    {

    }

    public function cancelInvite( array $params=null )
    {
        $sender = $params['sender'] ?? null;
        $receiver = $params['receiver'] ?? null;
        $response = $this->userService->cancelInvite($sender, $receiver);
        echo json_encode($response);
    }
}