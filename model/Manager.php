<?php
namespace cours\Tp_forum\model;

class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=forum;charset=utf8', 'root', '');
        return $db;
    }
}