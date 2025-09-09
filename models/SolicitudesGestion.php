<?php 
    namespace Model;

    class SolicitudesGestion extends ActiveRecord{
        protected static $tabla = 'solicitudes';
        protected static $columnasDB = ['id_solicitud', 'aranceles', 'categoria', 'monto', 'estatus', 'pnf', 'n_control', 'fecha_creacion', 'nombres', 'apellidos', 'telefono', 'nacionalidad', 'cedula', 'usuarioId', 'id_modelo', 'tipo_u_modelo', 'terceros', 'terceros'];

        public $id_solicitud;
        public $aranceles;
        public $categoria;
        public $monto;
        public $estatus;
        public $pnf;
        public $n_control;
        public $fecha_creacion;
        public $nombres;
        public $apellidos;
        public $telefono;
        public $nacionalidad;
        public $cedula;
        public $usuarioId;
        public $id_modelo;
        public $tipo_u_modelo;
        public $terceros;
    }
?>