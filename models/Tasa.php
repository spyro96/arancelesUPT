<?php

    namespace Model;

    class Tasa extends ActiveRecord{
        protected static $tabla = 'bcv';
        protected static $columnasDB = ['id', 'tasa', 'fecha'];

        public $id;
        public $tasa;
        public $fecha;
    }

?>