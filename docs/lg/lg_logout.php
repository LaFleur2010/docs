<?
// Cargamos variables
require ("lg_config.php");
// le damos un nombre a la sesion (por si quisieramos identificarla)
session_name($usuarios_sesion);
// iniciamos sesiones
session_start();
// destruimos la session de usuarios y volvemos.
session_destroy();
Header ("Location: ../index.php");
exit;
?>

