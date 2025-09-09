<?php
    namespace Model;
    
    class ReportePago extends ActiveRecord{
        protected static $tabla = 'solicitudes';
        protected static $columnasDB = ['datos_personalesId', 'nombre_completo', 'cedula', 'usuarioId', 'solicitudes_detalles_id2', 'aranceles', 'categoria', 'total', 'id_modelo', 'tipo_u_modelo'];

        public $datos_personalesId;
        public $nombre_completo;
        public $cedula;
        public $usuarioId;
        public $solicitudes_detalles_id2;
        public $aranceles;
        public $categoria;
        public $total;
        public $id_modelo;
        public $tipo_u_modelo;
    }
?>