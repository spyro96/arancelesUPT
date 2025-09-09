<?php

    namespace Model;

    class DatosPersonales extends ActiveRecord{
        protected static $tabla = 'datos_personales';
        protected static $columnasDB = ['id', 'nombres', 'apellidos', 'telefono', 'nacionalidad', 'cedula', 'usuarioId'];

        public $id;
        public $nombres;
        public $apellidos;
        public $telefono;
        public $nacionalidad;
        public $cedula;
        public $usuarioId;

        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->nombres = $args['nombres'] ?? '';
            $this->apellidos = $args['apellidos'] ?? '';
            $this->telefono = $args['telefono'] ?? '';
            $this->nacionalidad = $args['nacionalidad'] ?? '';
            $this->cedula = $args['cedula'] ?? '';
            $this->usuarioId = $args['usuarioId'] ?? '';
        }
    }

?>