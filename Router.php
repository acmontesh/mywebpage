<?php
namespace MVC;

use function Model\debugChunk;

class Router {
    public $routesGET = [];
    public $routesPOST = [];

    public function get($url, $func) {
        $this->routesGET[$url] = $func;
    }

    public function post($url, $func) {
        $this->routesPOST[$url] = $func;
    }

    public function checkRoutes() {
        session_start();
        $logged = $_SESSION['login'] ?? NULL;

        $protectedRoutes = ['/admin', '/projects/crear', 
        '/projects/actualizar', '/projects/eliminar'];

        if (isset($_SERVER['PATH_INFO'])) {
            $urlCurrent = $_SERVER['PATH_INFO'] ?? '/';
        } else {
            $urlCurrent = $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI'];
        }

        $method         = $_SERVER['REQUEST_METHOD'];

        if ($method==='GET') {
            $func       = $this->routesGET[$urlCurrent] ?? NULL;
        } else {
            $func       = $this->routesPOST[$urlCurrent] ?? NULL;
        }


        if(in_array($urlCurrent, $protectedRoutes) && !$logged) {
            header('Location: /');
        }


        if($func) {
            //URL exists and there is an associated function... So we call it!
            call_user_func($func, $this);
        } else {
            echo "Sorry, the URL you are trying to access is not currently available";
        }
    }

    public function render($view, Array $datos, $uniqueTag=false) {
        foreach ($datos as $key=>$val):
            $$key = $val;
        endforeach;
        ob_start();
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean();
        include_once __DIR__ . '/views/layout.php';
    }
}