<?php

namespace Hcode\Model;

use Exception;
use \Hcode\DB\Sql;
use \Hcode\Model;

/**
 * Método login consulta 
 */

class User extends Model
{
    const SESSION = "User";

    public  static  function login($login, $password)
    {

        $sql = new Sql();

        $results = $sql->select(
            "SELECT * FROM tb_users WHERE deslogin = :LOGIN",
            array(":LOGIN" => $login)
        );

        if (count($results) === 0) {
            throw new \Exception("Login Inválido");
        }

        $data = $results[0];

        /**
         * Método que corresponde se a senha fornecida corresponde ao hash forneceido
         * Se passar na verificação, cria-se um User, uma instância da classe User
         */
        if (password_verify($password, $data["despassword"]) === true) {

            $user = new User();

            $user->setData($data);

            $_SESSION[User::SESSION] = $user->getData();

            return $user;


        } else {
            throw new \Exception("Login Inválido");
        }
    }

    public static function verifyLogin($inadmin = true){

        if(!isset($_SESSION[User::SESSION])
        ||
        !$_SESSION[User::SESSION]
        ||
        !(int)$_SESSION[User::SESSION]["iduser"] > 0
        ||
        // Estudar
        (bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin
        ){

            header("Location: /admin/login");
            exit;
        
        }

    }

    public static function logout()
    {
        $_SESSION[User::SESSION] = NULL;
    }


}
