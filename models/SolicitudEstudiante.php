<?php
    namespace Model;

    class SolicitudEstudiante extends ActiveRecord{
        protected static $tabla = 'solicitudes';
        protected static $columnasDB = ['id_solicitud', 'aranceles', 'categoria', 'total','estatus', 'fecha_creacion', 'fecha_expiracion', 'hora', 'usuarioId', 'terceros', 'n_solicitud'];

        public $id_solicitud;
        public $aranceles;
        public $categoria;
        public $total;
        public $estatus;
        public $pnf;
        public $fecha_creacion;
        public $fecha_expiracion;
        public $hora;
        public $usuarioId;
        public $n_solicitud;
        public $terceros;
    }
?>