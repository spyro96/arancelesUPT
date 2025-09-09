<?php

namespace Controllers;

use Dompdf\Dompdf;
use Model\Arancel;
use Model\Categorias;
use Model\DatosBancarios;
use Model\Solicitudes;
use Model\SolicitudesGestion;
use Model\SolicitudesCategorias;
use Model\Tasa;
use Model\UsuarioDatos;
use MVC\Router;
use Classes\Respaldo;
use DOMDocument;
use Model\BaucheEstudiante;
use Model\ReportesBolivares;
use Model\Solicitudes_detalles;

class DashboardController{

    public static function index(Router $router){
        $auth = is_admin();

        if(!$auth){
            header('Location: /');
        }

        $tasa = Tasa::find(1);

        $anio = Solicitudes_detalles::obtenerAniosDeRegistros();

        $query = "SELECT DISTINCT solicitudes_detalles.categoria FROM solicitudes_detalles WHERE solicitudes_detalles.estatus IN('listo', 'verificado')";

        $categorias = SolicitudesCategorias::consultarSQL($query);

        $router->render('admin/dashboard/index',[
            'script' => '<script src="/build/js/graficos.js" defer></script>',
            'titulo' => 'Panel de Inicio',
            'categorias' => $categorias,
            'tasa' => $tasa,
            'anio' => $anio
        ]);
    }

    public static function usuarios(Router $router){
        if(!isset($_SESSION)){
            session_start();
        }

        if($_SESSION['rol'] !== 'admin'){
            header('Location: /');
        }

        $query = "SELECT usuarios.correo, usuarios.rol, usuarios.estatus, 
        datos_personales.nombres, datos_personales.apellidos, datos_personales.telefono,
        datos_personales.nacionalidad, datos_personales.cedula, usuarios.id FROM
        datos_personales RIGHT OUTER JOIN usuarios ON
        datos_personales.usuarioId = usuarios.id";

        $usuarios = UsuarioDatos::usuarios($query);

        $router->render('admin/usuarios/index',[
            'usuarios' => $usuarios,
            'script' => '<script src="/build/js/dataTable/usuarioDataTable.js"></script>
                        <script src="/build/js/gestionUsuario.js" defer></script>',
            'titulo' => 'Gestionar Usuarios'
            
        ]);
    }

    public static function aranceles(Router $router){
        if(!isset($_SESSION)){
            session_start();
        }

        if($_SESSION['rol'] !== 'admin'){
            header('Location: /');
        }

        $aranceles = Arancel::all();

        $router->render('admin/aranceles/index',[
            'script' => '<script src="/build/js/dataTable/configDataTable.js"></script>
                        <script src="/build/js/gestionArancel.js" defer></script>',
            'titulo' => 'Gestionar Aranceles',
            'aranceles' => $aranceles
        ]);
    }

    public static function crear_arancel(Router $router){
        if(!isset($_SESSION)){
            session_start();
        }

        if($_SESSION['rol'] !== 'admin'){
            header('Location: /');
        }
        $categorias = Categorias::all();

        $tipo = [
            'dolar' => 'Dolar',
            'bolivares' => 'Bolívares'
        ];

        $estatus = [
            0 => 'Inactivo',
            1 => 'Activo'
        ];

        $arancel = new Arancel();

        $router->render('admin/aranceles/arancel', [
            'script' => '<script src="/build/js/gestionArancel.js" defer></script>',
            'titulo' => 'Crear Arancel',
            'categorias' => $categorias,
            'tipo' => $tipo,
            'estatus' => $estatus,
            'arancel' => $arancel
        ]);

        
    }

    public static function editar_arancel(Router $router){
        if(!isset($_SESSION)){
            session_start();
        }

        if($_SESSION['rol'] !== 'admin'){
            header('Location: /');
        }

        $id = intval($_GET['id']);
        
        $arancel = Arancel::find($id);

        $arancel->estatus = intval($arancel->estatus);

        $categorias = Categorias::all();

        $tipo = [
            'dolar' => 'Dolar',
            'bolivares' => 'Bolívares'
        ];

        $estatus = [
            0 => 'Inactivo',
            1 => 'Activo'
        ];

        $router->render('admin/aranceles/editar-arancel',[
            'script' => '<script src="/build/js/gestionArancel.js" defer></script>',
            'titulo'=>'Editar Arancel',
            'arancel' => $arancel,
            'categorias' => $categorias,
            'tipo' => $tipo,
            'estatus' => $estatus
        ]);
    }

    public static function solicitudes(Router $router){
        $auth = is_admin();
        
        if(!$auth){
            header('Location: /');
        }

        $query = "SELECT solicitudes_detalles.id AS id_solicitud, solicitudes_detalles.n_solicitud as n_control, solicitudes_detalles.aranceles, solicitudes_detalles.categoria, solicitudes_detalles.total AS monto, solicitudes_detalles.estatus, solicitudes_detalles.pnf, solicitudes_detalles.fecha_creacion, solicitudes_detalles.terceros, datos_personales.nombres, datos_personales.apellidos, datos_personales.telefono, datos_personales.cedula, datos_personales.cedula, datos_personales.usuarioId FROM solicitudes LEFT OUTER JOIN solicitudes_detalles ON solicitudes.solicitudes_detalles_id2 = solicitudes_detalles.id LEFT OUTER JOIN datos_personales ON solicitudes.datos_personalesId = datos_personales.id ORDER BY n_control DESC";

        $solicitudes = SolicitudesGestion::consultarSQL($query); 

        $router->render('admin/solicitudes/index',[
            'script' => '<script src="/build/js/dataTable/configDataTable.js"></script>
                        <script src="/build/js/gestionSolicitud.js"defer></script>',
            'titulo' => 'Gestionar Solicitudes',
            'solicitudes' =>  $solicitudes
        ]);
    }

    public static function ver_solcitud(Router $router){
        $auth = is_admin();
        
        if(!$auth){
            header('Location: /');
        }

        $id = intval($_GET['solicitud']);

        $solicitud = SolicitudesGestion::verSolicitud($id);

        //estudiante tercero
        $url = 'https://sigrece.uptbolivar.edu.ve/api/buscar-alumno';
        $id_modelo = $solicitud->id_modelo;
        $modelo = $solicitud->tipo_u_modelo;
        $full_url = $url . '?' . http_build_query(array('modelo' => $modelo, 'id' => $id_modelo));

        //peticion
        $response = curl_request($full_url);

        if($response === false){
            header('Location: /admin/solicitudes');
            return;
        }

        // Decodifica la respuesta JSON
        $estudiante = json_decode($response, true);

        $datosPagos = DatosBancarios::where('solicitudes_detalles_id', $solicitud->id_solicitud);

        if(strpos($solicitud->aranceles, ',') !== false){
            $solicitud->aranceles = explode(',' , $solicitud->aranceles);
        }

        
        if($_SESSION['rol'] === 'finanza'){
            $estatus = ['pendiente', 'verificado'];
        }else{
            $estatus = ['por pagar', 'pendiente', 'verificado', 'listo', 'expirado'];
        }
        
        $router->render('admin/solicitudes/solicitud',[
            'script' => '<script src="/build/js/gestionSolicitud.js" defer></script>',
            'titulo' => 'Ver Solicitud',
            'solicitud' => $solicitud,
            'estatus' => $estatus,
            'datosPagos' => $datosPagos,
            'estudiante' => $estudiante,
        ]);
    }

    public static function generar_bauche(){

        $auth = is_admin();
        
        if(!$auth){
            header('Location: /');
        }

        $id = intval($_GET['solicitud']);

        $query = "SELECT solicitudes.solicitudes_detalles_id2 AS id_solicitud, CONCAT(datos_personales.nombres, ' ', datos_personales.apellidos) AS nombre_completo, CONCAT(datos_personales.nacionalidad, '-', datos_personales.cedula) AS cedula, solicitudes_detalles.total AS monto, pagos.banco AS banco_emisor, solicitudes_detalles.categoria, solicitudes_detalles.aranceles, pagos.n_referencia, solicitudes_detalles.pnf, solicitudes_detalles.fecha_creacion, solicitudes_detalles.n_solicitud, datos_personales.usuarioId, solicitudes.id_modelo, solicitudes.tipo_u_modelo, solicitudes_detalles.terceros FROM solicitudes LEFT OUTER JOIN solicitudes_detalles ON solicitudes.solicitudes_detalles_id2 = solicitudes_detalles.id LEFT OUTER JOIN datos_personales ON solicitudes.datos_personalesId = datos_personales.id LEFT OUTER JOIN pagos ON pagos.solicitudes_detalles_id = solicitudes_detalles.id WHERE solicitudes.solicitudes_detalles_id2 = $id";

        $solicitud = BaucheEstudiante::consultarSQL($query);

        $solicitud = array_shift($solicitud);

        if(empty($solicitud)){
            header('Location: /admin/solicitudes');
        }

        //estudiante tercero
        $url = 'https://sigrece.uptbolivar.edu.ve/api/buscar-alumno';
        
        $id_modelo = $solicitud->id_modelo;
        $modelo = $solicitud->tipo_u_modelo;
        $full_url = $url . '?' . http_build_query(array('modelo' => $modelo, 'id' => $id_modelo));

        //peticion
        $response = curl_request($full_url);

        $estudiante = json_decode($response, true);

        $baucheDatos = $solicitud;
        
        //$imagen = $_SERVER['PHP_DOCUMENT_ROOT']."/public/img/banner-upt.png"; //hosting 000webhost
        $imagen = $_SERVER['DOCUMENT_ROOT']."\img\banner-upt.png";

        $imagenBase64 = "data:image/png;base64,". base64_encode(file_get_contents($imagen));

        include_once __DIR__ .'/../pdf/bauche.php';
        //echo $html;
        // instantiate and use the dompdf class
        //return;
        $dompdf = new Dompdf();

        //habilita la opcion en cargar imagenes
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', true);

        //$dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        
        $dompdf->setPaper('letter');
        $dompdf->render();

        $dompdf->stream($baucheDatos->n_solicitud . " - Voucher.pdf",array("Attachment" => 0));
    }

    public static function categorias(Router $router){

        if(!isset($_SESSION)){
            session_start();
        }

        if($_SESSION['rol'] !== 'admin'){
            header('Location: /');
        }

        $categorias = Categorias::all();

        foreach($categorias as $categoria){
            $categoria->nombre = ucfirst($categoria->nombre);
        }


        $router->render('admin/categorias/index',[
            'script' => '<script src="/build/js/dataTable/configDataTable.js"></script>
                        <script src="/build/js/categorias.js"defer></script>',
            'titulo'=>'Categorías',
            'categorias' =>  $categorias
        ]);
    }

    public static function respaldarBD(Router $router){
        if(!isset($_SESSION)){
            session_start();
        }

        if($_SESSION['rol'] !== 'admin'){
            header('Location: /');
        }

        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){


            date_default_timezone_set('America/Caracas');
            $error = '';
            
            $dia = date('d');
            $mes = date('m');
            $anio = date('Y');
            $hora = date('H-i-s');
            $fecha = $dia.'_'.$mes.'_'.$anio;
            $dataBase = $fecha.'_('.$hora.'_hrs).sql';
            $tablas = [];
            $resultado = Respaldo::sql('SHOW TABLES');

            if($resultado){
                while($row = $resultado->fetch_row()){
                    $tablas[] = $row[0];
                }
                $sql='SET FOREIGN_KEY_CHECKS=0;'."\n\n";
                $sql.='CREATE DATABASE IF NOT EXISTS '.$_ENV['DB_NAME'].";\n\n";
                $sql.='USE '.$_ENV['DB_NAME'].";\n\n";;
                foreach($tablas as $tabla){
                    $resultado=Respaldo::sql('SELECT * FROM '.$tabla);
                    if($resultado){
                        $numFields=mysqli_num_fields($resultado);
                        $sql.='DROP TABLE IF EXISTS '.$tabla.';';
                        $row2=mysqli_fetch_row(Respaldo::sql('SHOW CREATE TABLE '.$tabla));//devuelve un arreglo, nombre de la tabla y el sql create
                        $sql.="\n\n".$row2[1].";\n\n";
                        for ($i = 0; $i < $numFields; $i++) {
                            while ($row = mysqli_fetch_row($resultado)) {
                                $sql .= 'INSERT INTO ' . $tabla . ' VALUES (';
                                for ($j = 0; $j < $numFields; $j++) {
                                    $row[$j] = addslashes($row[$j]);
                                    $row[$j] = str_replace("\n", "\\n", $row[$j]);
                                    if (isset($row[$j])) {
                                        $sql .= '"' . $row[$j] . '"';
                                    } else {
                                        $sql .= '""';
                                    }
                                    if ($j < ($numFields - 1)) {
                                        $sql .= ',';
                                    }
                                }
                                $sql .= ");\n";
                            }
                        }
                        $sql.="\n\n\n";

                    }else{
                        $error=1;
                    }
                }
            }

            if($error==1){
                echo 'Ocurrio un error inesperado al crear la copia de seguridad';
            }else{

                if(!is_dir(__DIR__.'/../backup/')){
                    mkdir((__DIR__.'/../backup/'));
                }

                $ruta = __DIR__. '/../backup/';
                chmod($ruta, 0777);
                $sql.='SET FOREIGN_KEY_CHECKS=1;';
                $handle=fopen($ruta.$dataBase,'w+');
                if(fwrite($handle, $sql)){
                    fclose($handle);
                    Respaldo::setAlerta('exito','Copia de seguridad realizada con exito');
                }else{
                    Respaldo::setAlerta('error','Ocurrio un error inesperado al crear la copia de seguridad');
                }
            }
            $alertas = Respaldo::getAlertas();
        }

        $router->render('admin/backupBD/index',[
            'script' => '<script src="/build/js/restaurar.js" defer></script>',
            'titulo' => 'Gestión de Respaldo',
            'alertas' => $alertas
        ]);
    }

    public static function reportes(Router $router){
        $auth = is_admin();
        
        if(!$auth){
            header('Location: /');
        }

        $anio = '';
        
        $anio = date('Y');

        $reportes = Solicitudes_detalles::entradasBolivares($anio);

        $total = Solicitudes_detalles::sumaPorAnio($anio);

        if($total->total === NULL){
            $total->total = 0;
        }

        $years = Solicitudes_detalles::obtenerAniosDeRegistros();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $anio = $_POST['fecha'];
            $reportes = Solicitudes::entradasBolivares($anio);
            $total = Solicitudes::sumaPorAnio($anio);
        }

        $router->render('admin/reportes/index',[
            'script' => '<script src="/build/js/dataTable/configDataTable.js"></script>
                        <script src="/build/js/reportes.js" defer></script>',
            'titulo' => 'Reportes',
            'reportes' => $reportes,
            'years' => $years,
            'anio' => $anio,
            'total' => $total
        ]);
    }

    public static function pdf_reporte(){
        $auth = is_admin();
        
        if(!$auth){
            header('Location: /');
        }

        $anio = intval($_GET['anio']);
        
        $reportes = ReportesBolivares::balance($anio);

        $total = Solicitudes_detalles::sumaPorAnio($anio);
        
        //$imagen = $_SERVER['PHP_DOCUMENT_ROOT']."/public/img/banner-upt.png"; //hosting 000webhost
        $imagen = $_SERVER['DOCUMENT_ROOT']."\img\banner-upt.png";

        $imagenBase64 = "data:image/png;base64,". base64_encode(file_get_contents($imagen));

        include_once __DIR__ .'/../pdf/balance.php';
        //echo $html;
        // instantiate and use the dompdf class
        //return;
        $dompdf = new Dompdf();

        //habilita la opcion en cargar imagenes
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', true);

        //$dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        
        $dompdf->setPaper('letter', 'landscape');
        $dompdf->render();

        $dompdf->stream("Reportes-Aranceles-$anio.pdf",array("Attachment" => 0));
    }

    public static function perfil(Router $router){
        $auth = is_admin();

        if(!$auth){
            header('Location: /');
        }
        $router->render('admin/perfil', [
            'script' => '<script src="/build/js/perfil.js"></script>',
            'titulo' => 'Perfil'
        ]);       
    }

    public static function manual_admin(){
        session_start();
        if($_SESSION['rol'] !== 'admin'){
            header('Location: /');
        }

        //$archivo = $_SERVER['PHP_DOCUMENT_ROOT']. "/pdf/MANUAL.pdf";
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

    public static function solicitud_terceros(Router $router)
    {
        $auth = is_admin();

        if (!$auth) {
            header('Location: /');
        }

        $categorias = Categorias::all();

        $router->render('admin/solicitudes/solicitud-tercero', [
            'titulo' => 'solicitud a terceros',
            'categorias' => $categorias
        ]);
    }

    public static function cron()
    {
        session_start();

        if (empty($_SESSION)) {
            $db = mysqli_connect('localhost', 'root', '', 'sigea');

            $arrContextOption = [
                "ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false
                ]
            ];

            $url = file_get_contents('https://www.bcv.org.ve/', false, stream_context_create($arrContextOption));

            //creamos nuevo DOMDocument y cargamos la url

            $dom = new DOMDocument();
            @$dom->loadHTML($url);

            //obtenemos todos los divs y spans de la url
            $divs = $dom->getElementsByTagName('div');

            foreach ($divs as $div) {
                if ($div->getAttribute('id') === 'dolar') {
                    $tasa = $div->nodeValue;
                }
            }

            $fecha = date('d-m-Y');

            $tasa = preg_replace('/[^0-9,]/', '', $tasa); //raspamos y limpiamos los espacios vacios
            $tasa = str_replace(",", ".", $tasa);

            $tasa = round($tasa, 4);

            $dato = "Dato Cron"; //debe de aparecer este dato con el cron 

            $query = "UPDATE bcv SET `tasa` = $tasa, `fecha` = STR_TO_DATE('$fecha', '%d-%m-%Y') WHERE bcv.id = 1";

            $db->query($query);

            $db->close();
        }
    }
}
?>