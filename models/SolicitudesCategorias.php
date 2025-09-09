<?php
    namespace Model;

use Model\ActiveRecord;

    class SolicitudesCategorias extends ActiveRecord{
        protected static $tabla = 'solicitudes_detalles';
        protected static $columnasDB = ['categoria'];

        public $categoria;
    }

?>