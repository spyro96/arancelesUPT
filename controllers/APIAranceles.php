<?php
    namespace Controllers;

use Model\Pagos;
use Model\Pnf;
use Model\Arancel;
use Model\Solicitudes;
use Model\DatosBancarios;
use Model\Solicitudes_detalles;
use Intervention\Image\ImageManagerStatic as Image;

    class APIAranceles{

        public static function index(){
            $auth = is_auth();
            if(!$auth){
                header('Location: /estudiante/dashboard');
                return;
            }

            // $arrContextOption = [
            //     "ssl" => [
            //         "verify_peer" => false,
            //         "verify_peer_name" => false
            //     ]
            // ];

            // $url = file_get_contents('https://www.bcv.org.ve/', false, stream_context_create($arrContextOption));  
            
            //creamos nuevo DOMDocument y cargamos la url

            // $dom = new DOMDocument();
            // @$dom->loadHTML($url);

            //obtenemos todos los divs y spans de la url
            // $divs = $dom->getElementsByTagName('div');

            // foreach($divs as $div){
            //     if($div->getAttribute('id') === 'dolar'){
            //         $tasa = $div->nodeValue;
            //     }
            // }    

            // $tasa = preg_replace('/[^0-9,]/', '', $tasa); //raspamos y limpiamos los espacios vacios
            // $tasa = str_replace(",", ".", $tasa);

            // $tasa = round($tasa, 2);

            $array = [
                'categoria' => $_POST['categoria'],
                'estatus' => 1
            ];

            $aranceles = Arancel::whereArray($array);
            
           // $aranceles = Arancel::arancel_categoria($_POST['categoria']);
            //$tasa = 36.14;
            
            // echo json_encode(['aranceles'=>$aranceles, 'tasa'=>$tasa]);
            echo json_encode(['aranceles'=>$aranceles]);
        }

        public static function solicitud(){
            date_default_timezone_set("America/Caracas");
            $auth = is_auth();
            if(!$auth){
                // header('Location: /estudiante/dashboard');
                echo json_encode(['']);
                return;
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                
                $solicitud_anterior = Solicitudes_detalles::ultimo_arancel();

                $solicitud_detalles = new Solicitudes_detalles($_POST);
    
                $solicitud_detalles->fecha_creacion = date('Y-m-d');
                $solicitud_detalles->fecha_expiracion = date('Y-m-d', strtotime('+1 day', strtotime($solicitud_detalles->fecha_creacion)));
                $solicitud_detalles->hora = date('H:i');
    
                if($solicitud_anterior){
                //str_pad — Rellena un string hasta una longitud determinada con otro string
                $dato = str_pad(strval(intval($solicitud_anterior->n_solicitud) + 1), 5, '0', STR_PAD_LEFT);
                $solicitud_detalles->n_solicitud = $dato;
                }else{
                    $solicitud_detalles->n_solicitud = '00001';
                }

                $solicitud_detalles->terceros = $_POST['dirigido'] === 'terceros' ? 1 : 0;
    
                $solicitud_detalles->aranceles = str_replace(',', ', ', $solicitud_detalles->aranceles);

                $resultado = $solicitud_detalles->guardar();
    
                if(!$resultado['id']){
                    echo json_encode(['resultado' => 'error']);
                    return;
                }
    
                $solicitudes_detalles_id = $resultado['id'];
    
                $solicitudes = new Solicitudes();
    
                $solicitudes->datos_personalesId = $_POST['usuario'];
                $solicitudes->solicitudes_detalles_id2 = $solicitudes_detalles_id;
                $solicitudes->tipo_u_modelo = $_POST['modelo'];
                $solicitudes->id_modelo = $_POST['idModelo'];

                $resultado = $solicitudes->guardar();
    
                if(!$resultado['id']){
                    echo json_encode(['resultado' => 'error']);
                    return;
                }
    
                $informacion_bancaria = new Pagos();
    
                $informacion_bancaria->solicitudes_detalles_id = $solicitudes_detalles_id;
    
                $resultado = $informacion_bancaria->guardar();
    
                if($resultado){
                    echo json_encode(['resultado' => 'exito']);
                }else{
                    echo json_encode(['resultado' => 'error']);
                }
            }
        }

    public static function reportar_pago(){
        
        $idSolicitud = intval($_POST['id']);
        
        $query = "SELECT * FROM pagos WHERE solicitudes_detalles_id = $idSolicitud";
        $pagos = DatosBancarios::SQL($query);

        $pagos->banco = $_POST['banco'];
        $pagos->n_referencia = $_POST['referencia'];

        // Generar un nombre único
        // $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        if(!empty($_FILES)){
            if ($_FILES['bauche']['tmp_name']) {
                $image = Image::make($_FILES['bauche']['tmp_name'])->resize(800, 800);
                $image->encode('jpg', 75);

                $data = $image->encode('data-url');

                $pagos->imagen = $data->encoded;
                // Crear la carpeta para subir imagenes
                // if (!is_dir(CARPETA_IMAGENES)) {
                //     mkdir(CARPETA_IMAGENES);   
                // }
    
                // Guarda la imagen en el servidor
                // $image->save(CARPETA_IMAGENES . $nombreImagen);
                // $datosBancarios->imagen = $nombreImagen;
            }
        }

        $respuesta = $pagos->guardar();

        if(!$respuesta){
            echo json_encode(['respuesa'=> 'error']);
            return;
        }

        $solicitud = Solicitudes_detalles::find($idSolicitud);
        
        $solicitud->estatus = 'pendiente';
        $respuesta = $solicitud->guardar();
        if($respuesta){
            echo json_encode(['respuesta' => 'correcto']);
        }else{
            echo json_encode(['respuesa'=> 'error']);
        }
    }

    public static function consultar_estatus(){
        $id = intval($_POST['id']);
        $solicitud = Solicitudes_detalles::find($id);

        echo json_encode( ['solicitud' => $solicitud] );
    }

    public static function consulta_propia (){

    }
    
    public static function obtener_pnf(){
        $auth = is_auth();

        if(!$auth){
            echo json_encode(['']);
            return;
        }

        $pnfs = Pnf::all('ASC');

        echo json_encode($pnfs);
    }
}

?>