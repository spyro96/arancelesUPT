<?php
    namespace Model;

    class DatosBancarios extends ActiveRecord{
        protected static $tabla = 'pagos';
        protected static $columnasDB = ['id', 'n_referencia', 'imagen', 'banco', 'solicitudes_detalles_id'];

        public $id;
        public $n_referencia = '0';
        public $imagen = 'imagen.jpg';
        public $banco = "notificar";
        public $solicitudes_detalles_id = '';
    }

?>