<?
// Motor autentificación usuarios.

// Cargar datos conexion y otras variables.
require("lg_config.php");

// chequear página que lo llama para devolver errores a dicha página.
$url          = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida = $url[0];
$redir        = $pag_referida; 

// chequear si se llama directo al script o la página sin validarse.
if ($_SERVER['HTTP_REFERER'] == ""){
	die ("Error cod.: 1 Acceso Negado!");
	exit;
}

// Chequeamos si se está autentificandose un usuario por medio del formulario
if (isset($_POST['user']) && isset($_POST['pass'])) {

// Conexión base de datos.
// si no se puede conectar a la BD salimos del script con error 0 y
// redireccionamos a la pagina de error.

$db_conexion = mysql_connect("$DNS", "$USR", "$PASS") or die(header ("Location:  $redir?error_login=0"));
//odbc_select_db("$sql_db");

// realizamos la consulta a la BD para chequear datos del Usuario.
mysql_select_db("$BDATOS",$db_conexion) or die ("No Se puede conectar a la base de datos");

$sql=("SELECT * FROM $tabla WHERE us_usuario = '".$_POST['user']."' ") or die(header ("Location:  $redir?error_login=1"));
$usuario_consulta = mysql_query($sql,$db_conexion);


 // Miramos el total de resultado de la consulta (si es distinto de 0 es que existe el usuario)
 if (mysql_num_rows($usuario_consulta) != 0) {

    // eliminamos barras invertidas y dobles en sencillas
    $login = stripslashes($_POST['user']);
	
    // Si la  password estuviera encriptada aquí habria que hacerlo.
    $password = md5($_POST['pass']);

    // almacenamos datos del Usuario en un array para empezar a chequear.
 	$usuario_datos = mysql_fetch_array($usuario_consulta);
  
    // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.
    mysql_free_result($usuario_consulta);
    // cerramos la Base de dtos.
    mysql_close($db_conexion);
    
    // chequeamos el nombre del usuario otra vez contrastandolo con la BD
    // esta vez sin barras invertidas, etc ...
    // si no es correcto, salimos del script con error 4 y redireccionamos a la
    // página de error.
    if ($login != $usuario_datos['us_usuario']) {
       	Header ("Location: $redir?error_login=4");
		exit;
	}

    // si el password no es correcto ..
    // salimos del script con error 3 y redireccinamos hacia la página de error
    if ($password != $usuario_datos['us_pass']) {
        Header ("Location: $redir?error_login=3");
	    exit;
	}

    // Paranoia: destruimos las variables login y password usadas
    unset($login);
    unset($password);

    // En este punto, el usuario ya esta validado.
    // Grabamos los datos del usuario en una sesion.
    
    // Le damos un nombre a la sesion.
    session_name($usuarios_sesion);
		
	/* establecer el limitador de caché a 'private' */

	/*session_cache_limiter('private');
	$cache_limiter = session_cache_limiter();*/
	
	/* establecer la caducidad de la caché a 120 minutos */
	/*session_cache_expire(300);
	$cache_expire = session_cache_expire();*/

	/* iniciar la sesión */
     // incia sessiones
	 
	ini_set("session.cookie_lifetime", 40000000);
	ini_set("session.gc_maxlifetime", 40000000);

    session_start();

    // Paranoia: decimos al navegador que no "cachee" esta página.
   	session_cache_limiter('nocache,private');
    
    // Asignamos variables de sesión con datos del Usuario para el uso en el
    // resto de páginas autentificadas.

    // definimos usuarios_id como IDentificador del usuario en nuestra BD de usuarios
    $_SESSION['usuario_id']			= $usuario_datos['us_id'];
    
    //definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
    $_SESSION['usuario_login']		= $usuario_datos['us_usuario'];

    //definimos usuario_password con el password del usuario de la sesión actual (formato md5 encriptado)
    $_SESSION['usuario_password']	= $usuario_datos['us_pass'];
	
	//Cargamos el Rut del Usuario en la session por si lo queremos usar para una bienvenida
    $_SESSION['usuario_rut']		= $usuario_datos['us_rut'];	
	
	//Cargamos el Nombre del Usuario en la session por si lo queremos usar para una bienvenida
    $_SESSION['usuario_nombre'] 	= $usuario_datos['us_nombre'];	
	
	//Aquí cargamos el correo del usuario en la sesion
    $_SESSION['usuario_correo'] 	= $usuario_datos['us_correo'];
	
	//Aquí cargamos el correo del usuario en la sesion
    $_SESSION['us_ing_internet'] 	= $usuario_datos['us_ing_internet'];
	
	//Aquí cargamos el correo del usuario en la sesion
    $_SESSION['us_tipo'] 			= $usuario_datos['us_tipo'];
	
	//Aquí cargamos el detalle de permisos
    $_SESSION['usd_sol_lee'] 	= $usuario_datos['usd_sol_lee'];
	$_SESSION['usd_sol_ing'] 	= $usuario_datos['usd_sol_ing'];
	$_SESSION['usd_sol_ap_dep'] = $usuario_datos['usd_sol_ap_dep'];
	$_SESSION['usd_sol_ap_ger'] = $usuario_datos['usd_sol_ap_ger'];
	$_SESSION['usd_sol_ap_bod'] = $usuario_datos['usd_sol_ap_bod'];
	
	$_SESSION['usd_sol_us_bod'] = $usuario_datos['usd_sol_us_bod'];
	$_SESSION['usd_sol_us_adq'] = $usuario_datos['usd_sol_us_adq'];
	
	$_SESSION['usd_cot_lee'] 	= $usuario_datos['usd_cot_lee'];
	$_SESSION['usd_cot_ing'] 	= $usuario_datos['usd_cot_ing'];
	$_SESSION['usd_cot_mod'] 	= $usuario_datos['usd_cot_mod'];
	$_SESSION['usd_cot_eli'] 	= $usuario_datos['usd_cot_eli'];
	
    // Hacemos una llamada a si mismo (scritp) para que queden disponibles
    // las variables de session en el array asociado $HTTP_...
    $pag=$_SERVER['PHP_SELF'];
    Header ("Location: $pag?");
    exit;
    
   } else {
      // si no esta el nombre de usuario en la BD o el password ..
      // se devuelve a pagina q lo llamo con error
      Header ("Location: $redir?error_login=2");
      exit;
   }
} else {
	// -------- Chequear sesión existe -------
	
/******************************************************************************************

*******************************************************************************************/	
	/* establecer el limitador de caché a 'private' */

	/*session_cache_limiter('private');
	$cache_limiter = session_cache_limiter();
	
	//establecer la caducidad de la caché a 120 minutos
	session_cache_expire(120);
	$cache_expire = session_cache_expire();*/
/******************************************************************************************

*******************************************************************************************/

	// usamos la sesion de nombre definido.
	session_name($usuarios_sesion);
	
	// Iniciamos el uso de sesiones
	session_start();

	// Chequeamos si estan creadas las variables de sesión de identificación del usuario,
	// El caso mas comun es el de una vez "matado" la sesion se intenta volver hacia atras
	// con el navegador.
	if (!isset($_SESSION['usuario_login']) && !isset($_SESSION['usuario_password'])){
		// Borramos la sesion creada por el inicio de session anterior
		session_destroy();
		die ("Error cod.: 2 - Acceso incorrecto: Probablemente la sesion a caducado, favor vuelva a validarse! <br><br><br><br>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='../softtime/'>Volver a pagina de inicio</a> ");
		exit;
	}
}
?>
