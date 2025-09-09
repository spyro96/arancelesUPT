<?php
    namespace Model;

    class ReportesBolivares extends ActiveRecord{
        protected static $tabla = 'solicitudes';
        protected static $columnasDB = ['nombre_completo', 'cedula', 'monto', 'aranceles', 'n_referencia', 'pnf', 'fecha', 'n_solicitud'];

        public $nombre_completo;
        public $cedula;
        public $monto;
        public $aranceles;
        public $n_referencia;
        public $pnf;
        public $fecha;
        public $n_solicitud;
    }
?>