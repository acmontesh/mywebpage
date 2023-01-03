<?php
namespace Controllers;

use MVC\Router;
use Model\Admin;

use function Model\debugChunk;

class LoginController {
    public static function login(Router $router) {
        $errores = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $auth = new Admin($_POST);
            $errores = $auth->validateLogin();
            if (empty($errores)) {
                $res = $auth->checkExistence();
                if (!$res) {
                    $errores = Admin::getErrors();
                } else {
                    $res = $auth->checkPass($res);
                    if (!$res) {
                        $errores = Admin::getErrors();
                    } else {
                        //Autenticar!!!
                        $auth->logUser();
                    }
                }
            }
        } 

        $router->render('auth/login',[
            'errores'=>$errores
        ]);
    }

    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
}