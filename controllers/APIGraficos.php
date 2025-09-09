<?php

namespace Controllers;

use DateTime;
use IntlDateFormatter;
use Model\Solicitudes_detalles;
use Model\Tasa;

class APIGraficos
{

    public static function aranceles_cantidad(){
        $admin = is_admin();
        if(!$admin){
            echo json_encode([]);
            return;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $anio = $_POST['dato'] ?? date('Y');

            $aranceles = Solicitudes_detalles::graficaGeneral($anio);
    
            $generalArray = [];
            
            foreach ($aranceles as $dato) {
                $fecha = new DateTime($dato['mes']);
                $formato = new IntlDateFormatter('es-ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                $formato->setPattern('MMMM');
                $mes_formateada = ucfirst($formato->format($fecha));
                $dato['mes'] = $mes_formateada;
                $generalArray[] = $dato;
                $formato->setPattern('YYYY');
                $anio = $formato->format($fecha);
            }
    
            if($aranceles){
                echo json_encode(['datos' => $generalArray, 'anio' => $anio]);
            }
        }
    }

    public static function categoria_grafica(){

        $admin = is_admin();
        if(!$admin){
            echo json_encode([]);
            return;
        }

        if($_SERVER['REQUEST_METHOD']===  'POST'){
            $anio = $_POST['dato'] ?? date('Y');
            $solicitudes = Solicitudes_detalles::graficaPorCategoria($_POST['categoria'], $anio);

            $generalArray=[];
            foreach ($solicitudes as $solicitud) {
                $fecha = new DateTime($solicitud['fecha']);
                $formato = new IntlDateFormatter('es-ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                $formato->setPattern('MMMM');
                $mes_formateada = ucfirst($formato->format($fecha));
                $solicitud['fecha'] = $mes_formateada;
                $generalArray[] = $solicitud;
                $formato->setPattern('YYYY');
                $anio = $formato->format($fecha);
            }

            echo json_encode(['datos' => $generalArray, 'anio' => $anio]);
        }
    }

    public static function bolivares_grafica(){
        $admin = is_admin();
        if(!$admin){
            echo json_encode([]);
            return;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $anio = $_POST['anio'] ?? date('Y');

            $bolivares = Solicitudes_detalles::graficaBolivares($_POST['categoria'], $anio);

            $generalArray=[];
            foreach ($bolivares as $solicitud) {
                $fecha = new DateTime($solicitud['fecha']);
                $formato = new IntlDateFormatter('es-ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                $formato->setPattern('MMMM');
                $mes_formateada = ucfirst($formato->format($fecha));
                $solicitud['fecha'] = $mes_formateada;
                $generalArray[] = $solicitud;
                $formato->setPattern('YYYY');
                $anio = $formato->format($fecha);
            }

            echo json_encode($generalArray);
        }
    }

    public static function actualizar_tasa(){
        $admin = is_admin();
        if(!$admin){
            echo json_encode([]);
            return;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $dato = floatval($_POST['tasa']);

            $tasa = Tasa::find(1);

            $tasa->tasa = $dato;
            $tasa->fecha = date('Y-m-d');

            $fecha_mostrar = formatearFecha($tasa->fecha);

            $resultado = $tasa->guardar();

            if($resultado){
                echo json_encode(['resultado' => 'exito', 'fecha' => $fecha_mostrar]);
            }else{
                echo json_encode(['resultado' => 'error']);
            }
        }
    }

}