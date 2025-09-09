<?php 
    namespace Controllers;

use Classes\Respaldo;
use Model\ActiveRecord;
use Model\Arancel;
use Model\Categorias;
use Model\DatosPersonales;
use Model\PreguntaSeguridad;
use Model\Solicitudes_detalles;
use Model\Usuario;
use Model\UsuarioDatos;

    class APIGestion extends ActiveRecord{

        public static function usuario_rol(){
            $id = intval($_POST['usuarioId']);

            $usuario = Usuario::find($id);

            $usuario->rol = $_POST['rol'];

            $resultado = $usuario->guardar();

            if($resultado){
                echo json_encode(['resultado'=> 'exito']);
            }else{
                echo json_encode(['resultado'=> 'error']);
            }

        }

        public static function eliminar_usuario(){

            $id = intval($_POST['id']);

            $usuario = Usuario::find($id);

            $resultado = $usuario->eliminar();

            if($resultado){
                echo json_encode(['resultado' => 'exito']);
            }else{
                echo json_encode(['resultado' => 'error']);
            }
        }

        public static function reset_user(){
            $auth = is_admin();
            if(!$auth){
                echo json_encode([]);
                return;
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $usuario = Usuario::find(intval($_POST['id']));

                $datosUsuario = DatosPersonales::where('usuarioId', intval($_POST['id']));

                $usuario->password = $datosUsuario->cedula;

                $usuario->hashPassword();

                $resultado = $usuario->guardar();

                if($resultado){
                    echo json_encode(['resultado' => 'exito']);
                }else{
                    echo json_encode(['resultado'=> 'error']);
                }
            }
        }
        
        public static function cambiar_estatus(){
            $id = intval($_POST['id']);

            $usuario = Usuario::find($id);

            $usuario->estatus = intval($_POST['nuevoEstatus']);

            $resultado = $usuario->guardar();

            if($resultado){
                echo json_encode(['resultado' => 'exito']);
            }else{
                echo json_encode(['resultado' => 'error']);
            }
        }

        public static function crear_arancel(){
            
            $existe = Arancel::where('nombre', $_POST['nombre']);

            if(isset($existe)){
                echo json_encode(['resultado' =>  'existe']);  
                return;
            }

            $arancel = new Arancel($_POST);

            $arancel->nombre = ucwords($arancel->nombre);
            
            $resultado = $arancel->guardar();

            if($resultado){
                echo json_encode(['resultado' => 'exito']);
            }else{
                echo json_encode(['resultado'=> 'error']);
            }
        }

        public static function editar_arancel(){
            
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $arancel = new Arancel($_POST);

                $arancel->estatus = intval($arancel->estatus);

                $arancel->guardar();

                if($arancel){
                    echo json_encode(['resultado' => 'exito']);
                }else{
                    echo json_encode(['resultado' => 'error']);
                }
            }
        }

        public static function eliminar_arancel(){

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $id = intval($_POST['id']);

                $arancel = Arancel::find($id);

                $resultado = $arancel->eliminar();

                if($resultado){
                    echo json_encode(['resultado' => 'exito']);
                }else{
                    echo json_encode(['resultado' => 'error']);
                }
            }
        }

        public static function actualizar_estatus(){
            $auth = is_admin();
            if(!$auth){
                echo json_encode([]);
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $id = intval($_POST['id']);

                $solicitud = Solicitudes_detalles::find($id);

                $solicitud->estatus = $_POST['estatus'];

                $resultado = $solicitud->guardar();

                if($resultado){
                    echo json_encode(['resultado' => 'exito']);
                }else{
                    echo json_encode(['resultado' => 'error']);
                }
            }
        }

        public static function obtener_categorias(){
            $auth = is_admin();
            if(!$auth){
                echo json_encode([]);
                return;
            }

            $categorias = Categorias::all();

            if($categorias){
                echo json_encode($categorias);
            }
        }

        public static function crear_categoria(){
            $auth = is_admin();
            if(!$auth){
                echo json_encode([]);
                return;
            } 

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $consulta = Categorias::where('nombre', $_POST['categoria']);

                if($consulta){
                    echo json_encode(['resultado' => 'existe']);
                    return;
                }

                $categoriaNueva = new Categorias();
                $categoriaNueva->nombre = $_POST['categoria'];
                
                $resultado = $categoriaNueva->guardar();

                if($resultado){
                    echo json_encode(['resultado'=> 'exito']);
                }else{
                    echo json_encode( ['resultado'=> 'error'] );
                }
            }
        }

        public static function  editar_categoria(){
            $auth = is_admin();
            if(!$auth){
                echo json_encode([]);
                return;
            }
            
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $categoria = new Categorias();

                $categoria->sincronizar($_POST);

                $resultado = $categoria->guardar();

                if($resultado){
                    echo json_encode(['resultado' => 'exito', 'categoria' => ucfirst($categoria->nombre)]);
                }
            }
        }

        public static  function eliminar_categoria(){
            $auth = is_admin();
            if(!$auth){
                echo json_encode([]);
                return;
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $categoria = Categorias::find( $_POST['id'] );

                $resultado = $categoria->eliminar();

                if($resultado){
                    echo json_encode( ['resultado'=>'exito']);
                }else{
                    echo json_encode( ['resultado'=>'error']);
                }
            }
        }

        public static function restaurarBD(){
            $auth = is_admin();
            if(!$auth){
                echo json_encode([]);
                return;
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                //$nombreArchivo = Respaldo::limpiarCadena($_POST['punto']);
                $nombreArchivo = $_POST['punto'];
                $nombreArchivo = str_replace("\\", "/", $nombreArchivo);
                $sql=explode(";",file_get_contents($nombreArchivo));
                
                $totalErrors=0;
                set_time_limit (60);
                $con=mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);
                $con->set_charset('utf8mb4');
                $con->query("SET FOREIGN_KEY_CHECKS=0");
                for($i = 0; $i < (count($sql)-1); $i++){
                    if($con->query($sql[$i].";")){  }else{ $totalErrors++; }
                }
                $con->query("SET FOREIGN_KEY_CHECKS=1");
                $con->close();
                if($totalErrors<=0){
                    echo json_encode(['resultado' => 'correcto']);
                }else{
                    echo json_encode(['resultado' => 'error']);
                }
            }
        }

        public static function cambiar_password(){
            $auth = is_admin();
            if(!$auth){
                echo json_encode([]);
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $id = intval($_POST['id']);
                $usuario = Usuario::find($id);

                $verificar = password_verify($_POST['passwordActual'], $usuario->password);
                
                if($verificar === false){
                    echo json_encode(['resultado' => 'incorrecto']);
                    return;
                }else{
                    $usuario->password = password_hash($_POST['passwordNuevo'], PASSWORD_BCRYPT);
                    
                    $resultado = $usuario->guardar();

                    if($resultado){
                        echo json_encode(['resultado' => 'exito']);
                    }else{
                        echo json_encode(['resultado' => 'error']);
                    }
                }
            }
        }

        public static function actualziar_preguntas(){
            $auth = is_admin();
            if(!$auth){
                echo json_encode([]);
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                
                $preguntas = PreguntaSeguridad::where('usuarioId', intval($_POST['usuarioId']));

                if($preguntas === null){
                    $preguntas = new PreguntaSeguridad($_POST);
                }else{
                    $preguntas->sincronizar($_POST);
                }

                $resultado = $preguntas->guardar();

                if($resultado){
                    echo json_encode(['resultado' => 'exito']);
                }else{
                    echo json_encode(['resultado' => 'error']);
                }
            }
        }
    }
?>