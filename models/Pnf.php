<?php
    namespace Model;

    class Pnf extends ActiveRecord{
        protected static $tabla = "pnf";
        protected static $columnasDB = ['id', 'nombre'];

        public $id;
        public $nombre;
    }

?>