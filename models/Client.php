<?php

use Telegram\Bot\Commands\Registry;

class Client
{
    static public function add($name, $phone, $email, $message) {
        Registry::getProperty('db_instance')->dbQuery('INSERT INTO `clients`(`name`, `phone`, `email`, `text`) VALUES (:name, :phone, :email, :text)', [
                'name'  => $name,
                'phone' => $phone,
                'email' => $email,
                'text'  => $message,
        ]);
    }
    
    static public function get($id) {
        return Registry::getProperty('db_instance')->dbQuery('SELECT * FROM `clients` WHERE id = :id', [
                'id'  => $id
        ])->fetch();
    }
    
    static public function getAll() {
        return Registry::getProperty('db_instance')->dbQuery('SELECT * FROM `clients`')->fetchAll();
    }
}