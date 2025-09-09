<?php
    namespace Model;

    class Solicitudes_estudiantes extends ActiveRecord{
        protected static $tabla = 'solicitudes';
        protected static $columnasDB = ['id', 'datos_personalesId', 'solicitudesId'];

        public $id;
        public $datos_personalesId;
        public $solicitudesId;
    }

?>