<?php

namespace Model;

use BD\ConnectSQL;
use Model\Model;

class User extends Model {

    public static function login ($login, $password)
    {
        $sql = new ConnectSQL();

        $results = $sql->select("SELECT *FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login
        ));

        if (count($results) === 0)
        {
            throw new \Exception("Usuário inexistente ou senha inválida");
        }

        $data = $results[0];

        if(password_verify($password, $data["despassword"]) === true)
        {
            $user = new User();
            $user->setiduser($data["iduser"]);

        }else
        {
            throw new \Exception("Usuário inexistente ou senha inválida");
        }
    }

}