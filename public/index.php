<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIAranceles;
use Controllers\APIController;
use Controllers\APIGestion;
use Controllers\APIGraficos;
use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\EstudianteController;
use MVC\Router;

$router = new Router();

//login
$router->get("/", [AuthController::class, 'login']);
$router->post("/", [AuthController::class, 'login']);
$router->get("/crear", [AuthController::class, 'registro']);
$router->get("/olvide", [AuthController::class, 'olvide']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->post('/logout', [AuthController::class, 'logout']);
$router->get('/manual',[AuthController::class, 'manual_login']);

//area de estudiante
$router->get("/estudiante/dashboard",[EstudianteController::class, 'index']);
$router->get("/estudiante/datos-personales",[EstudianteController::class, 'datos_personales']);
$router->get("/estudiante/preguntas-seguridad",[EstudianteController::class, 'preguntas']);
$router->get("/estudiante/password",[EstudianteController::class, 'password']);
$router->post("/estudiante/password",[EstudianteController::class, 'password']);
$router->get("/estudiante/aranceles",[EstudianteController::class, 'arancel']);
$router->get("/estudiante/solicitudes",[EstudianteController::class, 'solicitudes']);
$router->get("/estudiante/reportar-pago",[EstudianteController::class, 'reportar_pago']);
$router->get("/estudiante/solicitudes/pdf",[EstudianteController::class, 'generar_bauche']);
$router->get("/estudiante/manual",[EstudianteController::class, 'manual_estudiante']);

//area de administrador
$router->get("/admin/dashboard",[DashboardController::class, 'index']);
$router->get("/admin/usuarios",[DashboardController::class, 'usuarios']);
$router->get("/admin/aranceles",[DashboardController::class, 'aranceles']);
$router->get("/admin/aranceles/crear",[DashboardController::class, 'crear_arancel']);
$router->get("/admin/aranceles/editar",[DashboardController::class, 'editar_arancel']);
$router->get("/admin/solicitudes",[DashboardController::class, 'solicitudes']);
$router->get("/admin/solicitud-terceros",[DashboardController::class, 'solicitud_terceros']);
$router->get("/admin/solicitudes/arancel",[DashboardController::class, 'ver_solcitud']);
$router->get("/admin/solicitudes/bauche-estudiante",[DashboardController::class, 'generar_bauche']);
$router->get("/admin/categorias",[DashboardController::class, 'categorias']);
$router->get("/admin/backup",[DashboardController::class, 'respaldarBD']);
$router->post("/admin/backup",[DashboardController::class, 'respaldarBD']);
$router->get("/admin/reportes",[DashboardController::class, 'reportes']);
$router->post("/admin/reportes",[DashboardController::class, 'reportes']);
$router->get("/admin/pdf-reporte",[DashboardController::class, 'pdf_reporte']);
$router->get("/admin/perfil",[DashboardController::class, 'perfil']);
$router->get("/admin/manual", [DashboardController::class, 'manual_admin']);

//cron
$router->get("/consulta", [DashboardController::class, 'cron']);

//APIs
$router->post("/api/crearUsuario", [APIController::class, 'crearUsuario']);
$router->post("/api/datos-personales",[APIController::class, 'datos_personales']);
$router->post("/api/guardar-preguntas",[APIController::class, 'preguntas_seguridad']);
$router->post("/api/preguntas",[APIController::class, 'obtener_preguntas']);
$router->post("/api/comprobar-preguntas",[APIController::class, 'comprobar_preguntas']);
$router->post("/api/actualizar-password",[APIController::class, 'cambiar_password']);
//--estudiante---
$router->get("/api/obtener-pnf",[APIAranceles::class, 'obtener_pnf']);
$router->post("/api/aranceles",[APIAranceles::class, 'index']);
$router->post("/api/solicitud",[APIAranceles::class, 'solicitud']);
$router->post("/api/reportar-pago",[APIAranceles::class, 'reportar_pago']);
$router->post("/api/solicitudes",[APIAranceles::class, 'consultar_estatus']);
$router->post("/api/consulta-propia", [APIAranceles::class, 'consulta_propia']);
//------------------
$router->post("/api/usuario-rol",[APIGestion::class, 'usuario_rol']);
$router->post("/api/eliminar-usuario",[APIGestion::class, 'eliminar_usuario']);
$router->post("/api/estatus-usuario",[APIGestion::class, 'cambiar_estatus']);
$router->post("/api/resetPassword",[APIGestion::class, 'reset_user']);
$router->post("/api/crear-arancel",[APIGestion::class, 'crear_arancel']);
$router->post("/api/actualizar-arancel",[APIGestion::class, 'editar_arancel']);
$router->post("/api/eliminar-arancel",[APIGestion::class, 'eliminar_arancel']);
$router->post("/api/actualizar-estatus",[APIGestion::class, 'actualizar_estatus']);
$router->get("/api/obtener-categorias",[APIGestion::class, 'obtener_categorias']);
$router->post("/api/crear-categoria",[APIGestion::class, 'crear_categoria']);
$router->post("/api/editar-categoria",[APIGestion::class, 'editar_categoria']);
$router->post("/api/eliminar-categoria",[APIGestion::class, 'eliminar_categoria']);
$router->post("/api/restaurarBD",[APIGestion::class, 'restaurarBD']);
$router->post("/api/cambiar-passsword",[APIGestion::class, 'cambiar_password']);
$router->post("/api/actualizar-preguntas",[APIGestion::class, 'actualziar_preguntas']);
//---------------------
$router->post("/api/aranceles/meses", [APIGraficos::class, 'aranceles_cantidad']);
$router->post("/api/aranceles/meses-categoria", [APIGraficos::class, 'categoria_grafica']);
$router->post("/api/aranceles/meses-bolivares", [APIGraficos::class, 'bolivares_grafica']);
$router->post("/api/aranceles/actualizar-tasa", [APIGraficos::class, 'actualizar_tasa']);

$router->comprobarRutas();