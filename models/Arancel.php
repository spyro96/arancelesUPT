<?php
    namespace Model;

    class Arancel extends ActiveRecord{
        protected static $tabla = 'aranceles';
        protected static $columnasDB = ['id', 'nombre', 'precio', 'categoria', 'estatus', 'tipo'];

        public $id;
        public $nombre;
        public $precio;
        public $categoria;
        public $estatus;
        public $tipo;

        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->nombre = $args['nombre'] ?? '';
            $this->precio = $args['precio'] ?? '';
            $this->categoria = $args['categoria'] ?? '';
            $this->estatus = $args['estatus'] ?? 1;
            $this->tipo = $args['tipo'] ?? '';
        }
    }

?>