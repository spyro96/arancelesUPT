<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];



    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {
        
        //$url_actual = $_SERVER['PATH_INFO'] ?? '/';
        
        $url_actual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];
        
        if ($method === 'GET') {
            $fn = $this->getRoutes[$url_actual] ?? null;
        } else {
            $fn = $this->postRoutes[$url_actual] ?? null;
        }

        if ( $fn ) {
            call_user_func($fn, $this);
        } else {
            // header('Location: /404');
            echo "NO SE HA ENCONTRADO NINGUNA PAGINA";
        }
    }

    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value; 
        }

        ob_start(); 

        include_once __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer

        //utilizar el layout de acuerdo a la URL

        // $url_actual = $_SERVER['PATH_INFO'] ?? '/';
        $url_actual = $_SERVER['REQUEST_URI'] ?? '/';

        if (strpos($url_actual, '/admin') !== false) {
            include_once __DIR__ . '/views/admin-layout.php';
        } else if (strpos($url_actual, '/estudiante') !== false) {
            include_once __DIR__ . '/views/estudiante-layout.php';
        } else {
            include_once __DIR__ . '/views/layout.php';
        }
    }
}
