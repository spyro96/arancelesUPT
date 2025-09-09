<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    // Setear un tipo de Alerta
    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Obtener las alertas
    public static function getAlertas() {
        return static::$alertas;
    }

    // Validación que se hereda en modelos
    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria (Active Record)
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();
        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
    
    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
            
        }
        return $resultado;
    }

    // consulta Plana de SQL (utilizar cuando los metodos del modelo no son suficites)
    public static function SQL($query) {
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }
    //consulta las categorias del arancel y elimina datos duplicados 
    public static function categoriasAranceles() {
        $query = "SELECT DISTINCT categoria FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Obtener todos los Registros
    public static function all($orden = 'DESC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id ${orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Obtener todos los Usuarios
    public static function usuarios($query){
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Obtener todos los Registros
    public static function ultimo_arancel($orden = 'DESC')
    {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id ${orden}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Obtener todos los Registros
    public static function solicitudes_estudiantes($query) {
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function obtener_solicitudes_porPagar($id){
        $query = "SELECT * FROM solicitudes_estudiantes LEFT OUTER JOIN solicitudes ON solicitudes_estudiantes.solicitudesId = solicitudes.id LEFT OUTER JOIN datos_personales ON solicitudes_estudiantes.datos_personalesId = datos_personales.id WHERE usuarioId = ${id} AND estatus = 'por pagar';";

        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Busca un registro por su correo
    public static function findEmail($correo) {
        $query = "SELECT * FROM " . static::$tabla  . " WHERE correo = '${correo}'";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite} ORDER BY id DESC" ;
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    //retornar los registros por un orden
    public static function ordenar($columna, $orden){
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY ${columna} ${orden}" ;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busqueda Where con una Columna 
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
        return  array_shift($resultado) ;
    }

    // Busqueda de arancel por categoria
    public static function arancel_categoria($categoria) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE categoria = '${categoria}'";
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }

    //consulta cuantos hay por pagar de acuerdo el id
    public static function total_Porpagar($id) {
        $query = "SELECT COUNT(*) FROM ". static::$tabla ." LEFT OUTER JOIN datos_personales ON solicitudes.datos_personalesId = datos_personales.id LEFT OUTER JOIN solicitudes_detalles ON solicitudes.solicitudes_detalles_id2 = solicitudes_detalles.id WHERE datos_personales.usuarioId = ${id} AND solicitudes_detalles.estatus = 'por pagar'";
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();
        return  array_shift($total);
    }

    //busqueda Where con multiples opciones
    public static function whereArray($array = []) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ";
        foreach($array as $key => $value){
            if($key == array_key_last($array)){//array_key_last devuele la llave del ultimo arreglo
                $query .= "${key} = '${value}'";
            }else{
                $query .= "${key} = '${value}' AND ";
            }
        }
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function verSolicitud($id){
        $query = "SELECT solicitudes_detalles.id AS id_solicitud, solicitudes_detalles.aranceles, solicitudes_detalles.categoria, solicitudes_detalles.total AS monto, solicitudes_detalles.estatus, solicitudes_detalles.pnf, solicitudes.tipo_u_modelo, solicitudes.id_modelo, solicitudes_detalles.n_solicitud AS n_control, solicitudes_detalles.fecha_creacion, datos_personales.nombres, datos_personales.apellidos, datos_personales.telefono, datos_personales.nacionalidad, datos_personales.cedula, datos_personales.usuarioId, solicitudes_detalles.terceros FROM " .static::$tabla ." LEFT OUTER JOIN solicitudes_detalles ON solicitudes.solicitudes_detalles_id2 = solicitudes_detalles.id LEFT OUTER JOIN datos_personales ON solicitudes.datos_personalesId = datos_personales.id WHERE solicitudes.solicitudes_detalles_id2 = $id";

        $resultado = self::consultarSQL($query);
        
        return array_shift($resultado);
    }

    //obtener balance de bolivares por el año ingresado
    public static function entradasBolivares($year){
        $query = "SELECT * FROM solicitudes_detalles WHERE solicitudes_detalles.estatus IN('listo', 'verificado') AND YEAR(solicitudes_detalles.fecha_creacion) = $year";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //obtener los años registrados de los aranceles
    public static function obtenerAniosDeRegistros(){
        $query = "SELECT DISTINCT YEAR(solicitudes_detalles.fecha_creacion) AS year FROM ".static::$tabla. " ORDER BY year DESC";
        $resultado = self::$db->query($query);

        $datos = [];
        while($registro = $resultado->fetch_assoc()){
            $datos[] = self::crearObjetoPropio($registro);
        }

        return $datos;
    }
    
    public static function sumaPorAnio($valor){
        $query = "SELECT SUM(CAST(solicitudes_detalles.total AS DECIMAL(8, 2))) AS total FROM ". static::$tabla ." WHERE solicitudes_detalles.estatus IN('listo', 'verificado') AND YEAR(solicitudes_detalles.fecha_creacion) = $valor";

        $resultado = self::$db->query($query);

        $datos = $resultado->fetch_object();

        return $datos;
    }

    public static function balance($valor){

        $query = "SELECT CONCAT(datos_personales.nombres, ' ', datos_personales.apellidos) AS nombre_completo, CONCAT(datos_personales.nacionalidad, '-', datos_personales.cedula) AS cedula, solicitudes_detalles.total AS monto, solicitudes_detalles.aranceles, pagos.n_referencia, solicitudes_detalles.pnf, solicitudes_detalles.fecha_creacion AS fecha, solicitudes_detalles.n_solicitud FROM ".static::$tabla." LEFT JOIN datos_personales ON solicitudes.datos_personalesId = datos_personales.id LEFT JOIN solicitudes_detalles ON solicitudes.solicitudes_detalles_id2 = solicitudes_detalles.id LEFT JOIN pagos ON pagos.solicitudes_detalles_id = solicitudes_detalles.id WHERE solicitudes_detalles.estatus IN ('listo', 'verificado') AND YEAR(solicitudes_detalles.fecha_creacion) = $valor";

        $resultado = self::consultarSQL($query);
        return $resultado;
    }
        

    //consultar cantidad de aranceles por mes
    public static function graficaGeneral($valor){
        $query = "SELECT DATE_FORMAT(fecha_creacion, '%Y-%m') as mes, COUNT(*) as cantidad FROM ".static::$tabla." WHERE solicitudes_detalles.estatus IN ('listo','verificado') AND YEAR(solicitudes_detalles.fecha_creacion) = $valor GROUP BY mes ORDER BY mes" ;

        // $resultado = self::consultarSQL($query);
        $resultado = self::$db->query($query);
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = self::crearObjetoPropio($registro);
        }
        return $array;
        // return $resultado;
    }

    public static function graficaPorCategoria($categoria, $anio){
        $query = "SELECT DATE_FORMAT(solicitudes_detalles.fecha_creacion, '%Y-%m') AS fecha, COUNT(*) AS total FROM ".static::$tabla." WHERE solicitudes_detalles.estatus IN ('listo', 'verificado') AND YEAR(solicitudes_detalles.fecha_creacion) = $anio AND solicitudes_detalles.categoria = '$categoria' GROUP BY fecha ORDER BY fecha ASC";

        $resultado = self::$db->query($query);
        $array = [];

        while($registro = $resultado->fetch_assoc()){
            $array[] = self::crearObjetoPropio($registro);
        }

        return $array;
    }

    public static function graficaBolivares($categoria, $anio){
        if($categoria === 'general'){
            $query = "SELECT SUM(CAST(solicitudes_detalles.total AS DECIMAL(8, 2))) AS total, DATE_FORMAT(fecha_creacion, '%Y-%m') AS fecha FROM ". static::$tabla ." WHERE estatus IN ('listo', 'verificado') AND YEAR(solicitudes_detalles.fecha_creacion) = $anio GROUP BY fecha ORDER BY fecha ASC";
        }else{
            $query = "SELECT SUM(CAST(solicitudes_detalles.total AS DECIMAL(8, 2))) AS total, DATE_FORMAT(fecha_creacion, '%Y-%m') AS fecha FROM ".static::$tabla." WHERE estatus IN ('listo', 'verificado') AND categoria = '$categoria' AND YEAR(solicitudes_detalles.fecha_creacion) = $anio GROUP BY fecha ORDER BY fecha ASC";
        }

        $resultado = self::$db->query($query);
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = self::crearObjetoPropio($registro);
        }

        return $array;
    }

    public static function crearObjetoPropio($registro){

            $objeto = [];

            foreach($registro  as $atributo => $valor){
                $objeto[$atributo] = $valor;
            }
            return $objeto;
    }

    //paginar registros
    public static function paginar($por_pagina, $offset){
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT ${por_pagina} OFFSET ${offset}";
        $resultado = self::consultarSQL($query);
        return  $resultado ;
    }

    //tener un total de ponente
    public static function total($columna = '', $valor = ''){
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        if($columna){
            $query .= " WHERE ${columna} = ${valor}";
        }
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();

        return array_shift($total);
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . "( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('"; 
        $query .= join("', '", array_values($atributos));
        $query .= "') ";

        //debuguear($query); // Descomentar si no te funciona algo

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id,
           'query' => $query
        ];
    }

    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 
        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }
}