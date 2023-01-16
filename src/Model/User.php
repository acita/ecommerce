<?php

namespace Model;

use BD\ConnectSQL;
use Model\Model;
use PSpell\Config;

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
            $message = throw new \Exception("Usuário inexistente ou senha inválida");
            echo $message->getMessage();
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
        session_destroy();
    }

    public static function listAll()
    {
        $sql = new ConnectSQL();
        return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson");
    }

    public function save()
    {
        $sql = new ConnectSQL();

        $results = $sql->select("CALL sp_users_save (
            :desperson, 
            :deslogin, 
            :despassword, 
            :desemail, 
            :nrphone, 
            :inadmin)", array(
            ":desperson"=>$this->getdesperson(),
            ":deslogin"=>$this->getdeslogin(),
            ":despassword"=>$this->getdespassword(),
            ":desemail"=>$this->getdesemail(),
            ":nrphone"=>$this->getnrphone(),
            ":inadmin"=>$this->getinadmin()
            ));

        $this->setData($results[0]);
    }

    public function get($iduser){
        $sql = new ConnectSQL();

        $results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING (idperson) WHERE a.iduser = :iduser", array(
            ":iduser"=>$iduser
        ));

        $this->setData($results[0]);
    }

    public function update(){

        $sql = new ConnectSQL();

        $results = $sql->select("CALL sp_usersupdate_save (
            :iduser,
            :desperson, 
            :deslogin, 
            :despassword, 
            :desemail, 
            :nrphone, 
            :inadmin)", array(
                ":iduser"=>$this->getiduser(),
                ":desperson"=>$this->getdesperson(),
                ":deslogin"=>$this->getdeslogin(),
                ":despassword"=>$this->getdespassword(),
                ":desemail"=>$this->getdesemail(),
                ":nrphone"=>$this->getnrphone(),
                ":inadmin"=>$this->getinadmin()
            ));

        $this->setData($results[0]);
    }

    public function delete(){
        $sql = new ConnectSQL();
        $sql->query("CALL sp_users_delete(:iduser)", array(
            ":iduser"=>$this->getiduser()
        ));
    }
}