<?php

abstract class DbInstance
{
    private $dbConnection;

    public function getConnection() : PDO
    {
        return $this->dbConnection;
    }
 
    protected function __construct(string $host, string $dbname, string $user, string $pass)
    {
        // $config = include_once('dbconf.php');
        $this->dbConnection = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $this->dbConnection->exec('SET NAMES UTF8');
    }
}  