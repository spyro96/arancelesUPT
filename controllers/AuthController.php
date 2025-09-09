<?php

namespace Controllers;

use Classes\Email;
use Model\DatosPersonales;
use Model\Usuario;
use MVC\Router;

    class AuthController{
    public static function login(Router $router) {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);

            //alertas para validar
            $alertas = $usuario->validarLogin();

            if (empty($alertas)) {
                //verificar si existe email
                $usuario = Usuario::findEmail($usuario->correo);
                if (!$usuario) {
                    Usuario::setAlerta('error', 'El usuario no existe');
                } else {
                    //el usuario existe
                    if (password_verify($_POST['password'], $usuario->password)) {

                        if ($usuario->estatus === '0') {
                            Usuario::setAlerta('error', 'Tu cuenta de usuario esta inactiva');
                        } else {
                            // Iniciar la sesión
                            session_start();
                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['email'] = $usuario->correo;
                            $_SESSION['rol'] = $usuario->rol ?? null;
                            $_SESSION['estatus'] = $usuario->estatus;

                            if ($usuario->rol === "admin" || $usuario->rol === 'finanza') {

                                header('Location: /admin/dashboard');
                            } else {

                                $datosPersonales =  DatosPersonales::where('usuarioId', $_SESSION['id']);
                                if (!$datosPersonales) {
                                    header('Location: /estudiante/datos-personales');
                                } else {
                                    $_SESSION['nombres'] = $datosPersonales->nombres ?? null;
                                    $_SESSION['apellidos'] = $datosPersonales->apellidos ?? null;
                                    $_SESSION['cedula'] = $datosPersonales->cedula ?? null;
                                    $_SESSION['nacionalidad'] = $datosPersonales->nacionalidad ?? null;
                                    $_SESSION['telefono'] = $datosPersonales->telefono ?? null;
                                    header('Location: /estudiante/dashboard');

                                }
                            }
                        }
                    } else {
                        Usuario::setAlerta('error', 'Contraseña Incorrecta');
                    }
                }
            }
        }
        $alertas = Usuario::getAlertas();
        // Render a la vista 
        $router->render('auth/index', [
            'script' => '<script src="/build/js/login.js" defer></script>',
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }

    public static function logout() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            session_destroy();
            header('Location: /');
        }
       
    }

    public static function registro(Router $router) {
        $alertas = [];
        $usuario = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);

            if(empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->correo);

                if($existeUsuario) {
                    Usuario::setAlerta('error', 'El Usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();

                    // Eliminar password2
                    // unset($usuario->password2);

                    // // Generar el Token
                    // $usuario->crearToken();

                    // Crear un nuevo usuario
                    $resultado =  $usuario->guardar();

                    // // Enviar email
                    // $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    // $email->enviarConfirmacion();
                    

                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/registro', [
            'script' => '<script src="/build/js/sweetalert2.all.min.js" defer></script>
                        <script src="/build/js/iziToast.min.js" defer></script>
                        <script src="/build/js/crear.js" defer></script>',
            'titulo' => 'Crear Cuenta',
            'usuario' => $usuario, 
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router){

        $router->render('auth/recuperar', [
            'titulo' => 'Recuperar Contraseña',
            'script' => '<script src="/build/js/sweetalert2.all.min.js" defer></script>
                        <script src="/build/js/iziToast.min.js" defer></script>
                        <script src="/build/js/recuperar.js"defer></script>'
        ]);
    }

    public static function mensaje(Router $router) {

        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);
    }

    public static function confirmar(Router $router) {
        
        $token = s($_GET['token']);

        if(!$token) header('Location: /');

        // Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            // No se encontró un usuario con ese token
            Usuario::setAlerta('error', 'Token No Válido, la cuenta no se confirmo');
        } else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            $usuario->token = '';
            unset($usuario->password2);
            
            // Guardar en la BD
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta Comprobada Exitosamente!');
        }

     

        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta DevWebcamp',
            'alertas' => Usuario::getAlertas()
        ]);
    }

    public static function manual_login(){
        $archivo = $_SERVER['DOCUMENT_ROOT']. "/../pdf/MANUAL.pdf";
        $archivo = str_replace("\\", "/", $archivo);
        
        if (file_exists($archivo)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($archivo) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
        
            @readfile($archivo);
        } else {
            echo "El archivo no existe.";
        }
    }
}