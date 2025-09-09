<?php

define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function isExpired($fechaExpirada)
{
    $expiration_date = new DateTime($fechaExpirada);
    $now = new DateTime("now");

    if ($now > $expiration_date) {
        return true;
    } else {
       return false;
    }
}

function formatearFecha($dato, $formato = 'd/m/Y'){
    $fecha = DateTime::createFromFormat('Y-m-d', $dato);
    $fechaFormateada = $fecha->format($formato);
    return $fechaFormateada;
}

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function pagina_actual($path) : bool{
    return str_contains($_SERVER['REQUEST_URI'] ?? '/', $path) ? true : false;
}

function is_auth() : bool{
    if(!isset($_SESSION)){
        session_start();
    }
    return isset($_SESSION['email']) && !empty($_SESSION);
}


function is_admin() : bool{
    if(!isset($_SESSION)){
        session_start();
    }
    
    return isset($_SESSION) && $_SESSION['rol'] === "admin" || $_SESSION['rol'] === 'finanza';
}

function aos_animacion() : void{
    $efectos = ['fade-up', 'fade-down','fade-left', 'fade-right', 'flip-left', 'flip-right', 'zoom-in', 'zoom-in-up', 'zoom-in-down', 'zoom-out', 'zoom-in-right', 'zoom-out', 'zoom-out', 'zoom-out-left', 'zoom-out-right'];

    $efecto = array_rand($efectos, 1);

    echo ' data-aos="'. $efectos[$efecto] . '" ';
}

function fechaMesYAnio($valor, $formato = 'MMMM y')
{
    $date = new DateTime($valor);
    $formatter = new IntlDateFormatter(
        'es_ES',
        IntlDateFormatter::FULL,
        IntlDateFormatter::FULL,
        'Europe/Madrid',
        IntlDateFormatter::GREGORIAN,
        $formato
    );
    $formatted_date = $formatter->format($date);
    return $formatted_date;
}

function formatearAnio($fecha){
$timestamp = strtotime($fecha);
$anio = date('Y', $timestamp);

return $anio;
}

function curl_request($url, $retry_max = 3, $retry_delay = 2) {
    $ch = curl_init($url);
    // Configuración de la solicitud
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta como una cadena
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); // Establece el tipo de contenido en JSON
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // tiempo de espera de 30 segundos
    
    // Realiza la solicitud
    $response = curl_exec($ch);

    if (curl_errno($ch) === CURLE_OPERATION_TIMEOUTED && $retry_max > 0) {
        // tiempo de espera agotado, reintentar
        sleep($retry_delay);
        return curl_request($url, $retry_max - 1, $retry_delay);
    } elseif (curl_errno($ch)!== 0) {
        // otro error, no reintentar
        return false;
    } else {
        // petición exitosa, devuelve la respuesta
        return $response;
    }

    curl_close($ch);
}