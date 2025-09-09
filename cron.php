<?php

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
?>