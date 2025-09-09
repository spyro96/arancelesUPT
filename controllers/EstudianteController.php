<?php

namespace Controllers;

use DateTime;
use Model\Arancel;
use Model\Bancos;
use Model\DatosPersonales;
use Model\Pnf;
use Model\ReportePago;
use Model\Solicitudes;
use Model\SolicitudEstudiante;
use Model\Usuario;
use MVC\Router;
use Model\Tasa;
use Dompdf\Dompdf;
use Model\BaucheEstudiante;
use Model\DatosBancarios;
use Model\Solicitudes_detalles;
use Model\Solicitudes_estudiantes;
use NumberFormatter;

class EstudianteController
{

    public static function index(Router $router)
    {
        $auth = is_auth();

        if (!$auth) {
            header('Location: /');
        }

        $datos_personales = DatosPersonales::where('usuarioId', $_SESSION['id']);

        $router->render('estudiante/index', [
            'datos_personales' => $datos_personales,
            'titulo' => 'Estudiante'
        ]);
    }

    public static function arancel(Router $router)
    {
        $auth = is_auth();

        if (!$auth) {
            header('Location: /');
        }

        $query = "SELECT * FROM bcv";

        $bcv = Tasa::SQL($query);

        $bcv->fecha = ucwords(fechaMesYAnio( $bcv->fecha,'d MMMM Y'));

        $id = $_SESSION['id'];

        $query = "SELECT categoria FROM aranceles";

        $categoriaArancel = Arancel::categoriasAranceles();

        foreach ($categoriaArancel as $categoria) {
            $categorias[] = $categoria->categoria;
        }

        $categorias = array_map('ucfirst', $categorias); //coloca la primera letra en mayusculas

        $query = "SELECT * FROM datos_personales WHERE usuarioId = '${id}';";

        $usuario = DatosPersonales::SQL($query);

        // $usuario->cedula = $usuario->nacionalidad. "-" .$usuario->cedula;
        $usuario->nacionalidad = ucfirst($usuario->nacionalidad);

        $pnfs = Pnf::all('ASC');

        $router->render('estudiante/arancel', [
            'bootstrap' => '<link rel="stylesheet" href="/build/css/bootstrap/bootstrap.min.css">',
            'bcv' => $bcv,
            'categorias' => $categorias,
            'categoriaArancel' => $categoriaArancel,
            'pnfs' => $pnfs,
            'usuario' => $usuario,
            'script' => '<script src="/build/js/arancel.js"></script>',
            'titulo' => 'Aranceles',
            'bootstrapJs' => '<script src="/build/js/bootstrap/bootstrap.min.js"></script>'
        ]);
    }

    public static function solicitudes(Router $router)
    {

        $auth = is_auth();

        if (!$auth) {
            header('Location: /');
        }

        $id = intval($_SESSION['id']);

        $query = "SELECT solicitudes_detalles.id AS id_solicitud, solicitudes_detalles.aranceles, solicitudes_detalles.categoria, solicitudes_detalles.total, solicitudes_detalles.estatus, solicitudes_detalles.pnf, solicitudes_detalles.n_solicitud, solicitudes_detalles.fecha_creacion, solicitudes_detalles.fecha_expiracion, solicitudes_detalles.hora, datos_personales.usuarioId, solicitudes_detalles.terceros FROM solicitudes LEFT OUTER JOIN solicitudes_detalles ON solicitudes.solicitudes_detalles_id2 = solicitudes_detalles.id LEFT OUTER JOIN datos_personales ON solicitudes.datos_personalesId = datos_personales.id WHERE datos_personales.usuarioId = $id ORDER BY solicitudes.id DESC;";

        $solicitudes = SolicitudEstudiante::solicitudes_estudiantes($query);

        $resultado = Solicitudes::total_porPagar($id);

        $cantidad = intval($resultado);

        //averiguar como hacer que cuando expira cambie el estatus expirado
        if ($cantidad > 0) {

            foreach ($solicitudes as $datos) {
                $fechaExpiracion = $datos->fecha_expiracion . " " . $datos->hora;

                $expirado = isExpired($fechaExpiracion);

                if ($expirado === true && $datos->estatus === "por pagar") {
                    $datos->estatus = 'expirado';

                    $solicitud = new Solicitudes_detalles();
                    $solicitud->sincronizar($datos);
                    $solicitud->id = $datos->id_solicitud;
                    $solicitud->guardar();
                }
            }
        }

        $script = '<script src="/build/js/solicitudes.js"></script>';

        $dataTablecss = '<link rel="stylesheet" href="/build/dataTable/css/datatables.min.css">';

        $dataTable = '<script src="/build/js/dataTable/jquery-3.7.1.min.js"></script>';
        $dataTable .= '<script src="/build/dataTable/js/datatables.min.js"></script>';
        $dataTable .= '<script src="/build/js/dataTable/configDataTable.js"></script>';

        $router->render('estudiante/solicitudes', [
            'bootstrap' => '<link rel="stylesheet" href="/build/css/bootstrap/bootstrap.min.css">',
            'titulo' => 'Solicitudes',
            'solicitud_estudiante' => $solicitudes,
            'script' => $script,
            'dataTable' => $dataTable,
            'dataTablecss' => $dataTablecss,
            'bootstrapJs' => '<script src="/build/js/bootstrap/bootstrap.min.js"></script>
                                <script src="/build/js/bootstrap/tooltip.js" defer></script>'
        ]);
    }

    public static function reportar_pago(Router $router)
    {

        $auth = is_auth();
        $estudiante = '';
        if (!$auth) {
            header('Location: /');
        }

        $idArancel = intval($_GET['estudiante']);
        $idUsuario = intval($_SESSION['id']);

        $query = "SELECT solicitudes.datos_personalesId, CONCAT(datos_personales.nombres, ' ', datos_personales.apellidos) AS nombre_completo, CONCAT(datos_personales.nacionalidad, '-', datos_personales.cedula) AS cedula, datos_personales.usuarioId, solicitudes.id_modelo, solicitudes.tipo_u_modelo, solicitudes.solicitudes_detalles_id2, solicitudes_detalles.aranceles, solicitudes_detalles.categoria, solicitudes_detalles.total FROM solicitudes LEFT OUTER JOIN datos_personales ON solicitudes.datos_personalesId = datos_personales.id LEFT OUTER JOIN solicitudes_detalles ON  solicitudes.solicitudes_detalles_id2 = solicitudes_detalles.id WHERE solicitudes.solicitudes_detalles_id2 = $idArancel AND datos_personales.usuarioId = $idUsuario";

        $detalles = ReportePago::SQL($query);
        
        $solicitud = Solicitudes_detalles::find($detalles->solicitudes_detalles_id2);

        if(is_null($detalles)){
            header('Location: /estudiante/solicitudes');
            return;
        }

        if ($detalles->usuarioId !== $_SESSION['id'] || $solicitud->estatus !== 'por pagar') {
            header('Location: /estudiante/solicitudes');
            return;
        }
        
        //consulta a la base de datos de sigrece
        $url = 'https://sigrece.uptbolivar.edu.ve/api/buscar-alumno';
        $modelo = $detalles->tipo_u_modelo;
        $id_modelo = $detalles->id_modelo;
        $full_url = $url . '?' . http_build_query(array('modelo' => $modelo, 'id' => $id_modelo));

        $response = curl_request($full_url);
        
        $estudiante = json_decode($response, true);
        
        $bancos = Bancos::all('ASC');

        $router->render('estudiante/reportar_pago', [
            'script' => '<script src="/build/js/reportarPago.js" defer></script>',
            'titulo' => 'Reporte de pago',
            'detalles' => $detalles,
            'bancos' =>  $bancos,
            'solicitud' => $solicitud,
            'estudiante' => $estudiante
        ]);
    }

    public static function datos_personales(Router $router)
    {
        $alertas = [];
        $auth = is_auth();

        if (!$auth) {
            header('Location: /');
        }

        $datos_personales = DatosPersonales::where('usuarioId', $_SESSION['id']);

        $pnfs = Pnf::all('ASC');

        $nacionalidad = [
            'V' => 'Venezolano(a)',
            'E' => 'Extranjero(a)',
            'P' => 'Pasaporte'
        ];

        if ($datos_personales) {
            $nombre = explode(" ", $datos_personales->nombres);
            $apellido = explode(" ", $datos_personales->apellidos);

            $datos_personales->{'nombre1'} = ucfirst($nombre[0]);
            $datos_personales->{'nombre2'} = ucwords($nombre[1]) ?? '';
            $datos_personales->{'apellido1'} = ucwords($apellido[0]);
            $datos_personales->{'apellido2'} = ucwords($apellido[1]) ?? '';

            unset($datos_personales->nombres);
            unset($datos_personales->apellidos);
        }

        $router->render('estudiante/datos-personales', [
            'script' => '<script src="/build/js/iziToast.min.js"defer></script>
                             <script src="/build/js/datosPersonales.js"defer></script>',
            'alertas' => $alertas,
            'titulo' => 'Datos Personales',
            'datos_personales' => $datos_personales,
            'pnfs' => $pnfs,
            'nacionalidad' => $nacionalidad
        ]);
    }

    public static function preguntas(Router $router)
    {

        $auth = is_auth();
        if (!$auth) {
            header('Location: /');
        }

        $router->render('estudiante/preguntas', [
            'script' => '<script src="/build/js/iziToast.min.js"defer></script>
                             <script src="/build/js/preguntas-seguridad.js"defer></script>',
            'titulo' => 'Preguntas de Seguridad'
        ]);
    }

    public static function password(Router $router)
    {
        $alertas = [];

        $auth = is_auth();

        if (!$auth) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario = Usuario::where('id', $_SESSION['id']);

            //sicroniza los datos
            $usuario->sincronizar($_POST);

            //comprueba la contraseña actual
            $comprobar_password = $usuario->comprobar_password($usuario->password_actual);

            if (!$comprobar_password) {
                Usuario::setAlerta('error', 'La contraseña actual no es correcta');
            } else {
                $usuario->password = $usuario->password_nuevo;

                unset($usuario->password_nuevo);
                unset($usuario->password_actual);

                $usuario->hashPassword();

                $resultado = $usuario->guardar();

                if ($resultado) {
                    Usuario::setAlerta('exito', 'Contraseña Actualizada Correctamente!');
                } else {
                    Usuario::setAlerta('error', 'Error en Actualizar la contraseña');
                }
            }
            $alertas = Usuario::getAlertas();
        }
        $router->render('estudiante/password', [
            'script' => '<script src="/build/js/password.js" defer></script>',
            'alertas' => $alertas,
            'titulo' => 'Reestablecer Contraseña'
        ]);
    }

    public static function generar_bauche()
    {
        $auth = is_auth();
        if (!$auth) {
            header('Location: /');
        }
        $id = intval($_GET['estudiante']);
        $idUsuario = intval($_SESSION['id']);

        $query = "SELECT solicitudes.solicitudes_detalles_id2 AS id_solicitud, CONCAT(datos_personales.nombres, ' ', datos_personales.apellidos) AS nombre_completo, CONCAT(datos_personales.nacionalidad, '-', datos_personales.cedula) AS cedula, solicitudes_detalles.total AS monto, pagos.banco AS banco_emisor, solicitudes_detalles.categoria, solicitudes_detalles.aranceles, pagos.n_referencia, solicitudes_detalles.pnf, solicitudes_detalles.fecha_creacion, solicitudes_detalles.n_solicitud, datos_personales.usuarioId, solicitudes.id_modelo, solicitudes.tipo_u_modelo, solicitudes_detalles.terceros FROM solicitudes LEFT OUTER JOIN solicitudes_detalles ON solicitudes.solicitudes_detalles_id2 = solicitudes_detalles.id LEFT OUTER JOIN datos_personales ON solicitudes.datos_personalesId = datos_personales.id LEFT OUTER JOIN pagos ON pagos.solicitudes_detalles_id = solicitudes_detalles.id WHERE solicitudes.solicitudes_detalles_id2 = $id AND datos_personales.usuarioId = $idUsuario";

        $baucheDatos = BaucheEstudiante::SQL($query);

        if (!$baucheDatos) {
            header('Location: /estudiante/solicitudes');
        }

        //estudiante tercero
        $url = 'https://sigrece.uptbolivar.edu.ve/api/buscar-alumno';
        $modelo = $baucheDatos->tipo_u_modelo;
        $id_modelo = $baucheDatos->id_modelo;
        $full_url = $url . '?' . http_build_query(array('modelo' => $modelo, 'id' => $id_modelo));

        $response = curl_request($full_url);

        // Decodifica la respuesta JSON
        $estudiante = json_decode($response, true);

        // $response = file_get_contents($full_url);
        // $estudiante = json_decode($response, true) ?? '';
        //formatear el monto
        $formatearNumero = new NumberFormatter('es-ES', NumberFormatter::DECIMAL);
        //asignar el dato formateado en el objeto
        $baucheDatos->monto = $formatearNumero->format($baucheDatos->monto);

        // Include the main TCPDF library (search for installation path).
        //$imagen = $_SERVER['PHP_DOCUMENT_ROOT']."/public/img/banner-upt.png"; //hosting 000webhost
       $imagen = $_SERVER['DOCUMENT_ROOT'] . "\img\banner-upt.png";

        $imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($imagen));

        include_once __DIR__ . '/../pdf/bauche.php';
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

        $dompdf->stream("bauche.pdf", array("Attachment" => 0));
    }

    public static function manual_estudiante(){
        $auth = is_auth();
        if (!$auth) {
            header('Location: /');
        }

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
