<?php

    namespace Model;

    class BaucheEstudiante extends ActiveRecord{
        protected static $tabla = 'solicitudes';
        protected static $columnasDB = ['id_solicitud', 'nombre_completo', 'cedula', 'monto', 'banco_emisor', 'categoria', 'aranceles', 'n_referencia', 'pnf', 'fecha', 'n_solicitud', 'usuarioId', 'id_modelo', 'tipo_u_modelo', 'terceros'];

        public $id_solicitud;
        public $nombre_completo;
        public $cedula;
        public $monto;
        public $banco_emisor;
        public $categoria;
        public $aranceles;
        public $n_referencia;
        public $pnf;
        public $fecha_creacion;
        public $n_solicitud;
        public $usuarioId;
        public $id_modelo;
        public $tipo_u_modelo;
        public $terceros;
    }
?>