<?php
    namespace Model;

    class Solicitudes_detalles extends ActiveRecord{
        protected static $tabla = 'solicitudes_detalles';
        protected static $columnasDB = ['id', 'aranceles', 'categoria', 'total', 'estatus', 'pnf', 'n_solicitud', 'fecha_creacion', 'fecha_expiracion', 'hora', 'terceros'];

        public $id;
        public $aranceles;
        public $categoria;
        public $total;
        public $estatus = 'por pagar';
        public $pnf;
        public $n_solicitud;
        public $fecha_creacion;
        public $fecha_expiracion;
        public $hora;
        public $terceros = 0;

        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? null;
            $this->aranceles = $args['aranceles'] ?? '';
            $this->categoria = $args['categoria'] ?? '';
            $this->total = $args['precioTotal'] ?? '';
            $this->pnf = $args['pnf'] ?? '';
        }
    }

?>