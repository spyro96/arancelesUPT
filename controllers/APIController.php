<?php
    namespace Controllers;

use Model\DatosPersonales;
use Model\PreguntaSeguridad;
use Model\Usuario;

    class APIController{

        public static function crearUsuario(){

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $consulta = Usuario::findEmail($_POST['correo']);
            
            if($consulta){
                echo json_encode(['consulta' => true]);
                return;
            }else{
                $usuario = new Usuario($_POST);
                $usuario->rol = $_POST['tipo_u'] === 'si' ? 'estudiante' : 'particular';
                $usuario->hashPassword();
                
                $resultado = $usuario->guardar();
    
                 $id = $resultado['id'];
    
                $args = [
                    'pregunta1' => $_POST['pregunta1'],
                    'respuesta1' => $_POST['respuesta1'],
                    'pregunta2' => $_POST['pregunta2'],
                    'respuesta2' => $_POST['respuesta2'],
                    'usuarioId' => $id
                ];
                
                $preguntas_seguridad = new PreguntaSeguridad($args);
                $preguntas_seguridad->guardar();
    
                echo json_encode(['resultado' => $resultado]);
            }
            }
        }

        public static function datos_personales(){
            session_start();

            $primeraVez = true;

            $usuario = DatosPersonales::where('usuarioId', $_SESSION['id']);
            
            if($usuario){
                $primeraVez = false;
            }

            $datos = new DatosPersonales($_POST);

            $datos->id = $usuario->id ?? null;
            $datos->usuarioId = $_SESSION['id'];

            $resultado = $datos->guardar();

            echo json_encode(['resultado' => $resultado, 'primeraVez' => $primeraVez]);
        }

        public static function preguntas_seguridad(){
            session_start();
            if(!$_SESSION){
                header('Location: /');
            }

            //consulta la base de datos
            $preguntas = PreguntaSeguridad::where('usuarioId', $_SESSION['id']);
            
            $preguntas->sincronizar($_POST);
            
            $resultado = $preguntas->guardar();


            echo json_encode(['resultado'=> $resultado]);
        }

        public static function obtener_preguntas(){
            
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $usuario = Usuario::where('correo', $_POST['correo']);
                if(!$usuario){
                    echo json_encode(['resultado' => null]);
                }else{
                    $preguntas = PreguntaSeguridad::where('usuarioId', $usuario->id);

                    echo json_encode(['preguntas' => $preguntas]);
                }
            }else{
                echo json_encode(['']);
            }
        }

        public static function comprobar_preguntas(){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                
                $preguntas = PreguntaSeguridad::find($_POST['id']);

                if($preguntas->respuesta1 === $_POST['respuesta1'] && $preguntas->respuesta2 === $_POST['respuesta2']){
                    echo json_encode('correcto');
                }else{
                    echo json_encode('incorrecto');
                }
            }else{
                echo json_encode(['']);
            }
        }

        public static function cambiar_password(){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $usuario = Usuario::find($_POST['id']);

                $usuario->password = $_POST['password'];
                $usuario->hashPassword();

                $resultado = $usuario->guardar();

                if($resultado){
                    echo json_encode(['resultado' => 'exito']);
                }else{
                    echo json_encode(['resultado' => 'error']);
                }
            }
        }
    }
?>