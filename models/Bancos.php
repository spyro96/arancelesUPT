<?php
    namespace Model;

    class Bancos extends ActiveRecord{
        protected static $tabla = 'bancos';
        protected static $columnasDB = ['id','codigo', 'banco'];

        public $id;
        public $codigo;
        public $banco;
    }

?>