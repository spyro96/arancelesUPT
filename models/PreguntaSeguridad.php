<?php

    namespace Model;

    class PreguntaSeguridad extends ActiveRecord{
        protected static $tabla = 'preguntas_seguridad';
        protected static $columnasDB = ['id', 'pregunta1', 'respuesta1', 'pregunta2', 'respuesta2', 'usuarioId'];

        public $id;
        public $pregunta1;
        public $respuesta1;
        public $pregunta2;
        public $respuesta2;
        public $usuarioId;

        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->pregunta1 = $args['pregunta1'] ?? '';
            $this->respuesta1 = $args['respuesta1'] ?? '';
            $this->pregunta2 = $args['pregunta2'] ?? '';
            $this->respuesta2 = $args['respuesta2'] ?? '';
            $this->usuarioId = $args['usuarioId'] ?? '';
        }
    }
?>