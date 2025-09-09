<?php
    namespace Model;

    class ArancelPorMes extends ActiveRecord{
        protected static $tabla = 'solicitudes';
        protected static $columnas = ['mes', 'cantidad'];

        public $mes;
        public $cantidad;
    }
?>