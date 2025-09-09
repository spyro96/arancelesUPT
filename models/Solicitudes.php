<?php
    namespace Model;

    class Solicitudes extends ActiveRecord{
        protected static $tabla = 'solicitudes';
        protected static $columnasDB = ['id', 'datos_personalesId', 'solicitudes_detalles_id2', 'tipo_u_modelo', 'id_modelo'];

        public $id;
        public $datos_personalesId;
        public $solicitudes_detalles_id2;
        public $tipo_u_modelo;
        public $id_modelo;
    }

?>