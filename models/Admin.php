<?php

namespace Model;

class Admin extends MWElement {
    public static $tn = "users";
    public $id;
    public $email;
    public $password;
    public function __construct($argsPost=[]) {
        $this->valuesArray["id"]            = $argsPost['id'] ?? null;
        $this->valuesArray["email"]         = $argsPost['email'] ?? '';
        $this->valuesArray["password"]            = $argsPost['password'] ?? '';        
    } 

    public function validateLogin(){
        if(!$this->valuesArray["email"]) {
            self::$errores[] = "Email is mandatory";
        }

        if(!$this->valuesArray["password"]) {
            self::$errores[] = "Password is mandatory";
        }

        return self::$errores;
    }

    public function checkExistence() {
        $query = "SELECT * FROM " . self::$tn . " WHERE email='" . $this->valuesArray["email"] . "' LIMIT 1";
        $res = self::$db->query($query);
        if (!$res->num_rows) {
            self::$errores[] = "User does not exist";
            return;
        }
        return $res;
    }

    public function checkPass($res) {
        $user = $res->fetch_object();
        $flag = password_verify($this->valuesArray["password"], $user->password);
        if(!$flag) {
            self::$errores[] = "Password is incorrect";            
        }
        return $flag;
    }

    public function logUser() {
        session_start();
        $_SESSION['user'] = $this->valuesArray["email"];
        $_SESSION['login'] = true;
        header('Location: /admin');
    }
}