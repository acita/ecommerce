<?php

namespace Model;

use BD\ConnectSQL;
use Model\Model;

class User extends Model {

    const SESSAO = "User";

    public static function login ($login, $password)
    {
        if($login != "" && $password != "" ||
            $login != NULL && $password != NULL)
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
            $user->setData($data);
                      
            $_SESSION[User::SESSAO] = $user->getValues();

            return $user;

        }else
        {
            throw new \Exception("Usuário inexistente ou senha inválida");
        }
    }}

    /**
     * Verifica se o usuário está autenticado
     * @param bool $inadmin 
     */
    public static function verifyLogin($inadmin = true)
    {
        if(!isset($_SESSION[User::SESSAO])
        ||
        !$_SESSION[User::SESSAO]
        ||
        !(int)$_SESSION[User::SESSAO]["iduser"] > 0
        ||
        (bool)$_SESSION[User::SESSAO]["inadmin"] !== $inadmin
        )
        {
            header("Location: /login");
            exit;
        }
    }

    public static function logout()
    {
        $_SESSION[User::SESSAO] = NULL;
    }
}
