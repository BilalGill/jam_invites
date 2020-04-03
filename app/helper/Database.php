<?php


namespace JamInvites\helper;


use mysqli;
require APP . 'config/database.php';

class Database extends mysqli
{
    private static $instance = null;

    private function __construct()
    {
        parent::__construct(DB_HOST, DB_USER, DB_PWD, DB_NAME);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new Database();
        }

        return self::$instance;
    }
}