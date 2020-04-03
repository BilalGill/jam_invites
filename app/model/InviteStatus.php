<?php


namespace JamInvites\model;


class InviteStatus extends \SplEnum
{
    const Sent = 1;
    const Accepted = 2;
    const Declined = 3;
    const Cancel = 4;
}