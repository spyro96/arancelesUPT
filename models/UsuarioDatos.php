<?php
    namespace Model;

    class UsuarioDatos extends ActiveRecord{
        protected static $tabla = 'datos_personales';
        protected static $columnasDB = ['correo','rol', 'estatus', 'nombres', 'apellidos', 'telefono', 'nacionalidad', 'cedula', 'id'];

        public $correo;
        public $rol;
        public $estatus;
        public $nombres;
        public $apellidos;
        public $telefono;
        public $nacionalidad;
        public $cedula;
        public $id;
    }

?>